<?php

namespace App\Service\Util;

class RandomService {

    public function string($length = 16, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function number(int $min, int $max){
        $max -= $min;
        return round($this->decimal()*$max)+$min;
    }

    public function decimal(){
        return mt_rand() / mt_getrandmax();
    }

}