<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredients = [
            "Tomate",
            "Mozzarella",
            "Basilic",
            "Jambon",
            "Champignons",
            "Emmental",
            "Roquefort",
            "Chèvre",
            "Reblochon",
            "Olives noires",
            "Artichauts",
            "Oignons",
            "Pepperoni",
            "Origan",
            "Ail",
            "Poivrons",
            "Courgettes",
            "Basilic",
            "Romarin",
            "Aneth",
            "Pommes de terre",
            "Ananas",
            "Saumon",
        ];

        for ($i = 0; $i < count($ingredients); $i++) {
            $object = (new Ingredient())
                ->setName($ingredients[$i]);

            $manager->persist($object);
        }

        $manager->flush();
    }
}