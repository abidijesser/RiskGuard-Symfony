<?php

namespace App\Form;

use App\Entity\ConstatVehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormVehiculeType extends AbstractType
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
            ->add('date')
            ->add('description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConstatVehicule::class,
        ]);
    }
}
