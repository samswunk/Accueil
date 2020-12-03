<?php

namespace App\DataFixtures;

use App\Entity\Consultants as EntityConsultants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class Consultants extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $Faker = Faker\Factory::create("fr_FR");

        for ($i=0; $i < 100 ; $i++) { 

            $consultant = new EntityConsultants();
            
            $consultant->setNom($Faker->firstName);
            $consultant->setPrenom($Faker->lastName);
            $date = $Faker->dateTime();
            $moisDate = date_format($date, 'm');
            $anneeDate = date_format($date, 'y');
            $sexe = $Faker->numberBetween(1, 2);
            $consultant->setSexe($sexe);
            $ninsee = $sexe . $anneeDate . $moisDate  . '54' . $Faker->randomNumber(6, true);
            $consultant->setDdn($date);
            $consultant->setNumsecu($ninsee);
            $manager->persist($consultant);
        }

        $manager->flush();
    }
}
