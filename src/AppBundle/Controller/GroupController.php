<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 29.11.2016
 * Time: 22:51
 */

namespace AppBundle\Controller;


class GroupController extends MainController
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
}