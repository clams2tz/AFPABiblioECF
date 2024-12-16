<?php

namespace App\Form;

use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startTime', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Start Time',
                'input' => 'datetime',
                'attr' => ['class' => 'datetime-picker'],
            ])
            ->add('endTime', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'End Time',
                'input' => 'datetime',
                'attr' => ['class' => 'datetime-picker'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Create Reservervation',
                'attr' => ['class' => 'btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,

        ]);
    }
}
