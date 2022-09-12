<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Order;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $orders = $manager->getRepository(Order::class)->findAll();

        for($customer = 0; $customer < 10; $customer++) {
            $object = (new Customer())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setPhone($faker->phoneNumber())
                ->setAddress($faker->address());

            for($order = 0; $faker->numberBetween(3, 8); $order++) {
                $object->addOrder($faker->randomElement($orders));
            }

            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies() {
        return [
            OrderFixtures::class  
        ];
    }
}
