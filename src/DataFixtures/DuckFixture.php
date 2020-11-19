<?php

namespace App\DataFixtures;

use App\Entity\Ducks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class DuckFixture extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }
    public function load(ObjectManager $manager)
    {
        $duck = new Ducks();
        $duck->setFirstname('Howard');
        $duck->setLastname('Duke');
        $duck->setDuckname('confit');
        $duck->setEmail('dudu@gmail.com');
        $duck->setPassword($this->passwordEncoder->encodePassword(
                         $duck,
                         'coincoin'
                     ));
        $duck->setRoles(array('ROLE_USER'));
        $manager->persist($duck);

        $manager->flush();
    }
}
