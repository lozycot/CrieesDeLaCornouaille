<?php

namespace App\Form;

use App\Entity\Acheteur;
use App\Entity\Bac;
use App\Entity\Espece;
use App\Entity\Lot;
use App\Entity\Peche;
use App\Entity\Presentation;
use App\Entity\Qualite;
use App\Entity\Taille;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prixPlancher')
            ->add('prixDepart')
            ->add('prixEncheresMax')
            ->add('dateEnchere', null, [
                'widget' => 'single_text',
            ])
            ->add('heureDebutEnchere', null, [
                'widget' => 'single_text',
            ])
            ->add('codeEtat')
            ->add('idFacture')
            ->add('poidsBrutLot')
            ->add('qualite', EntityType::class, [
                'class' => Qualite::class,
                'choice_label' => 'id',
            ])
            ->add('acheteur', EntityType::class, [
                'class' => Acheteur::class,
                'choice_label' => 'id',
            ])
            ->add('bac', EntityType::class, [
                'class' => Bac::class,
                'choice_label' => 'id',
            ])
            ->add('presentation', EntityType::class, [
                'class' => Presentation::class,
                'choice_label' => 'id',
            ])
            ->add('taille', EntityType::class, [
                'class' => Taille::class,
                'choice_label' => 'id',
            ])
            ->add('espece', EntityType::class, [
                'class' => Espece::class,
                'choice_label' => 'id',
            ])
            ->add('peche', EntityType::class, [
                'class' => Peche::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lot::class,
        ]);
    }
}
