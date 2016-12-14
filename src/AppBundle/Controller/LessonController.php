<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 29.11.2016
 * Time: 21:56
 */

namespace AppBundle\Controller;

use Application\Sonata\UserBundle\Entity\Journal;
use Sonata\AdminBundle\Controller\CRUDController as Controller;

class LessonController extends Controller
{
    public function editAction($id = null)
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        ////////////////////////////////////////////////////////////

        // Извлекаем Учеников-Группы
        $currentPupilGroupAssociations = $this->getCurrentPupilGroupAssociations($object);

        // Извлекаем журналы урока
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:Journal');
        $currentJournals = $repository->findBy([
            'lesson' => $id
        ]);
        // Создаем ассоциативный массив журналов урока с ключом ID Ученик-Группа
        $currentJournalsArrayWithPgaIdKey =[];
        foreach ($currentJournals as $currentJournal) {
            $currentJournalsArrayWithPgaIdKey[$currentJournal->getPupilGroup()->getId()] = $currentJournal;
        }
        /////////////////////////////////////////////////////

        $this->admin->checkAccess('edit', $object);

        $preResponse = $this->preEdit($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                try {
                    $object = $this->admin->update($object);

                    ////////////////////////////////////////////////////////////////
                    $em = $this->getDoctrine()->getManager();
                    // проходим по всем ученикам группы
                    foreach ($currentPupilGroupAssociations as $currentPupilGroupAssociation) {
                        // получаем оценку и замечание из формы
                        $pgaId = $currentPupilGroupAssociation->getId();
                        $pupilReport = $form->get($pgaId);
                        $assessment = $pupilReport->get('assessment')->getData();
                        $remark = $pupilReport->get('remark')->getData();
                        // если поля оценки или замечания непустые
                        if ($assessment || $remark) {
                            // если есть объект журнала
                            if (array_key_exists($pgaId, $currentJournalsArrayWithPgaIdKey)) {
                                // получаем объект журнала
                                $currentJournal = $currentJournalsArrayWithPgaIdKey[$pgaId];
                            } else {
                                // иначе создаем новый объект журнала и добавляем Ученика-Группу и Урок
                                $currentJournal = $this->createNewJournal($object, $currentPupilGroupAssociation);
                            }
                            // Добавляем в журнал оценку и замечание
                            $this->updateCurrentJournal($em, $currentJournal, $assessment, $remark);
                        } else { // если оценка и замечание удалены, удаляем запись в журнале
                            if (array_key_exists($pgaId, $currentJournalsArrayWithPgaIdKey)) {
                                $em->remove($currentJournalsArrayWithPgaIdKey[$pgaId]);
                            }
                        }
                    }
                    $em->flush();
                    ////////////////////////////////////////////////////////////////////

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                            'objectName' => $this->escapeHtml($this->admin->toString($object)),
                        ), 200, array());
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->trans(
                            'flash_edit_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                } catch (LockException $e) {
                    $this->addFlash('sonata_flash_error', $this->trans('flash_lock_error', array(
                        '%name%' => $this->escapeHtml($this->admin->toString($object)),
                        '%link_start%' => '<a href="'.$this->admin->generateObjectUrl('edit', $object).'">',
                        '%link_end%' => '</a>',
                    ), 'SonataAdminBundle'));
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->trans(
                            'flash_edit_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // enable the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'edit',
            'form' => $view,
            'object' => $object,
        ), null);
    }



    public function createLessonAction($groupId, $subjectId)
    {
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:GroupIteen');
        if (!$repository->find($groupId)) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $groupId));
        }
        $currentGroup = $repository->find($groupId);

        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:Subject');
        if (!$repository->find($subjectId)) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $subjectId));
        }

        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:TeacherSubject');
        $defaultTeacherSubject = $repository->findBySubjectByMaxId($subjectId);

        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'createLesson';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ($class->isAbstract()) {
            return $this->render(
                'SonataAdminBundle:CRUD:select_subclass.html.twig',
                array(
                    'base_template' => $this->getBaseTemplate(),
                    'admin' => $this->admin,
                    'action' => 'create',
                ),
                null,
                $request
            );
        }

        $object = $this->admin->getNewInstance();
        $object->setGroup($currentGroup);
        $object->setTeacherSubject($defaultTeacherSubject);

        $preResponse = $this->preCreate($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //TODO: remove this check for 4.0
            if (method_exists($this->admin, 'preValidate')) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode($request) || $this->isPreviewApproved($request))) {
                $this->admin->checkAccess('create', $object);

                try {
                    $object = $this->admin->create($object);

                    ////////////////////////////////////////////////////////
                    if ($object) {
                        // Извлекаем Учеников-Группы
                        $currentPupilGroupAssociations = $this->getCurrentPupilGroupAssociations($object);
                        $em = $this->getDoctrine()->getManager();
                        // проходим по всем ученикам группы
                        foreach ($currentPupilGroupAssociations as $currentPupilGroupAssociation) {
                            // получаем оценку и замечание из формы
                            $pgaId = $currentPupilGroupAssociation->getId();
                            $pupilReport = $form->get($pgaId);
                            $assessment = $pupilReport->get('assessment')->getData();
                            $remark = $pupilReport->get('remark')->getData();
                            // если есть оценка или замечание
                            if ($assessment || $remark) {
                                // создаем новый объект журнала и добавляем Ученика-Группу и Урок
                                $currentJournal = $this->createNewJournal($object, $currentPupilGroupAssociation);
                                // Добавляем в журнал оценку и замечание
                                $this->updateCurrentJournal($em, $currentJournal, $assessment, $remark);
                            }
                        }
                        $em->flush();
                    }
                    ////////////////////////////////////////////////////////

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result' => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ), 200, array());
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->trans(
                            'flash_create_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->trans(
                            'flash_create_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('Symfony\Bridge\Twig\Extension\FormExtension')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'createLesson',
            'form' => $view,
            'object' => $object,
            'groupId' => $groupId,
            'subjectId' => $subjectId
        ), null);
    }

    private function getCurrentPupilGroupAssociations($object) {
        $currentGroup = $object->getGroup();
        // Извлекаем Учеников-Группы
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');
        $currentPupilGroupAssociations = $repository->findBy([
            'group' => $currentGroup
        ]);

        return $currentPupilGroupAssociations;
    }

    private function createNewJournal($object, $currentPupilGroupAssociation) {
        // создаем новый объект журнала
        $currentJournal = New Journal();
        // добавляем Ученика-Группу и Урок
        $currentJournal->setPupilGroup($currentPupilGroupAssociation);
        $currentJournal->setLesson($object);

        return $currentJournal;
    }

    private function updateCurrentJournal($em, $currentJournal, $assessment, $remark) {
        // Добавляем в журнал оценку и замечание
        $currentJournal->setAssessment($assessment);
        $currentJournal->setRemark($remark);
        $em->persist($currentJournal);
    }

}