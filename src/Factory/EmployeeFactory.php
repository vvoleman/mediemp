<?php

namespace App\Factory;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Employee>
 *
 * @method static Employee|Proxy createOne(array $attributes = [])
 * @method static Employee[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Employee|Proxy find(object|array|mixed $criteria)
 * @method static Employee|Proxy findOrCreate(array $attributes)
 * @method static Employee|Proxy first(string $sortedField = 'id')
 * @method static Employee|Proxy last(string $sortedField = 'id')
 * @method static Employee|Proxy random(array $attributes = [])
 * @method static Employee|Proxy randomOrCreate(array $attributes = [])
 * @method static Employee[]|Proxy[] all()
 * @method static Employee[]|Proxy[] findBy(array $attributes)
 * @method static Employee[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Employee[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static EmployeeRepository|RepositoryProxy repository()
 * @method Employee|Proxy create(array|callable $attributes = [])
 */
final class EmployeeFactory extends ModelFactory
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
            'name' => self::faker()->firstName(),
            'surname' => self::faker()->lastName(),
            'degree' => self::faker()->randomElement(["Bc.","Mudr."]),
            'birthday' => new \DateTime(self::faker()->date()),
            'birth_city' => self::faker()->city(),
            'citizenship' => self::faker()->countryCode(),
            'designation_of_professional_competence' => self::faker()->text(),
            'diploma_number' => self::faker()->text(32),
            'diploma_date' => new \DateTime(self::faker()->date()),
            'specialized_competency' => self::faker()->text(64),
            'special_professional_or_special_specialized_competencies' => self::faker()->text(64),
            'identification_data_of_the_educational_establishment' => self::faker()->text(64),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Employee $employee) {})
        ;
    }

    protected static function getClass(): string
    {
        return Employee::class;
    }
}
