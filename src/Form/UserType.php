<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photoUrl', UrlType::class)
            ->add('name')
            ->add('birthDate', BirthdayType::class, [
                'years' => range(date('Y') - 50, date('Y') - 17),
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'expanded' => true,
                'choices' => [
                    'Male' => true,
                    'Female' => false,
                    'None' => null,
                ],
            ])
            ->add('nationality', CountryType::class, [
                'placeholder' => "Select your Nationality"
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
