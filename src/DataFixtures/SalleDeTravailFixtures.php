<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\SalleDeTravail;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SalleDeTravailFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $images = [ 
            'salle1.jpg',
            'salle2.jpg',
            'salle3.jpg',
            'salle4.jpg',
            'salle5.jpg' 
        ]; 

        for ( $i = 0; $i < 5; $i++ ) {
            $salleDeTravail = new SalleDeTravail();
            $salleDeTravail->setNom($faker->lastName());
            $salleDeTravail->setMaxCapacity($faker->numberBetween(3, 18));
            $salleDeTravail->setWifi($faker->boolean());
            $salleDeTravail->setProjector($faker->boolean());
            $salleDeTravail->setTableau($faker->boolean());
            $salleDeTravail->setPrisesElectric($faker->numberBetween(1, 4));
            $salleDeTravail->setTelevision($faker->boolean());
            $salleDeTravail->setClimatisation($faker->boolean());
            $salleDeTravail->setImage($images[$i]);

            $manager->persist($salleDeTravail);

        }
        $manager->flush();
    }
}
