<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ingredient;
use App\Entity\Pizza;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $pizzas = $manager->getRepository(Pizza::class)->findAll();

        for($ingredient = 0; $ingredient < 10; $ingredient++) {
            $object = (new Ingredient())
                ->setName($faker->word());

            for($pizza = 0; $faker->numberBetween(3, 8); $pizza++) {
                $object->addPizza($faker->randomElement($pizzas));
            }

            $manager->persist($object);
        }
        $manager->flush();
    }
}
