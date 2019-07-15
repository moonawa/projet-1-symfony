<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Employe;
use App\Entity\Service;

class EmployeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        //creer  3

        for($a=1; $a <=3; $a++){
            $service = new Service(); 

            $service->setLibelle($faker->senetence());
            $manager->persist($service);


            //creer dedans 
            for($i=1; $i <= mt_rand(4, 6); $i++){
                $employe = new Employe();

                $employe->setNom($faker->sentence())
                        ->setPrenom($faker->sentence())
                        ->setHbd($faker->dateTimeBetween('-6months'))
                        ->setEmail($faker->sentence())
                        ->setService($service);       
                $manager->persist($employe);
            }
    
        }
        
        $manager->flush();
    }
}

