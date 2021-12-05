<?php

namespace App\Form;

use App\Form\Types\CheckEmailType;
use App\Form\Types\EmployerLineSelectTextType;
use App\Repository\EmployerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class NewEmployerType extends AbstractType {

    private EmployerRepository $repository;

    public function __construct(EmployerRepository $repository) {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add("email",CheckEmailType::class);
        $builder->add('employer_id',EmployerLineSelectTextType::class,[
            'label'=>'Organizace',
            'multiple'=>false,
            'expanded'=>false,
            'row_attr'=>['class'=>'select-autocomplete']
        ]);

        $builder->add('submit',SubmitType::class);
    }


}