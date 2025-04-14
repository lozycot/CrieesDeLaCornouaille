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

class EnchereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prixEnchere')
            ->add('heureEnchere', null, [
                'widget' => 'single_text',
            ])
            ->add('Acheteur', EntityType::class, [
                'class' => Acheteur::class,
                'choice_label' => 'id',
            ])
            ->add('lot', EntityType::class, [
                'class' => Lot::class,
                'choice_label' => 'id',
            ])
            ->add('Vente', EntityType::class, [
                'class' => Vente::class,
                'choice_label' => 'id',
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
