<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 28.10.2016
 * Time: 10:14
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GroupAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'group-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'group'; //unique-route-pattern

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('groupName', 'text', [
                'label'=>'Группа',
            ])
            ->add('pupilsAmount', null, [
                'label'=>'Кол-во учеников',
            ])
            ->add('_subject_array_', null, [
                'label'=>'Предметы',
            ])
            ->add('_teacher_array_', null, [
                'label'=>'Преподаватели',
            ])

            ->add('pupils', 'sonata_type_model', [
                'multiple' => true,
                'by_reference' => false,
                //'required' => true
            ])

        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Группа', array('class' => 'col-md-5'))->end()
            ->with('Ученики', array('class' => 'col-md-5'))->end()
        ;
        $formMapper
            ->with('Группа')
            ->add('groupName', 'text', ['label'=>'Название группы'])
            ->add('note', TextareaType::class, ['label'=>'Примечание'])
            ->end()
            ->with('Ученики')
            /*
            ->add('pupils', 'sonata_type_model', [
                'multiple' => true,
                'by_reference' => false,
                //'required' => true
            ])
            */
            ->end()
        ;
    }

}