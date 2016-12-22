<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 18.12.2016
 * Time: 12:39
 */

namespace AppBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MainController extends Controller
{
    public function batchActionDelete(ProxyQueryInterface $query)
    {
        try {
            return parent::batchActionDelete($query);

        } catch (ModelManagerException $e) {

            $inRoute = $this->getRequest()->get('_route');
            $outRoute = str_replace('batch', 'list', $inRoute);
            $this->addFlash('sonata_flash_error', 'Невозможно удалить объект или объекты, связанные с другими объектами.');

            return new RedirectResponse($this->generateUrl($outRoute));
        }
    }
}