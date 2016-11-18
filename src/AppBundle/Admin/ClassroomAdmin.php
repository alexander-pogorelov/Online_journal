<?php
/**
 * Created by PhpStorm.
 * User: Home-Acer
 * Date: 25.10.2016
 * Time: 19:59
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Route\RouteCollection;

class ClassroomAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }
    // Создание списка аудиторий из базы данных
    protected function configureListFields(ListMapper $listClassroom)
    {
        // Описывается каждое отображаемое поле из entity/Auditori.php
        $listClassroom
            ->addIdentifier('number',null, ['label'=>'Номер аудитории'])
            ->add('capacity',null, ['label'=>'Вместимость'])
            ->add('description',null, ['label'=>'Описание'])
            ;
    }

    // Создание формы для добавления и редактирования
    protected function configureFormFields(FormMapper $formClassroom)
    {
        $formClassroom
            ->with('Добавить аудитории',['class' => 'col-md-6'])
                ->add('number',null, ['label'=>'Номер аудитории'])
                ->add('capacity',null, ['label'=>'Вместимость'])
                ->add('description',null, [
                    'label'=>'Описание',
                    'required' => false
                ])
            ->end();
    }

    // Создание формы для просмотра
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id',null, ['label'=>'№'])
            ->add('number',null, ['label'=>'Номер аудитории'])
            ->add('capacity',null, ['label'=>'Вместимость'])
            ->add('description',null, ['label'=>'Описание']);
    }
}