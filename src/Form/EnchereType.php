<?php

namespace App\Form;

use App\Entity\Acheteur;
use App\Entity\Enchere;
use App\Entity\Lot;
use App\Entity\Vente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EnchereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prixEnchere', NumberType::class, array(
                'rounding_mode' => 0,
                'scale' => 2,
                'attr' => array(
                    'min' => 0,
                    'max' => 5000,
                    'step' => 0.01,
                ),
            ))
            // ->add('heureEnchere', TimeType::class, [
            //     'input' => 'datetime',
            //     'widget' => 'choice',
            // ])
            // ->add('Acheteur', EntityType::class, [
            //     'class' => Acheteur::class,
            //     'choice_label' => 'id',
            // ])
            ->add('lot', EntityType::class, [
                'class' => Lot::class,
                'choice_label' => 'id',
                'label' => false,
                'attr' => [
                    'hidden' => true,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enchere::class,
        ]);
    }
}
