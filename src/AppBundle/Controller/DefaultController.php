<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $currentUser = $this->getUser();
        if (!$currentUser) {
            return new RedirectResponse($this->generateUrl('fos_user_security_login'));
        } else {
            $url = $this->container->get('app_success_handler')->getUrl($currentUser);
            $this->addFlash('sonata_flash_error', 'Вы уже вошли.');
            return new RedirectResponse($url);
        }
    }
}
