<?php

namespace App\Form\Types;

use App\Form\DataTransformer\EmailToTransformer;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSelectTextType extends AbstractType {

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function getParent(): string {
        return TextType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->addModelTransformer(new EmailToTransformer(
                $this->userRepository,
                $options['finder_callback']
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'finder_callback'=>function(UserRepository $repository,string $email){
                return $repository->findOneBy(['email'=>$email]);
            }
        ]);
    }


}