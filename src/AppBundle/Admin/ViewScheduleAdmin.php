<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ViewScheduleAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'viewschedule';
    protected $baseRouteName = 'viewschedule-route-admin';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list'));
    }
}