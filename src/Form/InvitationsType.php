<?php

namespace App\Form;

use App\Entity\Consultants;
use App\Entity\Invitations;
use App\Entity\TypeInvitation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvitationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('dateinvitation')
            ->add('dateinvitation', DateTimeType::class, array
                    (
                        'widget'=> 'single_text',
                        'required' => true,
                        'attr' => 
                            [
                                'class'         => 'form-control input-inline datetimepicker',
                                'data-provide'  => 'datetimepicker',
                                'format'        => 'dd/MM/yyyy HH:mm',
                                'input'         => 'string',
                                'input_format'  => 'y-M-d HH:mm:ss'
                            ],
                        'html5'=> false,
                        'format'=> 'dd/MM/yyyy HH:mm', 
                        'label'=>'Date et heure de l\'invitation'                        
                    )
                )
            ->add('nbrpersonnes')
            // ->add('typeinvitation')
            ->add('typeinvitation',EntityType::class, [
                'class'         => TypeInvitation::class,
                'choice_label'  => 'libtypeinvitation',
                'label'         => 'Type d\'invitation',
                'multiple'      => false,
                'attr' => 
                [
                    'class' => 'form-control'
                ]
            ])
            // ->add('nti', CollectionType::class, [
            //     'entry_type' => ConsultantsType::class,
            //     'entry_options' => ['label' => false],
            //     'allow_add' => true,
            //     'attr' => 
            //     [
            //         'class' => 'form-control'
            //     ]
            // ])
            // ->add('nti',EntityType::class, [
            //     'class'         => Consultants::class,
            //     'choice_label' => function ($consultants) 
            //         { return $consultants->getNom()." " . $consultants->getPrenom(); 
            //             },
            //     'label'         => 'Personne',
            //     'attr' => 
            //     [
            //         'class' => 'form-control'
            //     ],
            //     'multiple' => true,
            //     'expanded' => true
            // ])
            // ->add('nti')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Invitations::class,
        ]);
    }
}
