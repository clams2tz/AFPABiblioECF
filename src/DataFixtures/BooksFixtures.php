<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Books;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BooksFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ( $i = 0; $i < 200; $i++ ) {
            $books = new Books();
            $books->setTitle($faker->text(30));
            $books->setAuthor($faker->name($gender = null));
            $books->setISBN($faker->ean13());
            $var = $faker->numberBetween(1,4);
            switch( $var ) {
                case 1: $books->setBookCondition('Excellent');
                break;
                case 2: $books->setBookCondition('Good'); 
                break;
                case 3: $books->setBookCondition('Fair');
                break;
                case 4: $books->setBookCondition('Poor');
                break;
            }
            $books->setSummary($faker->realText($maxNbChars = 500, $indexSize =2));
            $books->setReserved($faker->boolean()); 
            $manager->persist($books);

        }
        $manager->flush();
    }
}
