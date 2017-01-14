<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 06.12.2016
 * Time: 18:29
 */

namespace AppBundle\Controller;

use Application\Sonata\UserBundle\Entity\PupilGroupAssociation;
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
    public function getUsersAction(Request $request)
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
     * @return array
     * @View(serializerGroups={"schedules"})
     */
    public function getSchedulesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $teachers = $em->getRepository('ApplicationSonataUserBundle:Schedule')->getDistinctTeachers();
        $groups = $em->getRepository('ApplicationSonataUserBundle:Schedule')->getDistinctGroups();
        $classrooms = $em->getRepository('ApplicationSonataUserBundle:Schedule')->getDistinctClassrooms();
        $timeIntervals = $em->getRepository('ApplicationSonataUserBundle:TimeInterval')->findAll();
        $schedule = $em->getRepository('ApplicationSonataUserBundle:Schedule')->scheduleKeysArray();
        $schedules = ['teachers'=>$teachers,
                'groups'=>  $groups,
                'classrooms'=>  $classrooms,
                'timeIntervals'=>  $timeIntervals,
                'schedules'=>  $schedule
                ];
        if (!$schedules) {
            throw new NotFoundHttpException('Schedule not found');
        }

        $view = $this->view($schedules, 201);

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

        if (!$message) {
            throw new NotFoundHttpException('No message found');
        }

        $view = $this->view($message, 200);

        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"lesson"})
     * @ApiDoc(
     *  description="Get lesson",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="group id"
     *     }
     *  },
     *  output="Application\Sonata\UserBundle\Entity\Lesson"
     * )
     */
    public function getLessonAction($id)
    {
        $lesson = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:Lesson')
            ->findBy(['group' => $id]);

        if (!$lesson) {
            throw new NotFoundHttpException('No lesson found');
        }

        $view = $this->view($lesson, 200);

        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @View(serializerGroups={"journal"})
     * @ApiDoc(
     *  description="Get journal",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="group id"
     *     }
     *  },
     *  output="Application\Sonata\UserBundle\Entity\Journal"
     * )
     */
    public function getJournalAction($id)
    {
        $pupilGroup = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation')
            ->findBy(['pupil' => $id]);

        $journal = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:Journal')
            ->findBy(['pupilGroup' => $pupilGroup]);

        $view = $this->view($journal, 200);

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


    /**
     * @param $id
     * @return Response
     *
     * @ApiDoc(
     *  description="Get Group's list",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="pupil id"
     *     }
     *  },
     *     output="Application\Sonata\UserBundle\Entity\Groupiteen"
     * )
     */
    public function getGroupsAction($id) {

        $this->checkUser($id);

        $pga = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation')
            ->findBy([
                'pupil' => $id
            ]);

        if ($pga === []) {
            throw new NotFoundHttpException('Groups not found');
        }

        $groups = array_map(function ($pga) {
            return $pga->getGroup();
        }, $pga);

        $view = $this->view($groups, 200);
        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return Response
     * @ApiDoc(
     *  description="Get Subject's list",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="group id"
     *     }
     *  },
     *     output="Application\Sonata\UserBundle\Entity\Subject"
     * )
     *
     */
    public function getSubjectsAction($id) {

        $group = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:GroupIteen')
            ->find($id);

        if (!$group) {
            throw new NotFoundHttpException('Group not found');
        }

        $subjects = $group->getSubjects();

        if (count($subjects) == 0) {
            throw new NotFoundHttpException('Group has not subjects');
        }

        $view = $this->view($subjects->toArray(), 200);
        return $this->handleView($view);
    }

    /**
     * @param $id
     * @return Response
     *
     * @ApiDoc(
     *  description="Get related pupil ID array",
     *  requirements={
     *     {
     *         "name"="id",
     *         "dataType"="integer",
     *         "requirement"="\d+",
     *         "description"="pupil id"
     *     }
     *  }
     * )
     */
    public function getRelationAction($id) {

        $user = $this->checkUser($id);
        $relatedPupils = [$id];
        $parents = $user->getParents()->toArray();

        foreach ($parents as $parent) {
            // ищем ID учеников по родителю
            $childIdArray = $this->getDoctrine()
                ->getRepository('ApplicationSonataUserBundle:UserPupil')
                ->findAllIdByParent($parent->getId());
            // находим новые ID учеников
            $newPupilId = array_diff($childIdArray, $relatedPupils);
            // добавляем новые ID учеников
            $relatedPupils = array_merge($relatedPupils, $newPupilId);
        }
        // удаляем ID запрашиваемого ученика из итогового массива
        unset($relatedPupils[0]);
        // пересобираем массив
        $resultArray = [];
        foreach ($relatedPupils as $relatedPupil) {
            $resultArray[] = $relatedPupil;
        }

        $view = $this->view($resultArray, 200);
        return $this->handleView($view);
    }

    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
    }

    private function checkUser($id) {

        $user = $this->getDoctrine()
            ->getRepository('ApplicationSonataUserBundle:User')
            ->find($id);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        return $user;
    }
}