<?php

namespace App\Form;

use App\Entity\Bateau;
use App\Entity\TypeBateau;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BateauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tailleBateau')
            ->add('nomBateau')
            ->add('typeBateau', EntityType::class, [
                'class' => TypeBateau::class,
                'choice_label' => function(TypeBateau $entity){
                    return $entity->getId().' - '.$entity->getDesignation();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bateau::class,
        ]);
    }
}
