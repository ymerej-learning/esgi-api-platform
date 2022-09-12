<?php

namespace App\DataFixtures;

use App\Entity\Detail;
use App\Entity\Order;
use App\Entity\Pizza;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DetailFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $orders = $manager->getRepository(Order::class)->findAll();
        $pizzas = $manager->getRepository(Pizza::class)->findAll();

        for($detail = 0; $detail < 10; $detail++) {
            $object = (new Detail())
                ->setPrice($faker->randomFloat())
                ->setSize($faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']));

            for($order = 0; $faker->numberBetween(3, 8); $order++) {
                $object->setOrders($faker->randomElement($orders))
                    ->setPizza($faker->randomElement($pizzas));
            }

            $manager->persist($object);
        }
        $manager->flush();
    }
}
