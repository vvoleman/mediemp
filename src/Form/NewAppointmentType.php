<?php

namespace App\Form;

use App\Entity\CourseAppointment;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewAppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateTimeType::class,[
                "attr"=>[
                    "min"=>(new \DateTime())->modify("+ 1 hour")->format("Y-m-dTH:i")
                ],
                "widget"=>"single_text",
                "label"=>"Datum"
            ])
            ->add('place',TextType::class,[
                "label"=>"Místo"
            ])
            ->add('capacity',IntegerType::class,[
                "attr"=>[
                    "min"=>1
                ],
                "label"=>"Kapacita"
            ])
            ->add("submit",SubmitType::class,[
                "label"=>"Přidat"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseAppointment::class,
        ]);
    }
}
