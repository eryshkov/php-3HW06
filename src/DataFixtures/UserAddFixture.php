<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserAddFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        
        $user->setEmail('eryshkov@gmail.com');
        $manager->persist($user);
        
        $user = new User();
        
        $user->setEmail('eryshkov.ios@gmail.com');
        $manager->persist($user);

        $manager->flush();
    }
}
