<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;

trait PersistArrayTrait {

    public function persistArray(ObjectManager $manager, $array) {
        foreach ($array as $a){
            $manager->persist($a);
        }
    }

    public function persistArrayProxies(ObjectManager $manager, $array) {
        dd($array);
        foreach ($array as $a){
            $manager->persist($a->object());
        }
    }

}