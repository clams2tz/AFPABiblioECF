<?php

namespace App\Form;

use App\Entity\SalleDeTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalleDeTravailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('maxCapacity')
            ->add('wifi')
            ->add('projector')
            ->add('tableau')
            ->add('prisesElectric')
            ->add('television')
            ->add('climatisation')
            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SalleDeTravail::class,
        ]);
    }
}
