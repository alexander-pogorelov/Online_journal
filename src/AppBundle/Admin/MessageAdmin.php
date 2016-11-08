<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 08.11.2016
 * Time: 18:34
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MessageAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'message';

    protected $baseRoutePattern = 'message';


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('abbreviation', 'text', [
                'label'=>'Аббревиатура',
            ])
            ->add('name', 'text', [
                'label'=>'Предмет',
            ])
            ->add('specialization', 'text', [
                'label'=>'Специализация',
            ])
            ->add('comment', 'text', [
                'label'=>'Примечание',
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('abbreviation', null, [
                'label'=>'Аббревиатура'
            ])
            ->add('name', null, [
                'label'=>'Предмет'
            ])
            ->add('specialization', null, [
                'label'=>'Специализация'
            ])

        ;
    }


    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Предмет', array('class' => 'col-md-6'))->end()
        ;


        $formMapper
            ->with('Предмет')
            ->add('abbreviation', 'text', [
                'label'=>'Аббревиатура',
            ])
            ->add('name', 'text', [
                'label'=>'Предмет',
            ])
            ->add('specialization', 'text', [
                'label'=>'Специализация',
            ])
            ->add('comment', TextareaType::class, [
                'label'=>'Примечание',
                'required' => false
            ])
            ->end()
        ;
    }
}