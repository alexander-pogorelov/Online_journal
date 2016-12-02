<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ScheduleAdmin extends AbstractAdmin
// Класс для создания списка расписания
{
    protected $baseRoutePattern = 'schedule';
    protected $baseRouteName = 'schedule-route-admin';



    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('weekday',null, ['label'=>'День недели'])
            ->add('timeinterval',null, ['label'=>'Время занятий'])
            ->add('classroom',null, ['label'=>'Аудитория'])
            ->add('group',null, ['label'=>'Группа'])
            ->add('subject',null, ['label'=>'Название предмета'])
            ->add('teacher',null, ['label'=>'Преподователь'])
        ;
    }

    // Создание формы для добавления и редактирования
    protected function configureFormFields(FormMapper $formSchedule)
    {
        $weekdays = [
            'Воскресенье' , 'Понедельник' ,
            'Вторник' , 'Среда' ,
            'Четверг' , 'Пятница' , 'Суббота'
        ];
        $formSchedule
            ->with('Добавить/Редактировать дату занятий',['class' => 'col-md-7'])
            ->add('weekday','choice', array('label' => 'День недели', 'required' => false, 'expanded' => false, 'multiple' => false, 'choices' => $weekdays))
            ->add('timeinterval',null, ['label'=>'Время занятий'])
            ->add('group',null, array(
                'attr' => ['class' => 'group'],
                'label' => 'Номер группы',
                'required' => false
                ))
            ->add('classroom',null, array(
                'label' => 'Аудитория'))
            ->add('subject',null, array(
                'label' => 'Название предмета',
                'required' => false,
                'attr' => ['class' => 'subject']
                ))
            ->add('teacher',null, array(
                'label' => 'Ф.И.О. Преподавателя'))

            ->end();
    }

}