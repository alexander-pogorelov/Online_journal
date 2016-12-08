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
        $user = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User')->find($id);

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
    public function getMessagesAction($id)
    {
        $users = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:UserMessage')->findBy(['user' => $id]);

        $view = $this->view($users, 200);

        return $this->handleView($view);
    }
}