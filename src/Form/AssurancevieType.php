<?php

namespace App\Form;

use App\Entity\Assurancevie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssurancevieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datedebut')
            ->add('periodevalidation')
            ->add('salaireclient')
            ->add('fichedepaie', FileType::class, [
                'label' => 'assurance Image',
                'mapped' => true,
                'required' => false,
            ])            ->add('reponse')
            ->add('assurance');
        $builder->get('fichedepaie')->addModelTransformer(new FileTransformer());

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assurancevie::class,
        ]);
    }
}
