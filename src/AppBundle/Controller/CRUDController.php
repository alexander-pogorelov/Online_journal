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

        return $this->render('AppBundle:GroupAdmin:pupils_how.html.twig', [
            'action'=>'showPupilsInGroup',
            'object' => $object,
        ]);
    }
}