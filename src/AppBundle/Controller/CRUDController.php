<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 02.11.2016
 * Time: 17:37
 */

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class CRUDController extends Controller
{
    public function createLessonAction($groupId, $subjectId)
    {
        //echo $groupId;
        //echo "<br>";
        //echo $subjectId;
        //exit;
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:GroupIteen');
        $currentGroup = $repository->find($groupId);
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:TeacherSubject');
        $defaultTeacherSubject = $repository->findBySubjectByMaxId($subjectId);
        dump($defaultTeacherSubject);


        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

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
            'action' => 'create',
            'form' => $view,
            'object' => $object,
        ), null);
    }

    public function showPupilsInGroupAction($id = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');

        $pupilGroupAssociations = $repository->findBy([
            'group' => $id
        ]);

        $pupilsObjects = [];
        foreach ($pupilGroupAssociations as $pupilGroupAssociation) {
            $pupilsObjects[] = $pupilGroupAssociation->getPupil();
        }

        $this->admin->checkAccess('show', $object);

        $preResponse = $this->preShow($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);


        return $this->render('AppBundle:GroupAdmin:pupils_show.html.twig', [
            'action'=>'showPupilsInGroup',
            'object' => $object,
            'pupilsObjects' => $pupilsObjects,
            'elements' => $this->admin->getShow(),
        ]);
    }

    public function showAction($id = null)
    {
        $request = $this->getRequest();
        // ID предмета
        $subjectId = $request->get($this->admin->getIdParameter());
        // ID группы
        $groupId = $request->get($this->admin->getParent()->getIdParameter());
        // Объект группы
        $objectGroup = $this->admin->getParent()->getObject($groupId);
        // Имя группы
        $groupName = $objectGroup->getGroupName();
        // Объект предмета
        $objectSubject = $this->admin->getObject($subjectId);

        if (!$objectSubject) {
            throw $this->createNotFoundException(sprintf('unable to find the objectSubject with id : %s', $subjectId));
        }
        if (!$objectGroup) {
            throw $this->createNotFoundException(sprintf('unable to find the objectGroup with id : %s', $groupId));
        }

        // Извлекаем список предметов группы
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:GroupIteen');
        $currentGroup = $repository->find($groupId);
        $subjectList = $currentGroup->getSubjects();

        // Извлекаем список уроков группы по предмету, используя кастомный репозиторий
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:Lesson');
        $lessonsList = $repository->findBySubjectAndGroup($subjectId, $groupId);

        // Извлекаем список всех журналов для учеников группы, используя кастомный репозиторий
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');
        $journalsData = $repository->findAllJournals($groupId);

        $this->admin->checkAccess('show', $objectSubject);

        $preResponse = $this->preShow($request, $objectSubject);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($objectSubject);

        return $this->render('AppBundle:JournalAdmin:journal_show.html.twig', [
            'action' => 'show',
            'elements' => $this->admin->getShow(),
            'subjectList' => $subjectList,
            'object' => $objectSubject,
            'groupName' => $groupName,
            'groupId' => $groupId,
            'journalsData' => $journalsData,
            'lessonsList' => $lessonsList,
        ], null);
    }

}