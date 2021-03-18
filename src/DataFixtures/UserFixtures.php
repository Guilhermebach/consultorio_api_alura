<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User;

        $user->setUsername('guilherme')
             ->setPassword('$argon2id$v=19$m=65536,t=4,p=1$bnptMEY5MFB2a2ZoM014eQ$ziRsE/RtU3Mhils0uyrt8Fpku2+4xLX/AivJU8a4I80');
        
        $manager->persist($user);

        $manager->flush();
    }
}
