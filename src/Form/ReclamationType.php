<?php

namespace App\Form;

use App\Entity\Reclamation; // Assurez-vous que vous utilisez la classe Reclamation depuis l'entité
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_reclamation', HiddenType::class) // Add this line to include the id field
            ->add('nom_client', TextType::class)
            ->add('email_client', TextType::class)
            ->add('num_tel', TextType::class)
            ->add('description', TextareaType::class);
        // Ne pas ajouter le champ 'etat' ici
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class, // Assurez-vous que le data_class est bien défini sur l'entité Reclamation
        ]);
    }
}
