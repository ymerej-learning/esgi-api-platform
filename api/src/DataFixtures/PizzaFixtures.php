<?php

namespace App\DataFixtures;

use App\Entity\Detail;
use Faker\Factory;
use App\Entity\Pizza;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PizzaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $ingredients = $manager->getRepository(Ingredient::class)->findAll();

        for($pizza = 0; $pizza < 10; $pizza++) {
            $object = (new Pizza())
                ->setName($faker->name())
                ->setDescription($faker->paragraph());

            for($ingredient = 0; $faker->numberBetween(3, 8); $ingredient++) {
                $object->addIngredient($faker->randomElement($ingredients));
            }

            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies() {
        return [
            IngredientFixtures::class
        ];
    }
}
