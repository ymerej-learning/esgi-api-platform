<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($ingredient = 0; $ingredient < 30; $ingredient++) {
            $object = (new Ingredient())
                ->setName($faker->word());

            $manager->persist($object);
        }
        $manager->flush();
    }
}
