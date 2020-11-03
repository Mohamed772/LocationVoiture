<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{


    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        /**
        $user = new User();
        $user->setAdmin(1);
        $user->setEmail("demo@demo.fr");
        $user->setUsername("demo");
        $user->setNom("demonstration");
        $user->setPassword($this->encoder->encodePassword($user,"demo"));
        $manager->persist($user);
        $manager->flush();
        */
        $user = new User();
        $user->setAdmin(0);
        $user->setEmail("user@user.fr");
        $user->setUsername("user77");
        $user->setNom("Jean Baptiste");
        $user->setPassword($this->encoder->encodePassword($user,"user"));
        $manager->persist($user);
        $manager->flush();
    }

}
