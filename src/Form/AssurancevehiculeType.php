<?php

namespace App\Form;

use App\Entity\Assurancevehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssurancevehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque')
            ->add('modele')
            ->add('matricule')
            ->add('datedebut')
            ->add('periodedevalidation')
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false, // Image is not required
                'empty_data' => ''

            ])
            ->add('assurance');
               $builder->get('image')->addModelTransformer(new FileTransformer());
 ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assurancevehicule::class,

        ]);
    }
}
