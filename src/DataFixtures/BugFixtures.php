<?php

namespace App\DataFixtures;

use App\Entity\BugCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class BugFixtures extends Fixture implements FixtureGroupInterface {
    use PersistArrayTrait;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }


    public function load(ObjectManager $manager): void {
        $conn = $this->entityManager->getConnection();
        $conn->executeStatement("ALTER TABLE bug_category AUTO_INCREMENT = 1");

        $categories = [
            ["name" => "ui", "label" => "Uživatelské rozhraní"],
            ["name" => "not_working", "label" => "Nefunkční prvek"],
            ["name" => "idea", "label" => "Nápad"]
        ];

        $cats = $this->makeCategories($categories);

        $this->persistArray($manager, $cats);

        $manager->flush();
    }

    private function makeCategories(array $data): array {
        $categories = [];
        foreach ($data as $d) {
            $c = new BugCategory();
            $c->setLabel($d["label"]);
            $c->setName($d["name"]);
            $categories[] = $c;
        }
        return $categories;
    }

    public static function getGroups(): array {
        return ['group1', 'group2'];
    }
}
