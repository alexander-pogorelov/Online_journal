<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 18.10.2016
 * Time: 21:56
 */

namespace AppBundle\Admin;
use AppBundle\Validator\Validator;
use Application\Sonata\UserBundle\Entity\UserParent;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;


class ParentAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'parent-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'parent'; //unique-route-pattern

    protected $datagridValues = [
        '_sort_order' => 'DESC'
    ];

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

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('firstname')
                ->assertNotBlank()
            ->end()
            ->with('lastname')
                ->assertNotBlank()
            ->end()
            ->with('phone')
                ->assertNotBlank()
            ->end()
            ->with('relationship')
                ->assertNotBlank()
            ->end()
        ;

        if ($object->getEmail() === null) {
            $errorElement
                ->with('email')
                ->addViolation('Заполните поле')
                ->end()
            ;
        } else {
            if (Validator::duplicateEmailValidator($object, $this->modelManager)) {
                $errorElement
                    ->with('email')
                    ->addViolation('Пользователь с таким Email уже существует')
                    ->end()
                ;
            }
        }

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
                    'required' => true
                ])

            ->end()
            ->with('Данные')
                //->add('username')
                ->add('email', 'email')
                ->add('phone', 'text', [
                    'label'=>'Телефон',
                    'required' => true
                ])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('full_name', 'doctrine_orm_callback', [
                'label'=>'Ф.И.О. Родителя',
                'callback' => 'AppBundle\Admin\Filters\GeneralFilters::getFullNameFilter',
                'field_type' => 'text'
            ])
        ;
    }
}