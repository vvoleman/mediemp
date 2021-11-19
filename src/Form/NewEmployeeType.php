<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewEmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('degree')
            ->add('birthday',DateTimeType::class)
            ->add('birth_city')
            ->add('citizenship')
            ->add('designation_of_professional_competence')
            ->add('diploma_number')
            ->add('diploma_date')
            ->add('employer',HiddenType::class,["value"=>$options["employer"]])
            ->add('specialized_competency')
            ->add('special_professional_or_special_specialized_competencies')
            ->add('identification_data_of_the_educational_establishment')
            ->add('managing')
            ->add('identity')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
            'employer' => null
        ]);
    }
}
