<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 28.10.2016
 * Time: 10:14
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Sonata\CoreBundle\Validator\ErrorElement;

class GroupAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'group-route-admin'; //admin_vendor_bundlename_adminclassname
    protected $baseRoutePattern = 'group'; //unique-route-pattern

    protected $datagridValues = [
        '_sort_order' => 'DESC'
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('showPupilsInGroup', $this->getRouterIdParameter().'/pupils');
        $collection->remove('export');
    }

    public function prePersist($object)
    {
        $object->setCreatedAt(new \DateTime());
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getGroupName() === null) {
            $errorElement
                ->with('groupName')
                ->addViolation('Заполните поле')
                ->end()
            ;
        } else {
            // ищем в БД группу с таким же названием
            $otherObject = $this->modelManager->findOneBy($this->getClass(), array('groupName' => $object->getGroupName()));
            // если такая группа найдена и это другая группа, чем текущая, выдаем ошибку валидации
            if ($otherObject !== null && $otherObject->getId() !== $object->getId()) {
                $errorElement
                    ->with('groupName')
                    ->addViolation('Группа с таким именем уже существует')
                    ->end()
                ;
            }
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $headerAttr = ['header_style' => 'text-align: center'];
        $listMapper
            ->addIdentifier('groupName', 'text', [
                'label'=>'Группа',
                'row_align' => 'center'
            ]+ $headerAttr)
            ->add('pupilsAmount', null, [
                'label'=>'Кол-во учеников',
                'row_align' => 'center'
            ]+ $headerAttr)
            ->add('subjects', null, [
                'label'=>'Предметы',
            ]+ $headerAttr)
            ->add('_action', null, [
                'label'=>'Список группы',
                'row_align' => 'center',
                'actions' => [
                    'pupils' => ['template' => 'AppBundle:GroupAdmin:pupils_show_button.html.twig']
                ]
            ]+ $headerAttr)
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $now = new \DateTime();
        $formMapper
            ->with('Группа', array('class' => 'col-md-5'))->end()
            ->with('Предметы', array('class' => 'col-md-5'))->end()
        ;
        $formMapper
            ->with('Группа')
            ->add('groupName', 'text', [
                'label'=>'Название группы',
            ])
            ->add('note', 'textarea', [
                'label'=>'Примечание',
                'required' => false,
            ])
            ->add('expirationDate', 'date', [
                'widget' => 'choice',
                'label'=>'Дата окончания обучения',
                'format' => 'dd MMMM yyyy',
                'years' => range(($now->format('Y')-5), ($now->format('Y')+5)),
                'required' => false,
            ])
            ->end()
            ->with('Предметы')
            ->add('subjects', 'sonata_type_model', [
                'multiple' => true,
                'by_reference' => false,
                'label'=>'Предметы',
                'constraints' => [
                    new Assert\Callback([$this, 'validateSubject'])
                ]
            ])
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getSubject()->getId();
        $groupRepository = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('ApplicationSonataUserBundle:GroupIteen');
        $group = $groupRepository->find($id);
        $showMapper
            ->with('Группа:   '.$group->getGroupName())
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('groupName', null, [
                'label'=>'Номер группы'
            ])
            ->add('subjects', null, [
                'label'=>'Предмет'
            ])
            ->add('pupilsAmount', 'doctrine_orm_callback', [
                'label' => 'Количество учеников',
                'row_align' => 'center',
                'field_type' => 'sonata_type_filter_number',
                'callback' => [$this, 'filterByPupilAmount'],
            ])
        ;
    }

    public function filterByPupilAmount($qb, $alias, $field, $value) {
        if (!$value['value'] || !$value['value']['value'] || !$value['value']['type']) {
            return;
        }

        /**
         * @var \Doctrine\ORM\QueryBuilder $qb2
         */
        $qb2 = $qb->getEntityManager()->createQueryBuilder();

        switch ($value['value']['type']) {
            case NumberType::TYPE_EQUAL:
                $comparasion = $qb->expr()->eq(
                    $qb2->expr()->count('pga.id'),
                    $value['value']['value']
                );
                break;
            case NumberType::TYPE_GREATER_EQUAL:
                $comparasion = $qb->expr()->gte(
                    $qb2->expr()->count('pga.id'),
                    $value['value']['value']
                );
                break;
            case NumberType::TYPE_GREATER_THAN:
                $comparasion = $qb->expr()->gt(
                    $qb2->expr()->count('pga.id'),
                    $value['value']['value']
                );
                break;
            case NumberType::TYPE_LESS_EQUAL:
                $comparasion = $qb->expr()->lte(
                    $qb2->expr()->count('pga.id'),
                    $value['value']['value']
                );
                break;
            case NumberType::TYPE_LESS_THAN:
                $comparasion = $qb->expr()->lt(
                    $qb2->expr()->count('pga.id'),
                    $value['value']['value']
                );
                break;
        }

        $qb->andWhere(
            $qb->expr()->in(
                $alias . '.id',
                $qb2->select([
                    'gi.id'
                ])
                    ->from('ApplicationSonataUserBundle:GroupIteen', 'gi')
                    ->innerJoin('gi.pupilGroupAssociation', 'pga')
                    ->groupBy('gi.id')
                    ->having($comparasion)
                    ->getDQL()
            )

        );

        return true;
    }

    public function validateSubject($subjectsCollection, ExecutionContextInterface $context){

        if(!count($subjectsCollection)){
            $errorMessage = 'Добавьте предметы для группы';
            $context->buildViolation($errorMessage)
                ->addViolation();
        }
    }

}
