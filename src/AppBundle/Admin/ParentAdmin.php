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
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;


class ParentAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'parent-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'parent'; //unique-route-pattern

    public function create($object)
    {
		$container = $this->getConfigurationPool()->getContainer();
        $tokenGenerator = $container->get('fos_user.util.token_generator');
        $password = substr($tokenGenerator->generateToken(), 0, 8);

        $object->setPlainPassword($password);

        parent::create($object);
		
		$templating = $container->get('templating');
        $message = \Swift_Message::newInstance()
            ->setSubject('Данные для авторизации')
            ->setFrom('testiteen@gmail.com')
            ->setTo($object->getEmail())
            ->setBody($templating->render(
                'AppBundle:Emails:registration.html.twig',
                array('login' => $object->getEmail(),
                    'password' => $password)
            ),
                'text/html'
            )
        ;
        $container->get('mailer')->send($message);
    }

    public function prePersist($object)
    {
        $name = 'parent'.time();
        $object->setUsername($name);
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
            ->with('Родитель', array('class' => 'col-md-5'))->end()
            ->with('Данные', array('class' => 'col-md-5'))->end()
            ->end()
        ;
        $now = new \DateTime();
        $formMapper
            ->with('Родитель')
                ->add('lastname', null, [
                    'required' => true,
                    'label'=>'Фамилия',
                ])
                ->add('firstname', null, [
                    'required' => true,
                    'label'=>'Имя',
                ])
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

            ->end()
            ->with('Данные')
                //->add('username')
                ->add('email')
                ->add('phone', 'text', [
                    'label'=>'Телефон',
                    'required' => false
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('full_name', 'doctrine_orm_callback', [
                'label'=>'Ф.И.О. Родителя',
                'callback' => 'AppBundle\Admin\Filters\AllFilters::getFullNameFilter',
                'field_type' => 'text'
            ])
        ;
    }
}