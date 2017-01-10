<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 01.10.2016
 * Time: 12:00
 */

namespace AppBundle\Admin;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;



class UserAdmin extends BaseUserAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept('edit');
    }

    protected function configureFormFields(FormMapper $formMapper) {
        // define group zoning
        $formMapper
            ->tab('Пользователь')
                ->with('Profile', array('class' => 'col-md-6'))->end()
                ->with('General', array('class' => 'col-md-6'))->end()
            ->end()
            ->tab('Security')
                ->with('Status', array('class' => 'col-md-4'))->end()
                ->with('Keys', array('class' => 'col-md-4'))->end()
            ->end()
        ;

        $now = new \DateTime();

        $formMapper
            ->tab('Пользователь')
                ->with('General')
                    ->add('username')
                    ->add('email')
                    ->add('plainPassword', 'text', array(
                        'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                    ))
                ->end()
                ->with('Profile')
                    ->add('dateOfBirth', 'sonata_type_date_picker', array(
                        'years' => range(1900, $now->format('Y')),
                        'dp_min_date' => '1-1-1900',
                        'dp_max_date' => $now->format('c'),
                        'required' => false,
                    ))
                    ->add('firstname', null, array('required' => false))
                    ->add('lastname', null, array('required' => false))
                    ->add('gender', 'sonata_user_gender', array(
                        'required' => true,
                        'translation_domain' => $this->getTranslationDomain(),
                    ))
                    ->add('phone', null, array('required' => false))
                ->end()
            ->end()
            ->tab('Security')
                ->with('Status')
                    ->add('locked', null, array('required' => false))
                    ->add('expired', null, array('required' => false))
                    ->add('enabled', null, array('required' => false))
                    ->add('credentialsExpired', null, array('required' => false))
                ->end()
                ->with('Keys')
                    ->add('token', null, array('required' => false))
                    ->add('twoStepVerificationCode', null, array('required' => false))
                ->end()
            ->end()
        ;
    }
}