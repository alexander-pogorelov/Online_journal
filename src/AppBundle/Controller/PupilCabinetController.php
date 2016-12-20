<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 06.12.2016
 * Time: 18:29
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;
use AppBundle\Form\MessageType;

class PupilCabinetController extends FOSRestController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"user"})
     */
    public function getUsersAction()
    {
        $users = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User')->findAll();

        $view = $this->view($users, 200);
        return $this->handleView($view);
    }


    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"user"})
     */
    public function getUserAction($id)
    {
        $user = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:User')
            ->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $view = $this->view($user, 200);
        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"message"})
     */
    public function getMessageAction($id)
    {
        $message = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:UserMessage')
            ->findBy(['user' => $id]);

        $view = $this->view($message, 200);

        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"message"})
     */
    public function putMessageAction($id, Request $request)
    {
        $message = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:UserMessage')
            ->findOneById($id);

        if (!$message) {
            throw new NotFoundHttpException('No message found');
        }

        $form = $this->createForm(new MessageType(), $message);
        $this->processForm($request, $form);

        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        $view = $this->view($message, 200);

        return $this->handleView($view);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"message"})
     */
    public function patchMessagesAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $response = array();

        foreach ($data as $array) {
            if (is_array($array)) {
                $id = $array['id'];
                $status['status'] = $array['status'];

                $message = $this->getDoctrine()
                    ->getRepository('ApplicationSonataUserBundle:UserMessage')
                    ->findOneById($id);

                if (!$message) {
                    throw new NotFoundHttpException('No message found');
                }

                $form = $this->createForm(new MessageType(), $message);
                $form->submit($status);

                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();

                $response[] = $message;
            } else {
                $id = $data['id'];
                $status['status'] = $data['status'];

                $message = $this->getDoctrine()
                    ->getRepository('ApplicationSonataUserBundle:UserMessage')
                    ->findOneById($id);

                if (!$message) {
                    throw new NotFoundHttpException('No message found');
                }

                $form = $this->createForm(new MessageType(), $message);
                $form->submit($status);

                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();

                $response[] = $message;
                break;
            }
        }
        $view = $this->view($response, 200);

        return $this->handleView($view);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"message"})
     */
    public function deleteMessagesAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data as $array) {
            if (is_array($array)) {
                $id = $array['id'];

                $message = $this->getDoctrine()
                    ->getRepository('ApplicationSonataUserBundle:UserMessage')
                    ->findOneById($id);

                if ($message) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($message);
                    $em->flush();
                }
            } else{
                $id = $data['id'];

                $message = $this->getDoctrine()
                    ->getRepository('ApplicationSonataUserBundle:UserMessage')
                    ->findOneById($id);

                if ($message) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($message);
                    $em->flush();
                    break;
                }
            }
        }

        $view = $this->view(null, 204);

        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"message"})
     */
    public function deleteMessageAction($id)
    {
        $message = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:UserMessage')
            ->findOneById($id);

        if ($message) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        $view = $this->view(null, 204);

        return $this->handleView($view);
    }

    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }
}