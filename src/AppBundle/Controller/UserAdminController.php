<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 29.12.2016
 * Time: 16:12
 */

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;


class UserAdminController extends Controller
{
    public function editAction($id = null)
    {
        // редактирование всех юзеров, кроме админа, должно быть через их админские классы
        $currentUserId = $this->getUser()->getId();
        if($currentUserId != $id) {
            $this->addFlash('sonata_flash_error', 'Необходимо редактировать данные пользователя только через стандартное меню.');
            return new RedirectResponse($this->generateUrl('sonata_admin_dashboard'));
        } else {
            return parent::editAction($id);
        }
    }
}