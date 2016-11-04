<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 12.10.2016
 * Time: 11:09
 */

namespace AppBundle\Admin;

use Application\Sonata\UserBundle\Entity\TeacherSubject;
use Application\Sonata\UserBundle\Entity\UserTeacher;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Tests\Extension\Core\Type\CollectionTypeTest;
use Sonata\AdminBundle\Show\ShowMapper;


class TeacherAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'teacher';

    protected $baseRoutePattern = 'teacher';

    public function prePersist($object)
    {
        $object->setRealRoles(['ROLE_TEACHER']);
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fullName', 'text', [
                'label'=>'Ф.И.О. Преподавателя',
                'class' => 'col-md-1'
            ])
            ->add('speciality', 'text', [
                'label'=>'Специальность'
            ])
            ->add('Subjects', 'text', [
                'label'=>'Предмет'
            ])
            ->add('workDays', 'text', [
                'label'=>'Дни работы'
            ])
            ->add('workHours', 'text', [
                'label'=>'Часы работы'
            ])
            ->add('email', 'text', [
                'label'=>'Email'
            ])
            ->add('phone', 'text', [
                'label'=>'Телефон'
            ])
            ->add('dateOfBirth', null, [
                'label'=>'Дата рождения',
                'format' => 'd M Y'
            ])
            ->add('comment', null, [
                'label'=>'Примечание'
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('lastname', null, [
                'label'=>'Фамилия'
            ])
            ->add('speciality', null, [
            'label'=>'Специальность'
            ])
            /*->add('TeacherSubject', null, [
                'label'=>'Предмет'
            ])*/
            ->add('phone', null, [
            'label'=>'Телефон'
            ])
            ->add('email')
            ->add('workDays', null, [
            'label'=>'Дни работы'
            ])
            ->add('workHours', null, [
            'label'=>'Часы работы'
            ])

    ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Work')
                ->add('username')
                ->add('email')
                ->add('phone', 'text', ['label'=>'Телефон'])
                ->add('workDays', 'text', ['label'=>'Дни работы'])
                ->add('workHours', 'text', ['label'=>'Часы работы'])
            ->end()
            ->with('Bio')
                ->add('firstname', 'text', ['label'=>'Фамилия'])
                ->add('lastname', 'text', ['label'=>'Имя'])
                ->add('patronymic', 'text', ['label'=>'Отчество'])
                ->add('speciality', 'text', ['label'=>'Специальность'])
                ->add('dateOfBirth', 'text', ['label'=>'День рождения'])
            ->end()
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Bio', array('class' => 'col-md-6'))->end()
            ->with('Work', array('class' => 'col-md-6'))->end()
        ;

        $now = new \DateTime();

        $formMapper
            ->with('Bio')
                ->add('lastname', 'text', ['label'=>'Фамилия'])
                ->add('firstname', 'text', ['label'=>'Имя'])
                ->add('patronymic', 'text', ['label'=>'Отчество'])
                ->add('speciality', 'text', ['label'=>'Специальность'])
                ->add('dateOfBirth', DateType::class, array(
                    'widget' => 'choice',
                    'label'=>'Дата рождения',
                    'format' => 'dd MMMM yyyy',
                    'years' => range(1900, $now->format('Y')),
                ))
                ->add('phone', 'text', ['label'=>'Телефон'])
                ->add('address', 'text', ['label'=>'Адрес'])
            ->end()
            ->with('Work')
                ->add('username')
                ->add('plainPassword', 'text', array(
            'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
        ))
                ->add('email')
                ->add('TeacherSubject', 'entity', [
                    'multiple' => true,
                    'by_reference' => false,
                    'label'=>'Предмет',
                    'class' => 'Application\Sonata\UserBundle\Entity\Subject'
                ])
                ->add('workDays', 'text', [
                    'label'=>'Дни работы',
                    'required' => false
                ])
                ->add('workHours', 'text', [
                    'label'=>'Часы работы',
                    'required' => false
                ])
                ->add('comment', TextareaType::class, [
                    'label'=>'Примечание',
                    'required' => false
                ])
            ->end()
        ;
        $teacher = $this->getSubject();

        $formMapper
            ->get('TeacherSubject')
            ->addModelTransformer(new CallbackTransformer(

                function ($associations) {
                    if (!$associations) {
                        return null;
                    }
                    $subjectsArray = array_map(function (TeacherSubject $teacherSubject) {
                        return $teacherSubject->getSubject();
                    }, $associations->toArray()
                    );
                    return $subjectsArray;
                },
                function($subjects) use ($teacher) {
                    $associations = new ArrayCollection();
                    foreach ($teacher->getTeacherSubject() as $oldAssociation) {
                        $subject = $oldAssociation->getSubject();
                        if ($subjects->contains($subject)) {
                            $associations->add($oldAssociation);
                            $subjects->removeElement($subject);
                        }
                    }
                    foreach ($subjects as $subject) {
                        $associations->add(new TeacherSubject($teacher, $subject));
                    }

                    return $associations;
                }
            ))
        ;
    }
}