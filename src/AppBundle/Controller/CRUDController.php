<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 02.11.2016
 * Time: 17:37
 */

namespace AppBundle\Controller;

use Application\Sonata\UserBundle\ApplicationSonataUserBundle;
use Application\Sonata\UserBundle\Entity\Journal;
use Application\Sonata\UserBundle\Entity\Subject;
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

        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:GroupIteen');
        $currentGroup = $repository->find($groupId);
        // список предметов группы
        $subjectList = $currentGroup->getSubjects();

        ////////
        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');
        $qb = $repository->createQueryBuilder('pga');
        $query = $qb
            ->leftJoin('pga.journal', 'j')
            ->leftJoin('j.lesson', 'l')
            ->addSelect('j')
            ->addSelect('l')
            //->where('pga.group = :groupId')
            ->where($qb->expr()->eq('pga.group', $groupId))
            //->setParameter('groupId', $groupId)
            ->getQuery()
        ;
        //    ->leftJoin()
         //   ->where('g.id = :groupId')
         //   ->setParameter('groupId', $groupId)
         //   ->getQuery()
        //;
        //$repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:Journal');
        //$query = $repository->createQueryBuilder('j')
         //   ->leftJoin('j.pupilGroup', 'pga')
          //  ->innerJoin()
          //  ->getQuery()
        //;


        $result = $query->getResult();
        //$result = $query->getArrayResult();
        $sql = $query->getSql();




        $repository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');

        $pupilGroup = $repository->findby([
            'group' => $groupId
        ]);



        $this->admin->checkAccess('show', $objectSubject);

        $preResponse = $this->preShow($request, $objectSubject);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($objectSubject);

        return $this->render('AppBundle:JournalAdmin:journal_show.html.twig', [
            'action' => 'show',
            'elements' => $this->admin->getShow(),
            'pupilGroup' => $pupilGroup,
            'subjectList' => $subjectList,
            'object' => $objectSubject, // нужен для роутов
            'groupName' => $groupName,
            'groupId' => $groupId,
            'sql' => $sql,
            'result' => $result,
        ], null);
    }

}