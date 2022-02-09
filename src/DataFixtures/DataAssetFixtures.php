<?php

namespace App\DataFixtures;

use App\Entity\DataAsset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DataAssetFixtures extends Fixture implements FixtureGroupInterface{
    public function load(ObjectManager $manager): void {
        $asset = new DataAsset();
        $asset->setName("nrpzs");
        $asset->setType("csv");
        $asset->setChangeFrequencyDays(31);
        $asset->setSchemaFile("/files/data_assets/schemas/nrzps.json");
        $asset->setSourceLink("https://opendata.mzcr.cz/data/nrpzs/narodni-registr-poskytovatelu-zdravotnich-sluzeb.csv");

        $manager->persist($asset);
        $manager->flush();
    }

    public static function getGroups(): array {
        return ['group2','aaa'];
    }
}
