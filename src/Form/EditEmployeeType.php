<?php

namespace App\Form;

use App\Entity\Employee;
use App\Form\Types\PersonIdType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class EditEmployeeType extends AbstractType {

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.name")
                ]
            ])
            ->add('surname', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.surname")
                ]
            ])
            ->add('degree', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.degree")
                ]
            ])
            ->add('birthday', DateType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.birthday")
                ],
                "widget" => "single_text"
            ])
            ->add('birth_city', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.birth_city")
                ]
            ])
            ->add('citizenship', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.citizenship")
                ]
            ])
            ->add('designation_of_professional_competence', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.designation_of_professional_competence")
                ]
            ])
            ->add('diploma_number', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.diploma_number")
                ]
            ])
            ->add('diploma_date', DateType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.diploma_date")
                ],
                "widget" => "single_text"
            ])
            ->add('specialized_competency', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.specialized_competency")
                ]
            ])
            ->add('special_professional_or_special_specialized_competencies', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.special_professional_or_special_specialized_competencies")
                ]
            ])
            ->add('identification_data_of_the_educational_establishment', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.identification_data_of_the_educational_establishment")
                ]
            ])
            ->add('address', TextType::class, [
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.address")
                ]            ])
            ->add('person_id',PersonIdType::class,[
                "attr"=>[
                    "placeholder" => $this->translator->trans("employee.attributes.person_id")
                ]            ])
            ->add('gender',ChoiceType::class,[
                "choices"=>[
                    $this->translator->trans("global.genders.male") => 'male',
                    $this->translator->trans("global.genders.female") => 'female',
                    $this->translator->trans("global.genders.other") => 'other',
                ],
                'placeholder'=>$this->translator->trans("employee.attributes.gender")
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Uložit'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
