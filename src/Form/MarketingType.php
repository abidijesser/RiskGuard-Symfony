<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Marketing;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MarketingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255]),
                
            ],
        ])
        ->add('objectif', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['max' => 255]),
            ],
        ])
        ->add('budget', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'numeric']),
                // Add more constraints as needed
            ],
        ])
        ->add('dateDebut')
        ->add('dateFin')
        ->add('image', FileType::class, [
            'data_class' => null,
            'constraints' => [
                new Assert\File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG)',
                ]),
            ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name', // Assuming 'name' is the property of Categorie entity you want to display in the dropdown
                'placeholder' => 'Choose a category', // Optional placeholder
            ]);
        ;
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Marketing::class,
        ]);
    }
}
