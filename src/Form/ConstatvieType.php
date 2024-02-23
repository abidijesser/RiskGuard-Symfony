<?php

namespace App\Form;

use App\Entity\Constatvie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
class ConstatvieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('CIN')
            ->add('DateDeDeces', DateTimeType::class, [
                'widget' => 'single_text', ]) 
            ->add('CauseDeDeces')
            ->add('IdentifiantDeLinformant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Constatvie::class,
        ]);
    }
}
