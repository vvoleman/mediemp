<?php

namespace App\Form\DataTransformer;

use App\Service\Util\VerifyPersonIdTrait;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PersonIdTransformer implements DataTransformerInterface{

    use VerifyPersonIdTrait;

    public function transform($value) {
        if (null === $value) {
            return '';
        }
        return $value;
    }

    public function reverseTransform($value) {
        $result = $this->verifyPersonId($value);
        if(!$result){
            throw new TransformationFailedException(sprintf("Invalid personID '%s'",$value));
        }

        return $value;
    }


}