<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 28.10.2016
 * Time: 10:14
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GroupAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'group-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'group'; //unique-route-pattern

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('showPupilsInGroup', $this->getRouterIdParameter().'/pupils');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $headerAttr = ['header_style' => 'text-align: center'];
        $listMapper
            ->addIdentifier('groupName', 'text', [
                'label'=>'Группа',
                'row_align' => 'center'
            ]+ $headerAttr)
            ->add('pupilsAmount', null, [
                'label'=>'Кол-во учеников',
                'row_align' => 'center'
            ]+ $headerAttr)
            ->add('_subject_array_', null, [
                'label'=>'Предметы',
            ]+ $headerAttr)
            ->add('_teacher_array_', null, [
                'label'=>'Преподаватели',
            ]+ $headerAttr)
            ->add('_action', null, [
                'label'=>'Список группы',
                'row_align' => 'center',
                'actions' => [
                    'pupils' => ['template' => 'AppBundle:GroupAdmin:pupils_show_button.html.twig']
                ]
            ]+ $headerAttr)
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Группа', array('class' => 'col-md-5'))->end()
            ->with('Предметы', array('class' => 'col-md-5'))->end()
        ;
        $formMapper
            ->with('Группа')
            ->add('groupName', 'text', ['label'=>'Название группы'])
            ->add('note', 'textarea', ['label'=>'Примечание'])
            ->end()
            ->with('Предметы')

            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getSubject()->getId();
        $groupRepository = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('ApplicationSonataUserBundle:GroupIteen');
        $group = $groupRepository->find($id);
        $showMapper
            ->with('Группа:   '.$group->getGroupName())
                //->add($group->getPupils(), null, [])
            ->end()
        ;

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('groupName', null, [
                'label'=>'Номер группы'
            ])
            /*
            ->add('pupilsAmount', null, [
                'label'=>'Количество учеников'
            ])
            */
        ;
    }

}
