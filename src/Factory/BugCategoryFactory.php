<?php

namespace App\Factory;

use App\Entity\BugCategory;
use App\Repository\BugCategoryRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<BugCategory>
 *
 * @method static BugCategory|Proxy createOne(array $attributes = [])
 * @method static BugCategory[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static BugCategory|Proxy find(object|array|mixed $criteria)
 * @method static BugCategory|Proxy findOrCreate(array $attributes)
 * @method static BugCategory|Proxy first(string $sortedField = 'id')
 * @method static BugCategory|Proxy last(string $sortedField = 'id')
 * @method static BugCategory|Proxy random(array $attributes = [])
 * @method static BugCategory|Proxy randomOrCreate(array $attributes = [])
 * @method static BugCategory[]|Proxy[] all()
 * @method static BugCategory[]|Proxy[] findBy(array $attributes)
 * @method static BugCategory[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static BugCategory[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BugCategoryRepository|RepositoryProxy repository()
 * @method BugCategory|Proxy create(array|callable $attributes = [])
 */
final class BugCategoryFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(16),
            'label' => self::faker()->text(32),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(BugCategory $bugCategory) {})
        ;
    }

    protected static function getClass(): string
    {
        return BugCategory::class;
    }
}
