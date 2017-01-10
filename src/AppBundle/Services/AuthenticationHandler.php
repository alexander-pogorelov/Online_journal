<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 23.12.2016
 * Time: 13:27
 */

namespace AppBundle\Services;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();

        $url = $this->getUrl($user);

        return new RedirectResponse($url);
    }

    public function getUrl($user) {

        $userId = $user->getId();

        if($user->hasRole('ROLE_SUPER_ADMIN') || $user->hasRole('ROLE_METODIST')){

            $url = $this->container->get('router')->generate('sonata_admin_dashboard');

        }

        if($user->hasRole('ROLE_PARENT')) {

            $repository = $this->container->get('doctrine')->getRepository('ApplicationSonataUserBundle:UserPupil');
            $pupil = $repository->findAnyByParent($userId);

            if(!$pupil) {
                throw new AccessDeniedException(sprintf('Access Denied. There is no associated pupils with parent with id : %s', $userId));
            }

            $url = $this->container->get('router')->generate('app_pupul_cabinet', [
                'id' => $pupil->getId()
            ]);

        }

        if ($user->hasRole('ROLE_TEACHER')) {

            $url = $this->container->get('router')->generate('app_teacher_cabinet', [
                'id' => $userId
            ]);
        }

        return $url;
    }
}