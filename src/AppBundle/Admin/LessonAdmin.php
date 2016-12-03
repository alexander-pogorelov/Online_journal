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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



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
        $currentGroup = $this->getSubject()->getGroup();
        $repository=$this->getConfigurationPool()->getContainer()->get('Doctrine')
            ->getRepository('ApplicationSonataUserBundle:PupilGroupAssociation');
        $currentPupilGroupAssociations = $repository->findBy([
            'group' => $currentGroup
        ]);

        dump($currentPupilGroupAssociations);

        $assessmentArray = [];
        for ($i=10; $i>=5; $i--) {
            $assessmentArray[$i.' баллов'] = $i;
        }

        for ($i=4; $i>=2; $i--) {
            $assessmentArray[$i.' балла'] = $i;
        }
        $assessmentArray['1 балл'] = 1;
        $assessmentArray['Отсутствует'] = -1;



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
            ->with('Урок', array('class' => 'col-md-4'))->end()
            ->with('Оценки', array('class' => 'col-md-8'))->end()
        ;
        $formMapper
            ->with('Урок')
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

            ->with('Оценки');

                $assessment = '';
                $remark = '';
                foreach ($currentPupilGroupAssociations as $currentPupilGroupAssociation) {

                    if ($this->isCurrentRoute('edit')) {
                        foreach ($currentJournals as $currentJournal) {
                            // ищем оценки и замечания у ученика
                            if (($currentPupilGroupAssociation->getId()) === ($currentJournal->getPupilGroup()->getId())) {
                                $assessment = $currentJournal->getAssessment();
                                $remark = $currentJournal->getRemark();
                                break;
                            } else {
                                $assessment = '';
                                $remark = '';
                            }
                        }
                    }

                    $formMapper
                        ->add('pga'.$currentPupilGroupAssociation->getId(),'text',[
                            'read_only' => true,
                            'mapped' => false,
                            'data' => $currentPupilGroupAssociation->getPupil(),
                            'label' =>'Ученик',
                            'required' => false,

                        ])
                    ;
                    $formMapper->add('assessment'.$currentPupilGroupAssociation->getId(), ChoiceType::class, [
                            'choices' => $assessmentArray,
                            'choices_as_values' => true,
                            'attr' => ['maxlength' => 10],
                            'mapped' => false,
                            'label' => 'Оценка/присутствие',
                            'required' => false,
                            'data' => $assessment
                        ])
                    ;
                    $formMapper
                        ->add('remark'.$currentPupilGroupAssociation->getId(), 'text', [
                            'mapped' => false,
                            'required' => false,
                            'label' => 'Замечание',
                            'data' => $remark
                        ])
                    ;

                }
        $formMapper
            ->end();
    }

}