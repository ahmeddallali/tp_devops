<?php

namespace App\Form;

use App\Entity\Interventions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InterventionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('etat', ChoiceType::class, array(
            'label' => false,
            'choices'  => [
                
                'panne' => 'panne',
                'marche' => 'marche',
                
            ], 
        ))
            ->add('type_dentretient', ChoiceType::class, array(
                'label' => false,
                'choices'  => [
                    
                    'vidange' => 'vidange',
                    'changement de pieces' => 'changement de pieces',
                    'revision' => 'crevision',
                ], 
            ))
            ->add('type_interventions', ChoiceType::class, array(
                'label' => false,
                'choices'  => [
                    
                    'mecanique' => 'mecanique',
                    'hydraulique' => 'hydraulique',
                    'electrique' => 'electrique',
                ], 
            ))
            ->add('details')
            ->add('marque')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Interventions::class,
        ]);
    }
}
