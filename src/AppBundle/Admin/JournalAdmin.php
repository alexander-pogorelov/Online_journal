<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 12.11.2016
 * Time: 17:10
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class JournalAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'journal-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'journal'; //unique-route-pattern

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('create');
        $collection->remove('export');
        //$collection->add('showGroupJournal', $this->getRouterIdParameter().'/show');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $headerAttr = ['header_style' => 'text-align: center'];
        $listMapper
            ->add('groupName', 'text', [
                    'label'=>'Группа',
                    'row_align' => 'center'
                ]+ $headerAttr)
            ->add('subjects', null, [
                    'label'=>'Предметы',
                ]+ $headerAttr)
            ->add('_teacher_array_', null, [
                    'label'=>'Преподаватели',
                ]+ $headerAttr)
            ->add('_action', null, [
                    'label'=>'Перейти к журналу',
                    'row_align' => 'center',
                    'actions' => [
                        'journal' => ['template' => 'AppBundle:JournalAdmin:journal_show_button.html.twig']
                    ]
                ]+ $headerAttr)
        ;
    }

}