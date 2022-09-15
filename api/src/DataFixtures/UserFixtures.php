<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Pizza;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $object = (new User())
            ->setEmail('admin@admin.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('$2y$13$lcU8q43O/.uP61QqluKLIu4lc61JNAipxtpdE0Pcj.jID5gzkjH9O'); //admin

        $manager->persist($object);

        $object = (new User())
            ->setEmail('user@user.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword('$2y$13$ChxEMgI0cm6UC3aSAp5fk.1kuIdJrOk900CZ5.2PYiwZaOimgL4fy'); //user

        $manager->persist($object);

        $object = (new User())
            ->setEmail('director@director.fr')
            ->setRoles(['ROLE_DIRECTOR'])
            ->setPassword('$2y$13$NsHOoRXAHfkVvf56tH/4zurDuTWXlVEVtmlI3aIfFQ5MQNnX/CpJ6'); //director

        $manager->persist($object);
        $manager->flush();
    }
}
