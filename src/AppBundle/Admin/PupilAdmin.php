<?php
/**
 * Created by PhpStorm.
 * User: Alex_PL
 * Date: 15.10.2016
 * Time: 21:42
 */

namespace AppBundle\Admin;
use Application\Sonata\UserBundle\Entity\PupilGroupAssociation;
use Application\Sonata\UserBundle\Entity\UserPupil;
use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Tests\Extension\Core\Type\CollectionTypeTest;

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
        $headerAttr = ['header_style' => 'text-align: center'];
        $listMapper
            ->addIdentifier('fullName', 'text', [
                'label'=>'Ф.И.О. ученика',
            ]+ $headerAttr)
            ->add('groupsIteen', 'text', ['label'=>'Группа']+ $headerAttr)
            ->add('dateOfBirth', 'date', [
                'label'=>'Дата рождения',
                'format' => 'd M Y'
            ]+ $headerAttr)
            ->add('phone', 'text', ['label'=>'Телефон']+ $headerAttr)
            ->add('classNumberString', null, [
                'label'=>'Класс',
                'row_align' => 'center'
            ]+ $headerAttr)
            ->addIdentifier('parents', CollectionType::class, [
                'label'=>'Ф.И.О. родителя'
            ]+ $headerAttr)
            ->add('parentsRelationships', null, [
                'label'=>'Родство'
            ]+ $headerAttr)
            ->add('parentsPhones', null, [
                'label'=>'Тел. родителя'
            ]+ $headerAttr)
            ->add('parentsEmailes', null, [
                'label'=>'E-mail родителя'
            ]+ $headerAttr)
            ->add('comment', 'text', [
                'label'=>'Комментарий',
            ] + $headerAttr)
        ;
    }

    protected function configureFormFields(FormMapper $formMapper) {

        $now = new \DateTime();
        $classNumberArray = [];
        for ($i=1; $i<=11; $i++) {
            $classNumberArray[$i.'-й класс'] = $i;
        }

        $formMapper
            ->with('Учащийся', array('class' => 'col-md-5'))->end()
            ->with('Родители', array('class' => 'col-md-7'))->end()
            ->with('Группы', array('class' => 'col-md-7'))->end()
        ;
        $formMapper
            ->with('Учащийся')
                ->add('lastname', 'text', ['label'=>'Фамилия'])
                ->add('firstname', 'text', ['label'=>'Имя'])
                ->add('patronymic', 'text', [
                    'label'=>'Отчество',
                    'required' => false
                ])
                ->add('dateOfBirth', 'date', [
                    'widget' => 'choice',
                    'label'=>'Дата, месяц, год рождения',
                    'format' => 'dd MMMM yyyy',
                    //'choice_translation_domain' => false,
                    'years' => range(1900, $now->format('Y')),
                ])
                ->add('email', 'text', [
                    'label'=>'E-Mail',
                    'required' => false
                ])
            ->add('classNumber', 'choice', [
                'choices' => $classNumberArray,
                'choices_as_values' => true,
                'label'=>'Класс',
                'required' => false
            ])
                ->add('phone', 'text', [
                    'label'=>'Телефон',
                    'required' => false
                ])
                ->add('comment', TextareaType::class, [
                    'label'=>'Комментарий',
                    'required' => false,
                ])
            ->end()
            ->with('Родители')
                ->add('parents', 'sonata_type_model', [
                    'multiple' => true,
                    'by_reference' => false,
                ])
            ->end()
            ->with('Группы')
                // добавляем в поле pupilGroupAssociation все группы из БД
                ->add('pupilGroupAssociation', 'entity' , [
                    'label' => 'Группы',
                    'multiple' => true,
                    'by_reference' => false,
                    'class' => 'Application\Sonata\UserBundle\Entity\GroupIteen'
                ])
            ->end()
        ;
        // получаем текущего ученика
        $pupil = $this->getSubject();
        // модифицируем поле pupilGroupAssociation
        $formMapper
            ->get('pupilGroupAssociation')
            ->addModelTransformer(new CallbackTransformer(
                // трансформация данных от сущности PupilGroupAssociation в форму
                function ($associations) {
                    // если ученик не связан ни с одной группой - возвращаем null
                    if (!$associations) {
                        return null;
                    }
                    // иначе возвращаем массив связанных с учеником групп
                    $groupsArray = array_map(function (PupilGroupAssociation $pupilGroupAssociation) {
                        return $pupilGroupAssociation->getGroup();
                        }, $associations->toArray()
                    );
                    return $groupsArray;
                },
                // обратная трансформация данных от формы в сущность PupilGroupAssociation (получение связанных с учеником групп)
                // наследование переменной $pupil из родительской области видимости
                function($groups) use ($pupil) {
                    // создаем коллекцию связей
                    $associations = new ArrayCollection();
                    // проверяем наличие уже существующих связей
                    foreach ($pupil->getPupilGroupAssociation() as $oldAssociation) {
                        $group = $oldAssociation->getGroup();
                        if ($groups->contains($group)) {
                            // добавляем в коллекцию старые связи
                            $associations->add($oldAssociation);
                            // удаляем уже добавленную группу из массива групп из формы
                            $groups->removeElement($group);
                        }
                    }
                    foreach ($groups as $group) {
                        // добавляем новые связи ученика с группами
                        $associations->add(new PupilGroupAssociation($pupil, $group));
                    }

                    return $associations;
                }
            ))
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
