<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 28.10.2016
 * Time: 10:14
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $listMapper
            ->addIdentifier('groupName', 'text', [
                'label'=>'Группа',
                'row_align' => 'center'
            ])
            ->add('pupilsAmount', null, [
                'label'=>'Кол-во учеников',
                'row_align' => 'center'
            ])
            ->add('_subject_array_', null, [
                'label'=>'Предметы',
            ])
            ->add('_teacher_array_', null, [
                'label'=>'Преподаватели',
            ])
            ->add('_action', null, [
                'label'=>'Список группы',
                'row_align' => 'center',
                'actions' => [
                    'pupils' => ['template' => 'AppBundle:GroupAdmin:pupils_show_button.html.twig']
                ]
            ])
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
            ->add('note', TextareaType::class, ['label'=>'Примечание'])
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
            ->with($group->getGroupName())
                //->add($group->getPupils(), null, [])
            ->end()
        ;

    }

}