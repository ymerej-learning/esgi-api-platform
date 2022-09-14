<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Detail;
use Faker\Factory;
use App\Entity\Order;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $customers = $manager->getRepository(Customer::class)->findAll();

        for($order = 0; $order < 10; $order++) {
            $object = (new Order())
                ->setDatetime($faker->dateTime())
                ->setCustomer($faker->randomElement($customers));

            $manager->persist($object);
        }
        $manager->flush();
    }
}
