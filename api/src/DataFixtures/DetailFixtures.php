<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Detail;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DetailFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($detail = 0; $detail < 4; $detail++) {
            $object = (new Detail())
                ->setPrice($faker->randomFloat(1, 20, 30))
                ->setSize($faker->randomElement(['S', 'M', 'L', 'XL']));

            $manager->persist($object);
        }
        $manager->flush();
    }
}
