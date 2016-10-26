<?php
/**
 * Created by PhpStorm.
 * User: Ксения
 * Date: 20.10.2016
 * Time: 12:03
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class MetodistAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'metodist';

    protected $baseRoutePattern = 'metodist';


    public function prePersist($object)
    {
        $object->setRealRoles(['ROLE_METODIST']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fullName', 'text', [
                'label'=>'Ф.И.О. Методиста',
                'class' => 'col-md-1'
            ])
            ->add('email', 'text', [
                'label'=>'Email'
            ])
            ->add('phone', 'text', [
                'label'=>'Телефон'
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
    }
}