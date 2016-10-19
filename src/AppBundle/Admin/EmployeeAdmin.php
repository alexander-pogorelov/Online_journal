<?php
/**
 * Created by PhpStorm.
 * User: Ксения
 * Date: 12.10.2016
 * Time: 11:09
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


class EmployeeAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'employee';

    protected $baseRoutePattern = 'employee';


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('lastname')
            ->add('firstname')
            ->add('patronymic')
            ->add('email')
            ->add('phone')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('lastname')
            ->add('email')
            ->add('phone')
            ->add('speciality')
            ->add('workDays')
            ->add('workHours')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Work')
                ->add('username')
                ->add('email')
                ->add('phone')
                ->add('workDays')
                ->add('workHours')
            ->end()
            ->with('Bio')
                ->add('firstname')
                ->add('lastname')
                ->add('patronymic')
                ->add('speciality')
                ->add('dateOfBirth')
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
                ->add('lastname', null, array('required' => false))
                ->add('firstname', null, array('required' => false))
                ->add('patronymic', null, array('required' => false))
                ->add('speciality', null, array('required' => false))
                ->add('dateOfBirth', 'sonata_type_date_picker', array(
                    'years' => range(1900, $now->format('Y')),
                    'dp_min_date' => '1-1-1900',
                    'dp_max_date' => $now->format('c'),
                    'required' => false,
                ))
                ->add('phone', null, array('required' => false))
                ->add('address', null, array('required' => false))
            ->end()
            ->with('Work')
                ->add('username')
                ->add('plainPassword', 'text', array(
            'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
        ))
                ->add('email')
                ->add('workDays', null, array('required' => false))
                ->add('workHours', null, array('required' => false))
                ->add('comment', 'text', array('required' => false))
            ->end()
        ;
    }
}