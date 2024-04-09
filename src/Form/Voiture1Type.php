<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Voiture1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
            ->add('description',ChoiceType::class, array(
                'label' => false,
                'choices'  => [
                    
                    'Peugeot' => 'Peugeot',
                    'Mazda' => 'Mazda',
                ], 
            ))
            ->add('prix', ChoiceType::class, array(
                'label' => false,
                'choices'  => [
                    
                    'Berlingo' => 'Berlingo',
                    '206' => '206',
                    'Bt50' => 'Bt50',
                ], 
            ))
            ->add('etat', ChoiceType::class, array(
                'label' => false,
                'choices'  => [
                    
                    '5 places' => '5 places',
                    '2 places' => '2 places',
                ], 
            ))
            ->add('image',FileType::class,['mapped' => false,
                'attr' => array('accept' => 'image/jpeg,image/png')])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
