<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 23.12.2016
 * Time: 14:47
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class IndexController extends Controller
{
    public function teacherAction($id) {

        $teacher = $this->getObject('Application\Sonata\UserBundle\Entity\UserTeacher', $id);
        // Если объект учителя не найден, выбрасываем исключение
        if(!$teacher) {
            throw $this->createNotFoundException(sprintf('unable to find the teacher with id : %s', $id));
        }

        $currentUser = $this->getUser();
        // Если текущий пользователь не админ, и его ID не совпадает с запрашиваемым, выбрасываем исключение
        if($currentUser->getId() != $id && !$currentUser->hasRole('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException(sprintf(
                "Access Denied. You do not have permission to access the teacher's cabinet with id : %s", $id
            ));
        }

        return new Response(
            '<html><body>Кабинет преподавателя с id: '.$id.'.<p>'.$teacher->__toString().'</p></body></html>'
        );
    }

    public function pupilAction($id) {

        $pupil = $this->getObject('Application\Sonata\UserBundle\Entity\UserPupil', $id);
        // Если объект ученика не найден, выбрасываем исключение
        if(!$pupil) {
            throw $this->createNotFoundException(sprintf('unable to find the pupil with id : %s', $id));
        }

        $currentUser = $this->getUser();
        $currentUserId = $currentUser->getId();

        // Получаем массив ID учеников, связанных с родителем
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:UserPupil');
        $pupilIdArray = $repository->findAllIdByParent($currentUserId);

        $isParent = in_array($id, $pupilIdArray);

        // Если текущий пользователь не админ, и не является родственником текущего ученика, выбрасываем исключение
        if(!$isParent && !$currentUser->hasRole('ROLE_SUPER_ADMIN')) {
            throw $this->createAccessDeniedException(sprintf(
                "Access Denied. You do not have permission to access the pupil's cabinet with id : %s", $id
            ));
        }

        return new Response(
            '<html><body>Кабинет ученика с id: '.$id.'.<p>'.$pupil->__toString().'</p></body></html>'
        );
    }

    private function getObject($classObject, $id) {
        $modelManager = $this->getDoctrine()->getManager();
        $object = $modelManager->find($classObject, array('id' => $id));
        if($object) {
            return $object;
        } else {
            return false;
        }
    }
}