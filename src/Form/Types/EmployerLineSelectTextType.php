<?php

namespace App\Form\Types;

use App\Form\DataTransformer\NameToEmployerLineTransformer;
use App\Repository\EmployerLineRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployerLineSelectTextType extends AbstractType {

    private EmployerLineRepository $repository;

    public function __construct(EmployerLineRepository $repository) {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->addModelTransformer(
            new NameToEmployerLineTransformer($this->repository)
        );
    }

    public function getParent() {
        return TextType::class;
    }


}