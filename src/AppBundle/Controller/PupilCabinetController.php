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
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PupilCabinetController extends FOSRestController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"user"})
     * @ApiDoc(
     *  description="Get list of uses",
     *  output="Application\Sonata\UserBundle\Entity\User"
     * )
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
     * @ApiDoc(
     *  description="Get one user",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="user id"
     *     }
     *  },
     *  output="Application\Sonata\UserBundle\Entity\User"
     * )
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
     * @View(serializerGroups={"schedule"})
     * @ApiDoc(
     *  description="Get schedule",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="group id"
     *     }
     *  },
     *  output="Application\Sonata\UserBundle\Entity\Schedule"
     * )
     */
    public function getScheduleAction($id)
    {
        $schedule = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:Schedule')
            ->findBy(['group' => $id]);

        if (!$schedule) {
            throw new NotFoundHttpException('Schedule not found');
        }

        $view = $this->view($schedule, 200);

        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"message"})
     * @ApiDoc(
     *  description="Get one message",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="message id"
     *     }
     *  },
     *  output="Application\Sonata\UserBundle\Entity\UserMessage"
     * )
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
     * @ApiDoc(
     *  description="Update one message status",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="message id"
     *     },
     *     {
     *         "name"="status",
     *         "dataType"="array",
     *         "requirement"="\d+",
     *         "description"="array with message status: 1(read) or 0 (not read)"
     *     }
     *  },
     *  output="Application\Sonata\UserBundle\Entity\UserMessage"
     * )
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
     * @ApiDoc(
     *  description="Update message status(many)",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="array",
     *         "requirement"="\d+",
     *         "description"="array with message id"
     *     },
     *     {
     *         "name"="status",
     *         "dataType"="array",
     *         "requirement"="\d+",
     *         "description"="array with message status: 1(read) or 0 (not read)"
     *     }
     *  },
     *  output="Application\Sonata\UserBundle\Entity\UserMessage"
     * )
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
     * @ApiDoc(
     *  description="Deleting messages(many)",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="array",
     *         "requirement"="\d+",
     *         "description"="array with message id"
     *     }
     *  }
     * )
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
     * @ApiDoc(
     *  description="Delete one message",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="message id"
     *     }
     *  }
     * )
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