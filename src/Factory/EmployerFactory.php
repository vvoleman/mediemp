<?php

namespace App\Factory;

use App\Entity\Employer;
use App\Repository\EmployerRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Employer>
 *
 * @method static Employer|Proxy createOne(array $attributes = [])
 * @method static Employer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Employer|Proxy find(object|array|mixed $criteria)
 * @method static Employer|Proxy findOrCreate(array $attributes)
 * @method static Employer|Proxy first(string $sortedField = 'id')
 * @method static Employer|Proxy last(string $sortedField = 'id')
 * @method static Employer|Proxy random(array $attributes = [])
 * @method static Employer|Proxy randomOrCreate(array $attributes = [])
 * @method static Employer[]|Proxy[] all()
 * @method static Employer[]|Proxy[] findBy(array $attributes)
 * @method static Employer[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Employer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EmployerRepository|RepositoryProxy repository()
 * @method Employer|Proxy create(array|callable $attributes = [])
 */
final class EmployerFactory extends ModelFactory
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
            'address' => self::faker()->address(),
            'provider_type' => self::faker()->text(),
            'form_of_care' => self::faker()->text(),
            'confirmToken' => self::faker()->md5(),
            'confirmEmail' => self::faker()->email(),
            'line_id' => 0
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Employer $employer) {})
        ;
    }

    protected static function getClass(): string
    {
        return Employer::class;
    }
}
