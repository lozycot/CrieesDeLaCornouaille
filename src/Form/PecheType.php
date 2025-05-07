<?php

namespace App\Form;

use App\Entity\Bateau;
use App\Entity\Peche;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PecheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datePeche', null, [
                'widget' => 'single_text',
            ])
            ->add('dureeMaree')
            ->add('bateau', EntityType::class, [
                'class' => Bateau::class,
                'choice_label' => function(Bateau $entity){
                    return $entity->getId().' - '.$entity->getNomBateau();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Peche::class,
        ]);
    }
}
