<?php

namespace App\Form\Types;

use App\Form\DataTransformer\EmailToTransformer;
use App\Repository\EmployerRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckEmailType extends AbstractType {

    private EmployerRepository $repository;

    public function __construct(EmployerRepository $repository) {
        $this->repository = $repository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->addModelTransformer(new EmailToTransformer(
                $options['repository'],
                $options['finder_callback']
            ));
    }

    public function getParent() {
        return EmailType::class;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'finder_callback'=> function(EmployerRepository $repository,string $email){
                return $repository->findOneBy(["confirmEmail"=>$email]);
            },
            'repository' => $this->repository,
            'invalid_message' => 'Tento email byl již pro potvrzení organizace použit!',
        ]);
    }


}