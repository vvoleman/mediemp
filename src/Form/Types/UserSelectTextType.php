<?php

namespace App\Form\Types;

use App\Form\DataTransformer\EmalToTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserSelectTextType extends AbstractType {

    public function getParent(): string {
        return TextType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->addModelTransformer(new EmalToTransformer());
    }


}