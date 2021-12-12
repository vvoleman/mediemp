<?php

namespace App\Form\Types;

use App\Form\DataTransformer\PersonIdTransformer;
use App\Repository\EmployerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonIdType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->addModelTransformer(new PersonIdTransformer());
    }

    public function getParent(): string {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'invalid_message' => 'Neplatné rodné číslo!',
        ]);
    }

}