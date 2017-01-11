<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 08.01.2017
 * Time: 11:48
 */

namespace AppBundle\Controller;

use Sonata\UserBundle\Controller\SecurityFOSUser1Controller as SecurityFOSUserController;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


class SecurityController extends SecurityFOSUserController
{
    public function loginAction()
    {
        $token = $this->container->get('security.context')->getToken();

        if ($token && $token->getUser() instanceof UserInterface) {
            // если пользователь уже залогинился, перенаправляем его в зависимости от роли
            $user = $token->getUser();
            $url = $this->container->get('app_success_handler')->getUrl($user);
            $session = $this->container->get('session');
            $session->getFlashBag()->add('sonata_flash_error', 'Вы уже вошли.');

            return new RedirectResponse($url);
        }

        /*
            Implementation of parent::loginAction
            Needed for fixing the "Bad Credentials" translation problem
            The code is a mix of the 2.0.0 version
            and the 1.3.6 version of FOSUserBundle
        */

        /** @var $request \Symfony\Component\HttpFoundation\Request */
        $request = $this->container->get('request');
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        return $this->renderLogin(array(
            'last_username' => (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME),
            'error' => $error,
            'csrf_token' => $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate'),
        ));
    }
}