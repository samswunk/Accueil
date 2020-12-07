<?php

namespace App\Form;

use App\Entity\Consultants;
use App\Entity\Convocations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Serializer;

class ConvocationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbrpersonnes')
            ->add('dateconvocation', DateTimeType::class, array
                    (
                        'widget'=> 'single_text',
                        'required' => true,
                        'attr' => 
                            [
                                'class' => 'form-control input-inline datetimepicker',
                                'data-provide' => 'datetimepicker',
                                'format'=> 'dd/MM/yyyy HH:mm',
                                'input' => 'string',
                                'input_format' => 'y-M-d HH:mm:ss'
                            ],
                        'html5'=> false,
                        'format'=> 'dd/MM/yyyy HH:mm', 
                        'label'=>'Date de convocation'                        
                    )
                )
            // ->add('nti', EntityType::class, [
            //     'class'         => Consultants::class,
            //     'choice_label'  => 'nom',
            //     'label'         => false,
            //     'multiple'      => true
            // ])
            
            // ->add('nti', EntityType::class, [
            //     // looks for choices from this entity
            //     'class'     => Consultants::class,
            //     // uses the User.username property as the visible option string
            //     'choice_label' => function ($user) 
            //                       {
            //                                 return json_encode([$user->getNom(),$user->getPrenom(),$user->getSexe(),$user->getNumSecu()]); 
            //                         },
            //     'attr' => 
            //         [
            //             'class' => 'form-control',
            //         ],
            //     // used to render a select box, check boxes or radios
            //     'multiple' => false,
            //     'expanded' => true
            // ])
            ->add('nti')    
                ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    // dd($tagsAsArray);
                    return $tagsAsArray;
                    /*return ([   ['id',$tagsAsArray->getId()],
                                ['NbrPersonnes',$tagsAsArray->getNbrPersonnes()],
                                ['dateconvocation',$tagsAsArray->getDateConvocation()],
                                ['nti',$tagsAsArray->getNti()]
                            ]);/**/
                },
                function ($tagsAsString) {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Convocations::class,
        ]);
    }
}
