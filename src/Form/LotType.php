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
use App\Entity\Vente;
use Dom\Entity;
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
            ->add('heureDebutEnchere', null, [
                'widget' => 'single_text',
            ])
            ->add('vente', EntityType::class, [
                'class' => Vente::class,
                'choice_label' => function(Vente $entity){
                    return $entity->getId().' - '.$entity->getDateVente()->format('d/m/Y');
                },
            ])
            ->add('codeEtat')
            ->add('poidsBrutLot')
            ->add('qualite', EntityType::class, [
                'class' => Qualite::class,
                'choice_label' => function(Qualite $entity){
                    return $entity->getCode().' - '.$entity->getDenomination();
                },
            ])
            ->add('bac', EntityType::class, [
                'class' => Bac::class,
                'choice_label' => 'tare',
            ])
            ->add('presentation', EntityType::class, [
                'class' => Presentation::class,
                'choice_label' => function(Presentation $entity){
                    return $entity->getCode().' - '.$entity->getDenomination();
                },
            ])
            ->add('taille', EntityType::class, [
                'class' => Taille::class,
                'choice_label' => 'id',
            ])
            ->add('espece', EntityType::class, [
                'class' => Espece::class,
                'choice_label' => function(Espece $entity){
                    return $entity->getNomEspece().' - '.$entity->getNomCommunEspece();
                },
            ])
            ->add('peche', EntityType::class, [
                'class' => Peche::class,
                'choice_label' => function(Peche $entity){
                    return $entity->getId().' - '.$entity->getDatePeche()->format('d/m/Y').' - '.$entity->getBateau()->getNomBateau();
                },
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
