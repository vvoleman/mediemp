<?php

namespace App\Factory;

use App\Entity\GlobalCourse;
use App\Repository\GlobalCourseRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<GlobalCourse>
 *
 * @method static GlobalCourse|Proxy createOne(array $attributes = [])
 * @method static GlobalCourse[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static GlobalCourse|Proxy find(object|array|mixed $criteria)
 * @method static GlobalCourse|Proxy findOrCreate(array $attributes)
 * @method static GlobalCourse|Proxy first(string $sortedField = 'id')
 * @method static GlobalCourse|Proxy last(string $sortedField = 'id')
 * @method static GlobalCourse|Proxy random(array $attributes = [])
 * @method static GlobalCourse|Proxy randomOrCreate(array $attributes = [])
 * @method static GlobalCourse[]|Proxy[] all()
 * @method static GlobalCourse[]|Proxy[] findBy(array $attributes)
 * @method static GlobalCourse[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static GlobalCourse[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static GlobalCourseRepository|RepositoryProxy repository()
 * @method GlobalCourse|Proxy create(array|callable $attributes = [])
 */
final class GlobalCourseFactory extends ModelFactory
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
            'name' => self::faker()->name(),
            'focus' => self::faker()->text(10),
            'specialization' => self::faker()->text(10),
            'keywords' => self::faker()->randomKey(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(GlobalCourse $globalCourse) {})
        ;
    }

    protected static function getClass(): string
    {
        return GlobalCourse::class;
    }
}
