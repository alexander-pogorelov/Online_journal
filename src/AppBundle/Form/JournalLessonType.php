<?php
/**
 * Created by PhpStorm.
 * User: Alexander Pogorelov
 * Date: 12.12.2016
 * Time: 21:53
 */

namespace AppBundle\Form;


use Application\Sonata\UserBundle\Entity\Lesson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JournalLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $assessmentList = Lesson::getAssessmentList();

        $builder
            ->add('pupil', TextType::class, [
                'required' => false,
                'read_only' => true,
                'label' => 'Ученик',
                'attr' => ['class' => 'pupil'],
            ])
            ->add('assessment', ChoiceType::class, [
                'choices' => $assessmentList,
                'choices_as_values' => true,
                'required' => false,
                'label' => 'Оценка',
                'attr' => ['class' => 'assessment'],
            ])
            ->add('remark', TextType::class, [
                'required' => false,
                'label' => 'Замечание',
                'attr' => ['class' => 'remark'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
            'attr' => ['class' => 'one-line'],
        ]);
    }
}