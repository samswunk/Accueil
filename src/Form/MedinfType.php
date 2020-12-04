<?php

namespace App\Form;

use App\Entity\Fonction;
use App\Entity\Medinf;
use App\Entity\Metier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedinfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule')
            ->add('nom')
            ->add('prenom')
            ->add('telmedinf')
            ->add('adresse')
            ->add('metier',EntityType::class, [
                'class'         => Metier::class,
                'choice_label' => function ($metier) 
                    { return $metier->getLibMetier() ." (".$metier->getCodeProfession().")" ; 
                        },
                'label'         => 'Profession',
                'multiple'      => true, 
                'attr' => 
                [
                    'class' => 'form-control'
                ],
            ])
            ->add('fonction',EntityType::class, [
                'class'         => Fonction::class,
                'choice_label'  => 'libfonction',
                'label'         => 'Fonction',
                'multiple'      => false,
                'attr' => 
                [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medinf::class,
        ]);
    }
}
