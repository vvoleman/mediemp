<?php

namespace App\Form;

use App\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewEmployeeType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('email', EmailType::class, [
                'mapped' => false
            ])
            ->add('degree', TextType::class)
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('birth_city', TextType::class)
            ->add('citizenship', TextType::class)
            ->add('designation_of_professional_competence', TextType::class)
            ->add('diploma_number', TextType::class)
            ->add('diploma_date', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('specialized_competency', TextType::class)
            ->add('special_professional_or_special_specialized_competencies', TextType::class)
            ->add('identification_data_of_the_educational_establishment', TextType::class)
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
