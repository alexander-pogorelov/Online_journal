<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
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
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;


class MetodistAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'metodist';

    protected $baseRoutePattern = 'metodist';

    public function create($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $tokenGenerator = $container->get('fos_user.util.token_generator');
        $password = substr($tokenGenerator->generateToken(), 0, 8);

        $object->setPlainPassword($password);
        $object->setUsername($object->getEmail());

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
        $object->setRealRoles(['ROLE_METODIST']);
        $object->setEnabled(true);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('email')
                ->assertEmail()
                ->assertNotBlank()
            ->end()
            ->with('firstname')
                ->assertNotBlank()
            ->end()
            ->with('address')
                ->assertNotBlank()
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fullName', 'text', [
                'label'=>'Ф.И.О. Методиста',
                'class' => 'col-md-1'
            ])
            ->add('speciality', 'text', [
                'label'=>'Специальность'
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
            ->add('full_name', 'doctrine_orm_callback', [
                'label'=>'Ф.И.О. Методиста',
                'callback' => 'AppBundle\Admin\Filters\GeneralFilters::getFullNameFilter',
                'field_type' => 'text'
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
            ->with('Личные данные', array('class' => 'col-md-6'))->end()
            ->with('Дополнительная информация', array('class' => 'col-md-6'))->end()
        ;

        $now = new \DateTime();

        $formMapper
            ->with('Личные данные')
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
            ->with('Дополнительная информация')
            ->add('email', 'email')
            ->add('workDays', 'text', [
                'label'=>'Дни работы',
            ])
            ->add('workHours', 'text', [
                'label'=>'Часы работы',
            ])
            ->add('comment', TextareaType::class, [
                'label'=>'Примечание',
                'required' => false
            ])
            ->end()
        ;
    }
}