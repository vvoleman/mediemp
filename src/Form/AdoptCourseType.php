<?php

namespace App\Form;

use App\Repository\GlobalCourseRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdoptCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('course',EntityType::class,[
                'label'=>'Kurz',
                'class'=>'App\Entity\GlobalCourse',
                'placeholder'=>'-- Vyberte kurz --',
                'query_builder'=>function(EntityRepository $r)use($options){
                    /** @var GlobalCourseRepository $r */
                    return $r->availableGlobalCoursesQueryBuilder($options["employer_id"]);
                },
                'choice_label' => 'name'
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Přidat'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'employer_id'=>null
        ]);
    }
}
