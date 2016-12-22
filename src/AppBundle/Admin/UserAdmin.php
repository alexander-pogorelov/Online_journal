<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 01.10.2016
 * Time: 12:00
 */

namespace AppBundle\Admin;
use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;



class UserAdmin extends BaseUserAdmin
{
    // List
    protected function configureListFields(ListMapper $listMapper) {
        parent::configureListFields($listMapper);
        //$listMapper->remove('groups');
        $listMapper->remove('impersonating');
    }

    protected function configureFormFields(FormMapper $formMapper) {
        // define group zoning
        $formMapper
            ->tab('Пользователь')
            ->with('Profile', array('class' => 'col-md-6'))->end()
            ->with('General', array('class' => 'col-md-6'))->end()
            ->with('Social', array('class' => 'col-md-6'))->end()
            ->end()
            ->tab('Security')
            ->with('Status', array('class' => 'col-md-4'))->end()
            ->with('Groups', array('class' => 'col-md-4'))->end()
            ->with('Keys', array('class' => 'col-md-4'))->end()
            ->with('Roles', array('class' => 'col-md-12'))->end()
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
            //->add('website', 'url', array('required' => false))
            //->add('biography', 'text', array('required' => false))
            ->add('gender', 'sonata_user_gender', array(
                'required' => true,
                'translation_domain' => $this->getTranslationDomain(),
            ))
            //->add('locale', 'locale', array('required' => false))
            //->add('timezone', 'timezone', array('required' => false))
            ->add('phone', null, array('required' => false))
            ->end()
            ->with('Social')
            ->add('facebookUid', null, array('required' => false))
            ->add('facebookName', null, array('required' => false))
            ->add('twitterUid', null, array('required' => false))
            ->add('twitterName', null, array('required' => false))
            ->add('gplusUid', null, array('required' => false))
            ->add('gplusName', null, array('required' => false))
            ->end()
            ->end()
            ->tab('Security')
            ->with('Status')
            ->add('locked', null, array('required' => false))
            ->add('expired', null, array('required' => false))
            ->add('enabled', null, array('required' => false))
            ->add('credentialsExpired', null, array('required' => false))
            ->end()
            ->with('Groups')
            ->add('groups', 'sonata_type_model', array(
                'required' => false,
                'expanded' => true,
                'multiple' => true,
            ))
            ->end()
            ->with('Roles')
            ->add('realRoles', 'sonata_security_roles', array(
                'label' => 'form.label_roles',
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ))
            ->end()
            ->with('Keys')
            ->add('token', null, array('required' => false))
            ->add('twoStepVerificationCode', null, array('required' => false))
            ->end()
            ->end()
        ;
    }
}