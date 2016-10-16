<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 15.10.2016
 * Time: 21:42
 */

namespace AppBundle\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
//use Sonata\UserBundle\Admin\Model\UserAdmin as SonataUserAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PupilAdmin extends AbstractAdmin

{
    // TODO: наследование от AbstractAdmin или от UserAdmin????
    protected $baseRouteName = 'pupil-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'pupil'; //unique-route-pattern

    public function prePersist($object)
    {
        $name = 'pupil'.time();
        $pass = str_replace('pupil', 'pass', $name);
        $object->setUsername($name);
        $object->setPlainPassword($pass);
        $object->setEmail($name.'@example.com');
        $object->setEnabled(false);
        $object->setRealRoles(['ROLE_PUPIL']);
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('lastname', 'text', ['label'=>'Фамилия'])
            ->add('firstname', 'text', ['label'=>'Имя'])
            ->add('patronymic', 'text', ['label'=>'Отчество'])
            ->add('_group_', 'text', ['label'=>'Группа'])
            ->add('dateOfBirth', 'date', [
                'label'=>'Дата рождения',
                'format' => 'd M Y'
            ])
            ->add('phone', 'text', ['label'=>'Телефон'])
            ->add('email', 'text', ['label'=>'E-Mail'])
            ->add('comment', 'text', ['label'=>'Комментарий'])
            //->add('enabled', 'boolean')
            //->add('locked', 'boolean')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {
        //$now = new \DateTime();
        $formMapper
            ->add('lastname', 'text', ['label'=>'Фамилия'])
            ->add('firstname', 'text', ['label'=>'Имя'])
            ->add('patronymic', 'text', [
                'label'=>'Отчество',
                'required' => false
            ])
            ->add('dateOfBirth', 'date', [
                'label'=>'Дата, месяц, год рождения',
                'format' => 'dd MM yyyy'
            ])
            ->add('email', 'text', [
                'label'=>'E-Mail',
                'required' => false
            ])
            ->add('phone', 'text', [
                'label'=>'Телефон',
                'required' => false
            ])
            ->add('comment', 'text', [
                'label'=>'Комментарий',
                'required' => false
            ])
            //->add('_comment_', 'text', ['label'=>'Комментарий'])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('lastname', null, [
                'label'=>'Фамилия'
            ])
            ->add('dateOfBirth', null, [
                'label'=>'Дата рождения'
            ])
            ->add('phone', null, [
                'label'=>'Телефон'
            ])
            ->add('email', null, [
                'label'=>'e-mail'
            ])
            ->add('comment', null, [
                'label'=>'Комментарий'
            ])
        ;
    }


}