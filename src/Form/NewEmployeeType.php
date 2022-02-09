<?php

namespace App\Form;

use App\Entity\Employee;
use App\Form\Types\CheckEmailType;
use App\Form\Types\PersonIdType;
use App\Repository\UserRepository;
use PharIo\Manifest\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewEmployeeType extends AbstractType {

    public function __construct(private UserRepository $repository) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        if ($options['mode'] == 'full' || $options['mode'] == 'only-data') {
            $builder
                ->add('name', TextType::class,[
                    "label"=>"Jméno"
                ])
                ->add('surname', TextType::class,
                    [
                        "label"=>"Příjmení"
                    ]);
                if($options['mode'] != "full"){
                    $builder->add('email',EmailType::class,[
                        'label'=>'E-mail pro zaslání odkazu pro vytvoření přihl. údajů',
                        'mapped'=>false
                    ]);
                }
                $builder->add('address',TextType::class,[
                    'label'=>"Adresa"
                ]);
                $builder->add('person_id',PersonIdType::class,[
                    'label'=>"Rodné číslo"
                ]);
                $builder->add('gender',ChoiceType::class,[
                    "choices"=>[
                        "Muž"=>"male",
                        "Žena"=>"female"
                    ],
                    "label"=>"Pohlaví"
                ]);
                $builder->add('degree', TextType::class,[
                    "label"=>"Titul"
                ])
                ->add('birthday', DateType::class, [
                    'widget' => 'single_text',
                    "label" => "Datum narození"
                ])
                ->add('birth_city', TextType::class,[
                    "label"=>"Město narození"
                ])
                ->add('citizenship', TextType::class,[
                    "label"=>"Státní občanství"
                ])
                ->add('designation_of_professional_competence', TextType::class,[
                    "label"=>"Označení odborné způsobilosti"
                ])
                ->add('diploma_number', TextType::class,[
                    "label"=>"Číslo diplomu"
                ])
                ->add('diploma_date', DateType::class, [
                    'widget' => 'single_text',
                    "label"=>"Datum získání diplomu"
                ])
                ->add('specialized_competency', TextType::class,[
                    "label"=>"Speciální kompetence"
                ])
                ->add('special_professional_or_special_specialized_competencies', TextType::class,[
                    "label"=>"Zvláštní odborné nebo zvláštní specializované způsobilosti"
                ])
                ->add('identification_data_of_the_educational_establishment', TextType::class,[
                    "label"=>"Identifikační údaje vzdělávacího zařízení"
                ]);
        }

        if ($options['mode'] == 'full' || $options['mode'] == "only-credentials") {
            $builder
                ->add('email', CheckEmailType::class, [
                    'mapped' => false,
                    'finder_callback' => function (UserRepository $repository, string $email) {
                        return $repository->findOneBy(["email" => $email]);
                    },
                    'repository' => $this->repository
                ])
                ->add('password', RepeatedType::class, [
                    'mapped'=>false,
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Heslo'],
                    'second_options' => ['label' => 'Heslo znovu'],
                ]);
        }

        $builder->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Employee::class,
            'mode' => 'full'//full, only-data, only-credentials
        ]);
    }
}
