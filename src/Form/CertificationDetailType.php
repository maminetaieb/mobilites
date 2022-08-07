<?php

namespace App\Form;

use App\Entity\CertificationDetail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificationDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('obtainDate')
            ->add('mark')
            ->add('authentic')
            ->add('certified')
            ->add('certification')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CertificationDetail::class,
        ]);
    }
}
