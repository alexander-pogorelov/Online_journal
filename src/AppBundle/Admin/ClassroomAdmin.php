<?php
/**
 * Created by PhpStorm.
 * User: Home-Acer
 * Date: 25.10.2016
 * Time: 19:59
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;

class ClassroomAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('number')
                ->assertNotBlank()
            ->end()
            ->with('capacity')
                ->assertNotBlank()
            ->end()
            ->with('description')
                ->assertNotBlank()
            ->end()
        ;
    }

    // Создание списка аудиторий из базы данных
    protected function configureListFields(ListMapper $listClassroom)
    {
        // Описывается каждое отображаемое поле из entity/Auditori.php
        $listClassroom
            ->addIdentifier('number',null, ['label'=>'Номер аудитории'])
            ->add('capacity',null, ['label'=>'Вместимость'])
            ->add('description',null, ['label'=>'Описание'])
            ;
    }

    // Создание формы для добавления и редактирования
    protected function configureFormFields(FormMapper $formClassroom)
    {
        $formClassroom
            ->with('Добавить аудитории',['class' => 'col-md-6'])
                ->add('number', 'integer', [
                    'label'=>'Номер аудитории',
                    'attr' => array('min' => 1)
                ])
                ->add('capacity',null, [
                    'label'=>'Вместимость',
                    'attr' => array('min' => 1)
                ])
                ->add('description',null, [
                    'label'=>'Описание',
                ])
            ->end();
    }

    // Создание формы для просмотра
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id',null, ['label'=>'№'])
            ->add('number',null, ['label'=>'Номер аудитории'])
            ->add('capacity',null, ['label'=>'Вместимость'])
            ->add('description',null, ['label'=>'Описание']);
    }
}