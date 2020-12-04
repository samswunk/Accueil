<?php

namespace App\Form;

use App\Entity\Consultants;
use App\Entity\Convocations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('nti', EntityType::class, [
                'class'         => Consultants::class,
                'choice_label'  => 'nom',
                'label'         => false,
                'multiple'      => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Convocations::class,
        ]);
    }
}
