<?php

namespace App\Form;

use App\Entity\EmployerLine;
use App\Form\Types\CheckEmailType;
use App\Form\Types\EmployerLineSelectTextType;
use App\Repository\EmployerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class NewEmployerType extends AbstractType {

    private EmployerRepository $repository;

    public function __construct(EmployerRepository $repository) {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add("email", CheckEmailType::class);
        $builder->add('employer_id',EmployerLineSelectTextType::class,[
            'label'=>'Organizace',
            'multiple'=>false,
            'expanded'=>false,
            'row_attr'=>['class'=>'select-autocomplete']
        ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $form->remove('employer_id');
            $form->add('employer_id', EmployerLineSelectTextType::class, array(
                'attr' => array(
                    'class' => 'choiceField',
                ),
                'choices' => array(
                    $data['employer_id'] => $data['employer_id'],
                )
            ));
        });

        $builder->add('submit', SubmitType::class);
    }


}