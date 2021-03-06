<?php
/**
 * Created by PhpStorm.
 * User: Igor Kachinskiy
 * Date: 08.11.2016
 * Time: 18:34
 */

namespace AppBundle\Admin;

use Application\Sonata\UserBundle\Entity\GroupIteen;
use Application\Sonata\UserBundle\Entity\Message;
use Application\Sonata\UserBundle\Entity\UserMessage;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\CallbackTransformer;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;


class MessageAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'message';

    protected $baseRoutePattern = 'message';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement
            ->with('topic')
                ->assertNotBlank()
            ->end()
            ->with('message')
                ->assertNotBlank()
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('receivers', 'text', [
                'label'=>'Кому'
            ])
            ->add('topic', 'text', [
                'label'=>'Тема',
            ])
            ->add('message', 'text', [
                'label'=>'Содержание',
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add('topic', null, [
                'label'=>'Тема'
            ])
            ->add('message', null, [
                'label'=>'Содержание'
            ])
            ->add('userMessage.user', null, [
                'label'=>'Кому'
            ])
        ;
    }


    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Сообщение', array('class' => 'col-md-6'))->end()
        ;

        $formMapper
            ->with('Сообщение')
            ->add('userMessage', 'entity' , [
                'label' => 'Кому',
                'multiple' => true,
                'by_reference' => false,
                'required' => false,
                'class' => 'Application\Sonata\UserBundle\Entity\User'
            ])
            ->add('messageGroup', 'choice', [
                'choices' => Message::$messageGroupArray,
                'choices_as_values' => true,
                'label'=>'Группы пользователей',
                'required' => false,
                'multiple' => true
            ])
            ->add('groupIteen', 'entity', [
                'label' => 'Учебные группы',
                'multiple' => true,
                'by_reference' => false,
                'required' => false,
                'class' => 'Application\Sonata\UserBundle\Entity\GroupIteen',
            ])
            ->add('topic', 'text', [
                'label'=>'Тема',
            ])
            ->add('message', TextareaType::class, [
                'label'=>'Сообщение',
            ])
            ->end()
        ;

        $message = $this->getSubject();

        $formMapper
            ->get('userMessage')
            ->addModelTransformer(new CallbackTransformer(
                function ($associations) {
                    if (!$associations) {
                        return null;
                    }
                    $messageArray = array_map(function (UserMessage $userMessage) {
                        return $userMessage->getUser();
                    }, $associations->toArray()
                    );
                    return $messageArray;
                },
                function($users) use ($message) {
                    $associations = new ArrayCollection();
                    foreach ($message->getUserMessage() as $oldAssociation) {
                        $user = $oldAssociation->getUser();
                        if ($users->contains($user)) {
                            $associations->add($oldAssociation);
                            $users->removeElement($user);
                        }
                    }
                    foreach ($users as $user) {
                        $associations->add(new UserMessage($user, $message));
                    }

                    return $associations;
                }
            ))
        ;

        $formMapper
            ->get('groupIteen')
            ->addModelTransformer(new CallbackTransformer(
                function ($groupIteenAsString) {
                    if (!$groupIteenAsString) {
                        return null;
                    }
                    return explode(', ', $groupIteenAsString);
                },
                function ($groupIteenAsArray) {
                    $groupArray = array_map(function (GroupIteen $groupIteen) {
                        return $groupIteen->getId();
                    }, $groupIteenAsArray->toArray()
                    );
                    return implode(', ', $groupArray);
                }
            ))
        ;

        $formMapper
            ->get('messageGroup')
            ->addModelTransformer(new CallbackTransformer(
                function ($messageGroupAsString) {
                    if (!$messageGroupAsString) {
                        return null;
                    }
                    return explode(', ', $$messageGroupAsString);
                },
                function ($messageGroupAsArray) {
                    return implode(', ', $messageGroupAsArray);
                }
            ))
        ;
    }
}