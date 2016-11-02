<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 18.10.2016
 * Time: 21:56
 */

namespace AppBundle\Admin;
use Application\Sonata\UserBundle\Entity\UserParent;
use Sonata\AdminBundle\Admin\AbstractAdmin;
//use Sonata\UserBundle\Admin\Model\UserAdmin as BaseUserAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ParentAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'parent-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'parent'; //unique-route-pattern

    public function create($object)
    {
        $tokenGenerator = $this->getConfigurationPool()->getContainer()->get('fos_user.util.token_generator');
        $password = substr($tokenGenerator->generateToken(), 0, 8);

        $object->setPlainPassword($password);

        parent::create($object);

        $message = \Swift_Message::newInstance()
            ->setSubject('Данные для авторизации')
            ->setFrom('testiteen@gmail.com')
            ->setTo($object->getEmail())
            ->setBody('<html>' .
                '<head></head>' .
                '<body>' .
                '<p>' .
                'Ваш аккаунт был успешно создан в система «Электронный журнал» МА ОЦ ПВТ.
                 Ваш логин:' .$object->getEmail().
                'Ваш пароль:' .$password.
                'Для активации аккаунта перейдите по ссылке:' .
                '</p>' .
                '</body>' .
                '</html>',
                'text/html')
        ;
        $this->getConfigurationPool()->getContainer()->get('mailer')->send($message);
    }

    public function prePersist($object)
    {
        $object->setRealRoles(['ROLE_PARENT']);
        $object->setEnabled(true);
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('fullName', 'text', [
                'label'=>'Ф.И.О. родителя',
            ])
            ->add('email', null, [
                'label'=>'E-mail',
            ])
            ->add('phone', null, [
                'label'=>'Телефон',
            ])
            ->add('enabled', null, [
                'editable' => true,
                'label'=>'Активен',
            ])
            ->add('locked', null, [
                'editable' => true,
                'label'=>'Заблокирован',
            ])
            ->add('createdAt', null, [
                'label'=>'Дата создания',
            ])
        ;
    }
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Profile', array('class' => 'col-md-5'))->end()
            ->with('General', array('class' => 'col-md-5'))->end()
            ->end()
        ;
        $now = new \DateTime();
        $formMapper
            ->with('Profile')
                ->add('lastname', null, array('required' => true))
                ->add('firstname', null, array('required' => true))
                ->add('patronymic', 'text', [
                    'label'=>'Отчество',
                    'required' => false
                ])
                ->add('relationship', 'choice', [
                    'choices' => UserParent::$relationshipArray,
                    'choices_as_values' => true,
                    'label'=>'Родство',
                    'required' => false
                ])
                ->add('phone', 'text', [
                    'label'=>'Телефон',
                    'required' => false
                ])
            ->end()
            ->with('General')
                ->add('username')
                ->add('email')
                /*->add('plainPassword', 'text', array(
                    'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                ))*/
            ->end()
        ;
    }
}