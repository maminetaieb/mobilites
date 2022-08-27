<?php

namespace App\Form;

use App\Entity\YearDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YearDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('academicYear')
            ->add('moyennes', CollectionType::class, [
                'entry_type' => NumberType::class,
                'allow_add' => true,
                'prototype' => true,
            ])
            ->add('fr')
            ->add('eng')
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => YearDetail::class,
        ]);
    }
}
