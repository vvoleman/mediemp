<?php

namespace App\Form\DataTransformer;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToTransformer implements DataTransformerInterface {

    private $userRepository;
    /**
     * @var callable
     */
    private $finder_callback;

    public function __construct(UserRepository $userRepository, callable $finder_callback)
    {
        $this->userRepository = $userRepository;
        $this->finder_callback = $finder_callback;
    }

    /**
     * @inheritDoc
     */
    public function transform($value) {
        if (null === $value) {
            return '';
        }
        if (!$value instanceof User) {
            throw new \LogicException('The UserSelectTextType can only be used with User objects');
        }
        return $value->getEmail();
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value) {
        $callback = $this->finder_callback;
        $user = $callback($this->userRepository,$value);
        if (!$user) {
            throw new TransformationFailedException(sprintf('No user found with email "%s"', $value));
        }
        return $user;
    }

}