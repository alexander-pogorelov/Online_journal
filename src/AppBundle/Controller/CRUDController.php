<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 02.11.2016
 * Time: 17:37
 */

namespace AppBundle\Controller;

//use Application\Sonata\UserBundle\ApplicationSonataUserBundle;
//use Application\Sonata\UserBundle\Entity\Journal;
//use Application\Sonata\UserBundle\Entity\Subject;
use Sonata\AdminBundle\Controller\CRUDController as Controller;

class CRUDController extends Controller
{
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

        // Извлекаем список уроков группы по предмету
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:Lesson');
        $qb = $repository->createQueryBuilder('l');
        $query = $qb
            ->leftJoin('l.teacherSubject', 'ts')
            ->where($qb->expr()->eq('ts.subject', $subjectId))
            ->andWhere($qb->expr()->isNotNull('l.topic')) // запрашиваем только проведенные уроки
            ->andWhere($qb->expr()->eq('l.group', $groupId))
            ->getQuery()
        ;
        $lessonsList = $query->getResult();


        // Извлекаем список журналов и уроков для учеников группы
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');
        $qb = $repository->createQueryBuilder('pga');
        $query = $qb
            ->leftJoin('pga.journal', 'j')
            ->leftJoin('j.lesson', 'l')
            ->addSelect('j')
            ->addSelect('l')
            ->where($qb->expr()->eq('pga.group', $groupId))
            ->getQuery()
        ;
        $journalsData = $query->getResult();



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