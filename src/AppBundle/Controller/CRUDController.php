<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 02.11.2016
 * Time: 17:37
 */

namespace AppBundle\Controller;

use Application\Sonata\UserBundle\ApplicationSonataUserBundle;
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
        $subjectList = $currentGroup->getSubjects(); // список предметов группы


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
            'object' => $objectSubject, // изменить на имя предмета и предать другой объект
            'groupName' => $groupName,
            'subjectId' => $subjectId,
            'groupId' => $groupId,
        ], null);
    }

}