<?php

namespace App\Form;

use App\Entity\Bug;
use App\Entity\BugCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BugReportType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('category', EntityType::class, [
                "class" => BugCategory::class,
                'label'=>'Kategorie'
            ])
            ->add('description',TextareaType::class,[
                'label'=>'Popis chyby'
            ]);

        if (!!$options['previous_url']) {
            $builder
                ->add('use_url', CheckboxType::class, [
                    'label' => "Použít předchozí URL adresu?",
                    'mapped' => false,
                    'required'=>false
                ])
                ->add('url', UrlType::class, [
                    'disabled' => true,
                    'mapped'=>false,
                    'data' => $options['previous_url']
                ]);
        }

        $builder
            ->add('screenshots', FileType::class, [
                'multiple' => true,
                'required' => false,
                'label'=>'Snímky obrazovky',
                'mapped'=>false
            ])
            ->add('submit',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Bug::class,
            'previous_url'=>null
        ]);
    }
}
