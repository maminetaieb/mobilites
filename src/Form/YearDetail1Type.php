<?php

namespace App\Form;

use App\Entity\YearDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YearDetail1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('moyennes')
            ->add('eng')
            ->add('fr')
            ->add('academicYear')
            ->add('authentic')
            ->add('student')
            ->add('grade')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => YearDetail::class,
        ]);
    }
}
