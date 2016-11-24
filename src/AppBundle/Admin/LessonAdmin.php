<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 23.11.2016
 * Time: 12:21
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;


class LessonAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'lesson-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'lesson'; //unique-route-pattern

    protected $datagridValues = [
        '_sort_order' => 'DESC'
    ];

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('date', 'date', [
                'label'=>'Дата',
                'row_align' => 'center',
                'format' => 'd M',
            ])
            ->add('group.groupName', null, [
                'label'=>'Группа',
            ])
            ->add('teacherSubject.subject', null, [
                'label'=>'Предмет',
            ])
            ->add('topic', null, [
                'label'=>'Тема урока',
            ])
            ->add('teacherSubject.teacher', null, [
                'label'=>'Преподаватель',
            ])
            ->add('homework', null, [
                'label'=>'Домашнее задание',
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $now = new \DateTime();
        $repository = $this->getConfigurationPool()->getContainer()->get('Doctrine')->getRepository('ApplicationSonataUserBundle:GroupIteen');
        $actualGroupList = $repository->findByActual();
        $formMapper
            ->with('Главное', array('class' => 'col-md-5'))->end()
        ;
        $formMapper
            ->with('Главное')
                ->add('date', 'date', [
                    'widget' => 'choice',
                    'label'=>'Дата урока',
                    'format' => 'dd MMMM yyyy',
                    'years' => range(2016, $now->format('Y')),
                    'required' => true
                ])
                ->add('group.groupName', 'choice', [
                    'choices' => $actualGroupList,
                    'label'=>'Группа',
                    'required' => true
                ])
            ->end()
        ;
    }

}