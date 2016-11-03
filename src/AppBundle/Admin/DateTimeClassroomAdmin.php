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
//use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
//use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;

class DateTimeClassroomAdmin extends AbstractAdmin
{
    // Класс для создания списка интервалов времени

    // Создание формы для добавления и редактирования
    protected function configureFormFields(FormMapper $formTimeForClassroom)
    {
        $formTimeForClassroom
            ->with('Добавить/Редактировать дату занятий',['class' => 'col-md-6'])
                ->add('date',null, ['label'=>'Дата занятия'])
                ->add('timeClassroom',null, ['label'=>'Время занятий'])
                ->add('dateClassroom',null, ['label'=>'Аудитория'])
            ->end();
    }

    // Создание формы для просмотра
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id',null, ['label'=>'№'])
            ->add('date',null, ['label'=>'Дата занятия'])
            ->add('timeClassroom',null, ['label'=>'Время занятий'])
            ->add('dateClassroom',null, ['label'=>'Аудитория']);
    }
}