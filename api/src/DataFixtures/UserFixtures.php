<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $manager->flush();
    }
}
