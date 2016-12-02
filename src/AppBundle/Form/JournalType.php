<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 01.12.2016
 * Time: 22:10
 */

namespace AppBundle\Form;


use Application\Sonata\UserBundle\Entity\Journal;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class JournalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pupilGroup', EntityType::class, [
                'class' => 'ApplicationSonataUserBundle:PupilGroupAssociation',
                'choice_label' => 'pupil',
            ])
            ->add('assessment')
            ->add('remark')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Application\Sonata\UserBundle\Entity\Journal',
        ]);
    }
}