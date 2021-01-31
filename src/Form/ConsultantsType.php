<?php

namespace App\Form;

use App\Entity\Consultants;
use App\Entity\Convocations;
use App\Form\Transformer\DateToStringTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;

class ConsultantsType extends AbstractType
{
    private $transformer;

    public function __construct(DateToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => 
                    [
                        'class' => 'form-control'
                    ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => 
                    [
                        'class' => 'form-control'
                    ]
            ])
            ->add('numsecu', NumberType::class, [
                'attr' => 
                    [
                        'class' => 'form-control'
                    ]
            ])
            ->add('sexe', NumberType::class, [
                'attr' => 
                    [
                        'class' => 'form-control'
                    ],
                    'label' => 'sexe'
            ])
            ->add('ddn', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                // this is actually the default format for single_text
                'format' => 'dd/MM/yyyy',
                'attr' => 
                    [
                        'date_label' => 'Date de Naissance',
                        'class' => 'form-control datetimepicker'
                    ]
            ])
            ->add('convocations',EntityType::class, [
                // 'mapped' => false,
                'class' => Convocations::class,
                'choice_label' => function ($convocations) 
                        { 
                            return $convocations->getDateconvocation()->format('d/m/Y H:i'); 
                            },
                'label'         => 'Convoqué.e le : ',
                'attr' => 
                    [
                        'class' => 'form-control datepicker'
                    ]
            ])
            // ->addModelTransformer($this->transformer)
            // ->add('parents',EntityType::class, [
            //     'class'         => Consultants::class,
            //     'choice_label'  => function ($consultants) 
            //         { 
            //             return $consultants->getPrenom() .' '. $consultants->getNom() .' '. $consultants->getNumSecu(); 
            //         },
            //     'label'         => false,
            //     'multiple'      => false,
            //     'attr' => 
            //         [
            //             'class' => 'form-control'
            //         ]
            // ])
            // ->add('parents',CollectionType::class, [
            //     'entry_type' => ConsultantsType::class,
            //     'entry_options' => ['label' => 'Parents'],
            //     // 'allow_add' => true,
            //     // 'allow_delete'  => true,
            //     // 'prototype'     => true,
            //     // 'required'      => false,
            //     // 'delete_empty'  => true,
            // ])
            // ->add('enfants',EntityType::class, [
            //     'class' => Consultants::class,
            //     'choice_label'  => function ($consultants) 
            //         { 
            //             return $consultants->getPrenom() .' '. $consultants->getNom() .' '. $consultants->getNumSecu(); 
            //         },
            //     'expanded' => true,
            //     'multiple' => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultants::class,
        ]);
    }
}
