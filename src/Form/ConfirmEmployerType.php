<?php

namespace App\Form;

use App\Entity\Employer;
use App\Form\Types\CheckEmailType;
use App\Repository\EmployeeRepository;
use App\Repository\EmployerRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfirmEmployerType extends AbstractType
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                "label" => "Název"
            ])
            ->add('address',TextType::class,[
                "label"=>"Adresa"
            ])
            ->add('provider_type',TextareaType::class,[
                "label"=>"Typ poskytovatele"
            ])
            ->add('form_of_care',TextareaType::class,[
                "label"=>"Forma péče"
            ])
            ->add('manager_email',CheckEmailType::class,[
                'finder_callback'=>function(UserRepository $repository, string $email){
                    return $repository->findOneBy(["email"=>$email]);
                },
                'repository'=>$this->repository,
                'label'=>'Email manažera',
                'mapped'=>false,
                'data'=>$options['manager_email']
            ])
            ->add('submit',SubmitType::class,[
                "label"=>"Odeslat"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employer::class,
            'manager_email'=>''
        ]);
    }
}
