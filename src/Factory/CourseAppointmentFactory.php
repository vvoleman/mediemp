<?php

namespace App\Factory;

use App\Entity\CourseAppointment;
use App\Repository\CourseAppointmentRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CourseAppointment>
 *
 * @method static CourseAppointment|Proxy createOne(array $attributes = [])
 * @method static CourseAppointment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CourseAppointment|Proxy find(object|array|mixed $criteria)
 * @method static CourseAppointment|Proxy findOrCreate(array $attributes)
 * @method static CourseAppointment|Proxy first(string $sortedField = 'id')
 * @method static CourseAppointment|Proxy last(string $sortedField = 'id')
 * @method static CourseAppointment|Proxy random(array $attributes = [])
 * @method static CourseAppointment|Proxy randomOrCreate(array $attributes = [])
 * @method static CourseAppointment[]|Proxy[] all()
 * @method static CourseAppointment[]|Proxy[] findBy(array $attributes)
 * @method static CourseAppointment[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CourseAppointment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CourseAppointmentRepository|RepositoryProxy repository()
 * @method CourseAppointment|Proxy create(array|callable $attributes = [])
 */
final class CourseAppointmentFactory extends ModelFactory
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
            'date' => new \DateTime(), // self::faker()->dateTimeBetween("now","+2 months"),
            'place' => self::faker()->city(),
            'capacity' => 10//self::faker()->numberBetween(1,100),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CourseAppointment $courseAppointment) {})
        ;
    }

    protected static function getClass(): string
    {
        return CourseAppointment::class;
    }
}
