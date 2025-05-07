<?php

namespace App\Form;

use App\Entity\Acheteur;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcheteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raisonSocialeEntreprise')
            ->add('numRue')
            ->add('rue')
            ->add('ville')
            ->add('codePostal')
            ->add('numHabilitation')
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function(User $entity){
                    return $entity->getLogin().' - '.$entity->getEmail();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acheteur::class,
        ]);
    }
}
