<?php

namespace App\Form;

use App\Entity\Users;
use App\Enum\UserRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersType extends AbstractType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'prenom cannot be empty'
                    ]),
                ],
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'nom cannot be empty'
                    ]),
                ],
            ])
            ->add('birthday', BirthdayType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'ddn cannot be empty'
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'address cannot be empty'
                    ]),
                ],
            ])
            ->add('postalCode', TextType::class, [])
            ->add('ville', TextType::class, [])
            ->add('telephone', TextType::class, [])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'email cannot be empty'
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('subscriptionType', ChoiceType::class, [
                'choices'  => [
                    'Annually (10% Discount 287.88€)' => 'annual',
                    'Monthly (23.99€)' => 'monthly',
                ],
                'label' => 'Subscription Type',
                'mapped' => false,
            ]);
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                    'User' => UserRole::USER->value,
                    'Admin' => UserRole::ADMIN->value,
                ],
                'mapped' => false,
                'expanded' => true, 
                'multiple' => false, 
                'label' => 'Role',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
