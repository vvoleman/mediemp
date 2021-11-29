<?php

namespace App\Form;

use App\Form\Types\EmployerLineSelectTextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class NewEmployerType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('employer_name',EmployerLineSelectTextType::class);
        $builder->add('search_name',SearchType::class,[
            'data_class'=>'js-user-autocomplete'
        ]);

        $builder->add('submit',SubmitType::class);
    }


}