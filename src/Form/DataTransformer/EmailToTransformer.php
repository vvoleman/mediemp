<?php

namespace App\Form\DataTransformer;

use App\Entity\User;
use App\Repository\EmployerRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToTransformer implements DataTransformerInterface {

    private $repository;
    /**
     * @var callable
     */
    private $finder_callback;

    public function __construct(ServiceEntityRepository $repository, callable $finder_callback)
    {
        $this->repository = $repository;
        $this->finder_callback = $finder_callback;
    }

    /**
     * @inheritDoc
     */
    public function transform($value) {
        if (null === $value) {
            return '';
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value) {
        $callback = $this->finder_callback;
        $user = $callback($this->repository,$value);
        if ($user) {
            throw new TransformationFailedException(sprintf('Callback returned false for "%s"', $value));
        }
        return $value;
    }

}