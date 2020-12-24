<?php

namespace App\Form;

use App\Entity\Consultants;
use App\Entity\Convocations;
use App\Form\Transformer\DateToStringTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            // ->add('parent', CollectionType::class)
            // ->add('enfant')
            ->add('convocations',EntityType::class, [
                // 'mapped' => false,
                'class' => Convocations::class,
                'choice_label' => function ($convocations) 
                        { return $convocations->getDateconvocation()->format('d/m/Y H:i'); 
                            },
                'label'         => 'Convocation : ',
                'attr' => 
                    [
                        'class' => 'form-control datetimepicker'
                    ]
            ])
            // ->addModelTransformer($this->transformer)
            // ->add('convocations',EntityType::class, [
            //     'class'         => Convocations::class,
            //     'choice_label'  => 'dateconvocation',
            //     'label'         => false,
            //     'multiple'      => false,
            //     'attr' => 
            //         [
            //             'class' => 'form-control'
            //         ]
            // ])
            ->add('enfant',EntityType::class, [
                'class'         => Consultants::class,
                'choice_label' => function ($consultants) 
                    { return $consultants->getNom()." " . $consultants->getPrenom(); 
                        },
                'label'         => 'Enfant(s)',
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
            'data_class' => Consultants::class,
        ]);
    }
}
