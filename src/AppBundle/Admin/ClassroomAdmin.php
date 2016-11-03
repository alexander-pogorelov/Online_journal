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

class ClassroomAdmin extends AbstractAdmin
{
    // Создание списка аудиторий из базы данных
    protected function configureListFields(ListMapper $listClassroom)
    {
        // Описывается каждое отображаемое поле из entity/Auditori.php
        $listClassroom
            ->addIdentifier('id',null, ['label'=>'№'])
            ->add('number',null, ['label'=>'Номер аудитории'])
            ->add('capacity',null, ['label'=>'Вместимость'])
            ->add('description',null, ['label'=>'Описание'])
            ->add('_action', 'actions', [ // Добавление команд в list
                'label'=>'Действие',
                'actions' => [
                    'view' => [], // команда показать
                    'edit' => [], // команда редактировать
                    'delete' => [], // команда удалить
                ]
            ]);
    }

    // Создание формы для добавления и редактирования
    protected function configureFormFields(FormMapper $formClassroom)
    {
        $formClassroom
            ->with('Добавить аудитории',['class' => 'col-md-6'])
                ->add('number',null, ['label'=>'Номер аудитории'])
                ->add('capacity',null, ['label'=>'Вместимость'])
                ->add('description',null, ['label'=>'Описание'])
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