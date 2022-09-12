<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Detail;
use Faker\Factory;
use App\Entity\Order;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $customers = $manager->getRepository(Customer::class)->findAll();
        $details = $manager->getRepository(Detail::class)->findAll();

        for($order = 0; $order < 10; $order++) {
            $object = (new Order())
                ->setDatetime($faker->dateTime())
                ->setCustomer($faker->randomElement($customers));

            for($detail = 0; $faker->numberBetween(3, 8); $detail++) {
                $object->addDetail($faker->randomElement($details));
            }

            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies() {
        return [
            DetailFixtures::class
        ];
    }
}
