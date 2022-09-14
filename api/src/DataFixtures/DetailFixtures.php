<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Detail;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DetailFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $orders = $manager->getRepository(Order::class)->findAll();
        $pizzas = $manager->getRepository(Pizza::class)->findAll();

        for($detail = 0; $detail < 4; $detail++) {
            $object = (new Detail())
                ->setPrice($faker->randomFloat(1, 20, 30))
                ->setSize($faker->randomElement(['S', 'M', 'L', 'XL']))
                ->setOrders($faker->randomElement($orders))
                ->setPizza($faker->randomElement($pizzas));

            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies() {
        return [
            OrderFixtures::class,
            PizzaFixtures::class,
        ];
    }
}
