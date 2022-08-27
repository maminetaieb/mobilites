<?php

namespace App\Form;

use App\Entity\Institution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photoUrl', UrlType::class)
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('longitude')
            ->add('latitude')
            ->add('website', UrlType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Institution::class,
        ]);
    }
}
