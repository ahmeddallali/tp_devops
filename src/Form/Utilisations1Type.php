<?php

namespace App\Form;

use App\Entity\Utilisations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Utilisations1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('conducteur')
            ->add('distination')
            ->add('kilometrages')
            ->add('datedepart')
            ->add('datearrive')
            ->add('kilometragearivvage')
            ->add('matriculevoiture')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisations::class,
        ]);
    }
}
