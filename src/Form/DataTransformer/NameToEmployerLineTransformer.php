<?php

namespace App\Form\DataTransformer;

use App\Entity\EmployerLine;
use App\Repository\EmployerLineRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class NameToEmployerLineTransformer implements DataTransformerInterface{

    private EmployerLineRepository $repository;

    public function __construct(EmployerLineRepository $repository) {
        $this->repository = $repository;
    }

    public function transform($value) {
       if($value === NULL){
            return '';
       }

       if(!($value instanceof EmployerLine)){
            throw new \LogicException('The EmployerLineSelectTextType can only be used with EmployerLine objects');
       }

       return sprintf("%s (%s)",$value->getFacilityName(),$value->getFacilityType());
    }

    public function reverseTransform($value) {
        $el = $this->repository->findOneBy(['id'=>$value]);
        if(!$el){
            throw new TransformationFailedException(sprintf('No EmployerLine found with id="%s"',$value));
        }
        return $el;
    }


}