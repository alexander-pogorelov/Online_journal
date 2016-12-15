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
            ->add('group',null, ['admin_code' => 'app.admin.group', 'label'=>'Группа'])
            ->add('subject',null, ['label'=>'Название предмета'])
            ->add('teacher',null, ['label'=>'Преподователь'])
            ->add('_action', null, [ // Добавление команд в list
                'label'=>'Действие',
                'actions' => [
                    'edit' => [], // команда редактировать
                    'delete' => [], // команда удалить
                ]])
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
            ->add('weekday','choice',
                    ['label' => 'День недели',
                     'required' => false,
                     'expanded' => false,
                     'multiple' => false,
                     'choices' => $weekdays]
                )
            ->add('timeinterval',null,
                    ['label'=>'Время занятий', 'required' => false],
                    ['admin_code' => 'admin.timeinterval']
                )
            ->add('group', null,
                    ['label' => 'Номер группы', 'required' => false],
                    ['admin_code' => 'app.admin.group']
                )
            ->add('classroom',null,
                    ['label' => 'Аудитория', 'required' => false],
                    ['admin_code' => 'admin.classroom']
                )
            ->add('subject',null,
                    ['label' => 'Название предмета', 'required' => false,
                     'attr' => ['class' => 'subject']],
                    ['admin_code' => 'admin.subject']
                )
            ->add('teacher',null,
                ['label' => 'Ф.И.О. Преподавателя', 'required' => false],
                ['admin_code' => 'admin.teacher']
            )

            ->end();
    }
}