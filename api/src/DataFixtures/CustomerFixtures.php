<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for($customer = 0; $customer < 10; $customer++) {
            $object = (new Customer())
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setPhone($faker->phoneNumber())
                ->setAddress($faker->address());

            $manager->persist($object);
        }
        $manager->flush();
    }
}
