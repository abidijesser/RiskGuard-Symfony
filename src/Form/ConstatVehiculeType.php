<?php

namespace App\Form;

use App\Entity\ConstatVehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ConstatVehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('CIN')
            ->add('TypeVehicule')
            ->add('marque')
            ->add('matricule')
            ->add('lieu')
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text', // This ensures that it's rendered as a single text input
                'html5' => true, // This tells Symfony to use HTML5 date input
                'attr' => ['class' => 'form-control'] // Add any additional attributes here
            ])
            ->add('description')
            ->add('photo', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => true,
                'attr' => ['accept' => 'image/*']
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre',
                'attr' => ['class' => 'btn btn-primary']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConstatVehicule::class,
        ]);
    }
}
