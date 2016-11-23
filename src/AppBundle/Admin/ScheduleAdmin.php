<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class ScheduleAdmin extends AbstractAdmin
{
    protected $baseRoutePattern = 'schedule';
    protected $baseRouteName = 'schedule-route-admin';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list'));
    }
}