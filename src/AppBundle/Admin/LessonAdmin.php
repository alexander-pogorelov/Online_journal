<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 23.11.2016
 * Time: 12:21
 */

namespace AppBundle\Admin;


use AppBundle\Form\JournalType;
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
        '_sort_by' => 'date',
        '_sort_order' => 'DESC'
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('createLesson', 'group/{groupId}/subject/{subjectId}/create');
    }

    public function getDashboardActions()
    {
        $actions = parent::getDashboardActions();
        if (isset($actions['create'])) {
            unset($actions['create']);
        }

        return $actions;
    }

    public function getActionButtons($action, $object = null)
    {
        $list = parent::getActionButtons($action, $object);
        if (isset($list['create'])) {
            unset($list['create']);
        }

        return $list;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'label'=>'№',
                'row_align' => 'center'
            ])
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

        $currentSubjectId = $this->getSubject()->getTeacherSubject()->getSubject()->getId();
        if ($this->getSubject()->getId()) {
            $id = $this->getSubject()->getId();
            $repository=$this->getConfigurationPool()->getContainer()->get('Doctrine')
                ->getRepository('ApplicationSonataUserBundle:Journal');
            $currentJournals = $repository->findBy([
                'lesson' => $id
            ]);
            dump($currentJournals);
        }



        $formMapper
            ->with('1', array('class' => 'col-md-5'))->end()
            ->with('2', array('class' => 'col-md-5'))->end()
            ->with('3', array('class' => 'col-md-5'))->end()

        ;
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
            ->end();
        $formMapper
            ->with('3');
        foreach ($currentJournals as $currentJournal) {

            //dump($currentJournal);
            $formMapper->add($currentJournal->getId(), JournalType::class);
        }
        $formMapper
            ->end()
        ;
    }

}