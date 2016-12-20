<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 10.11.2016
 * Time: 17:43
 */

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Application\Sonata\UserBundle\Entity\UserMessage;

class MessageController extends Controller
{
    public function createAction()
    {
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

            $sender = $this->get('security.token_storage')->getToken()->getUser();
            $object->setSender($sender);

            $idUser = [];
            $receivers = [];
            $groupIteenToArray = [];

            $messageGroup = $form['messageGroup']->getData();
            $groupIteen = $form['groupIteen']->getData();

            $messageGroupToArray = explode(', ', $messageGroup);

            if(!empty($groupIteen)){
                $groupIteenToArray = explode(', ', $groupIteen);
            }

            foreach ($form['userMessage']->getData() as $userMessage){
                $user = $userMessage->getUser();
                $receivers[] = $user;
                $idUser[] = $user->getId();
            }

            if(in_array(1, $messageGroupToArray)){
                $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User')->findAll();
                foreach ($repository as $user) {
                    if (!in_array($user->getId(), $idUser)) {
                        $userMessage = new UserMessage($user, $object);
                        $object->addUserMessage($userMessage);
                        $idUser[] = $user->getId();
                    }
                }
            }
            if(in_array(2, $messageGroupToArray)){
                $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:UserMetodist')->findAll();
                foreach ($repository as $user) {
                    if (!in_array($user->getId(), $idUser)) {
                        $userMessage = new UserMessage($user, $object);
                        $object->addUserMessage($userMessage);
                        $idUser[] = $user->getId();
                    }
                }
            }
            if(in_array(3, $messageGroupToArray)){
                $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:UserTeacher')->findAll();
                foreach ($repository as $user) {
                    if (!in_array($user->getId(), $idUser)) {
                        $userMessage = new UserMessage($user, $object);
                        $object->addUserMessage($userMessage);
                        $idUser[] = $user->getId();
                    }
                }
            }
            if(in_array(4, $messageGroupToArray)){
                $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:UserPupil')->findAll();
                foreach ($repository as $user) {
                    if (!in_array($user->getId(), $idUser)) {
                        $userMessage = new UserMessage($user, $object);
                        $object->addUserMessage($userMessage);
                        $idUser[] = $user->getId();
                    }
                }
            }

            $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');

                foreach($groupIteenToArray as $groupId) {
                    $group = $repository->findBy(['group' => $groupId]);
                    foreach ($group as $pga) {
                        $pupil = $pga->getPupil();
                        if (!in_array($pupil->getId(), $idUser)) {
                            $userMessage = new UserMessage($pupil, $object);
                            $object->addUserMessage($userMessage);
                            $idUser[] = $pupil->getId();
                        }
                    }
                }

            $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:GroupIteen');
            $groupName = [];

            if(!empty($groupIteenToArray)) {
                foreach ($groupIteenToArray as $groupId) {
                    $group = $repository->findOneBy(['id' => $groupId]);
                    $groupName[] = $group->getGroupName();
                }
            }

            $groupNameString = implode(', ', $groupName);
            $receiversString = implode(', ', $receivers);
            $now = time();

            $object->setGroupIteen($groupNameString);
            $object->setReceiver($receiversString);
            $object->setDatetime($now);

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
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form' => $view,
            'object' => $object,
        ), null);
    }

}