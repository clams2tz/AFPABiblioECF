<?php

namespace App\Form;

use App\Entity\Books;
use App\Entity\Loans;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('Author')
            ->add('ISBN')
            ->add('bookCondition')
            ->add('summary')
            ->add('reserved')
            ->add('releaseDate')
            ->add('loans', EntityType::class, [
                'class' => Loans::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Books::class,
        ]);
    }
}
