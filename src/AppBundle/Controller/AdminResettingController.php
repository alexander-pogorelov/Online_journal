<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 07.01.2017
 * Time: 12:58
 */

namespace AppBundle\Controller;

use Sonata\UserBundle\Controller\AdminResettingController as Controller;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AdminResettingController extends Controller
{
    public function resetAction($token)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // если пользователь уже прошел аутентификацию - перенаправляем его в зависимости от роли
            $user = $this->container->get('security.context')->getToken()->getUser();
            $url = $this->container->get('app_success_handler')->getUrl($user);

            return new RedirectResponse($url);
        }

        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        if (!$user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            return new RedirectResponse($this->container->get('router')->generate('sonata_user_admin_resetting_request'));
        }

        $form = $this->container->get('fos_user.resetting.form');
        $formHandler = $this->container->get('fos_user.resetting.form.handler');
        $process = $formHandler->process($user);

        if ($process) {
            $this->setFlash('fos_user_success', 'resetting.flash.success');
            //выбираем маршрут переадресации в зависимости от роли пользователя
            $url = $this->container->get('app_success_handler')->getUrl($user);
            $response = new RedirectResponse($url);
            $this->authenticateUser($user, $response);

            return $response;
        }

        return $this->container->get('templating')->renderResponse('SonataUserBundle:Admin:Security/Resetting/reset.html.'.$this->getEngine(), array(
            'token' => $token,
            'form' => $form->createView(),
            'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
            'admin_pool' => $this->container->get('sonata.admin.pool'),
        ));
    }

    public function sendEmailAction()
    {
        $username = $this->container->get('request')->request->get('username');

        /** @var $user UserInterface */
        $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            return $this->container->get('templating')->renderResponse('SonataUserBundle:Admin:Security/Resetting/request.html.'.$this->getEngine(), array(
                'invalid_username' => $username,
                'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                'admin_pool' => $this->container->get('sonata.admin.pool'),
            ));
        }

        if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            return $this->container->get('templating')->renderResponse('SonataUserBundle:Admin:Security/Resetting/passwordAlreadyRequested.html.'.$this->getEngine(), array(
                'base_template' => $this->container->get('sonata.admin.pool')->getTemplate('layout'),
                'admin_pool' => $this->container->get('sonata.admin.pool'),
            ));
        }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator TokenGeneratorInterface */
            $tokenGenerator = $this->container->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->container->get('session')->set(static::SESSION_EMAIL, $this->getObfuscatedEmail($user));
        // заменяем на свой Mailer-сервис
        $this->container->get('app.mailer.default')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->container->get('fos_user.user_manager')->updateUser($user);

        return new RedirectResponse($this->container->get('router')->generate('sonata_user_admin_resetting_check_email'));
    }
}