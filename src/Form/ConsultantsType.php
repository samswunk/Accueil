<?php

namespace App\Form;

use App\Entity\Consultants;
use App\Entity\Convocations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('numsecu')
            ->add('sexe')
            ->add('ddn')
            // ->add('parent', CollectionType::class)
            // ->add('enfant')
            ->add('convo',EntityType::class, [
                'class'         => Convocations::class,
                'choice_label'  => 'dateconvocation',
                'label'         => false,
                'multiple'      => false
            ])
            ->add('enfant',EntityType::class, [
                'class'         => Consultants::class,
                'choice_label'  => 'nom',
                'label'         => false,
                'multiple'      => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultants::class,
        ]);
    }
}
