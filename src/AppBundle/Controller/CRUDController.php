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
        //$pupilsIdList = ltrim($pupilsIdList, ', ');
        //$pupilsInGroup = $query->getResult();

        $this->admin->checkAccess('show', $object);

        $preResponse = $this->preShow($request, $object);
        if ($preResponse !== null) {
            return $preResponse;
        }

        $this->admin->setSubject($object);


        return $this->render('AppBundle:GroupAdmin:pupils_how.html.twig', [
            'action'=>'showPupilsInGroup',
            'object' => $object,
            'pupilGroupAssociations' => $pupilGroupAssociations,
            'pupilsObjects' => $pupilsObjects,
            'elements' => $this->admin->getShow(),
        ]);
    }
}