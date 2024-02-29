<?php

// src/Form/ReponseType.php
namespace App\Form;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Reclamation;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class, [
                'data' => new \DateTime(), // Définir la date à jour instantanée
                'label' => 'Date', // Vous pouvez ajouter une étiquette facultative
            ])
            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu de la réponse', // Étiquette pour le champ de contenu
            ])
            ->add('reclamation', EntityType::class, [
                'class' => Reclamation::class,
                'choice_label' => 'description', // ou toute autre propriété que vous voulez afficher comme libellé
                // autres options de champ
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}