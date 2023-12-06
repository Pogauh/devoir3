<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


use Faker\Factory;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $faker;
    private $passewordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this -> passwordHasher = $passwordHasher;
        $this -> faker = Factory::create("fr_FR");


    }

    public function load(ObjectManager $manager): void
    {
        for($i=0;$i<10;$i++){
            $user = new User();
            $user -> setNom($this->faker->lastName());
            $user -> setPrenom($this->faker->firstName());
            $user -> setEmail(strtolower($user->getPrenom().'.'.$user->getNom().'@'.$this->faker->freeEmailDomain()));
            $user->setPassword($this->passwordHasher->hashPassword($user,strtolower($user->getPrenom())));
            $user->setDateInscription($this->faker->dateTimeThisYear());
            $manager->persist($user);
        }
        

        $manager->flush();
    }
}
