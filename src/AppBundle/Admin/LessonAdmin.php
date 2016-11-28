<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 23.11.2016
 * Time: 12:21
 */

namespace AppBundle\Admin;


use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Route;


class LessonAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'lesson-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'lesson'; //unique-route-pattern

    protected $datagridValues = [
        '_sort_order' => 'DESC'
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('createLesson', 'group/{groupId}/subject/{subjectId}/create');
    }

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
        //$repository = $this->getConfigurationPool()->getContainer()->get('Doctrine')->getRepository('ApplicationSonataUserBundle:GroupIteen');
        //$actualGroupList = $repository->findByActual();

        $currentSubjectId = $this->getSubject()->getTeacherSubject()->getSubject()->getId();
        //dump($currentSubjectId);
        /*
        if ($this->getSubject()->getId()) {

            $lessonId = $this->getSubject()->getId();

            $repository = $this->getConfigurationPool()->getContainer()->get('Doctrine')
                ->getRepository('ApplicationSonataUserBundle:Lesson');
            $currentSubjectId = $repository->find($lessonId)->getTeacherSubject()->getSubject()->getId();
        } else {
            //TODO: заменить на реальный ID, передаваемый в форму
            //$currentSubjectId = $this->getSubject()->getTeacherSubject()->getSubject()->getId();
            //dump($currentSubjectId);
            //$currentSubjectId = 1;
        }
        */
        $formMapper
            ->with('1', array('class' => 'col-md-5'))->end()
            ->with('2', array('class' => 'col-md-5'))->end()

        ;


        //dump($data);

        $formMapper
            ->with('1')
                ->add('group.groupName', null, [
                    'label'=>'Группа',
                    'read_only' => true,
                    'disabled' => true,
                ])
                ->add('teacherSubject.subject', null, [
                    'label'=>'Предмет',
                    'read_only' => true,
                    'disabled' => true,
                ])
                ->add('teacherSubject', EntityType::class, [
                    'class' => 'ApplicationSonataUserBundle:TeacherSubject',
                    'choice_label' => 'teacher',
                    'query_builder' => function (EntityRepository $er) use ($currentSubjectId) {
                        return $er->createQueryBuilder('ts')
                            ->where('ts.subject = :currentSubjectId')
                            ->setParameter('currentSubjectId', $currentSubjectId)
                            ;
                    },
                    'label'=>'Преподаватель',
                ])
            ->end()
            ->with('2')
                ->add('date', 'date', [
                    'widget' => 'choice',
                    'label'=>'Дата урока',
                    'format' => 'dd MMMM yyyy',
                    'years' => range(2016, $now->format('Y')),
                    'required' => true,
                ])
                ->add('topic', 'text', [
                    'label'=>'Тема урока',
                    'required' => true,
                ])
                ->add('homework', 'textarea', [
                    'label'=>'Домашнее задание',
                ])
            ->end()
        ;
    }

}