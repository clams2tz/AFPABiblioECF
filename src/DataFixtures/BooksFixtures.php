<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Books;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BooksFixtures extends Fixture
{
    public const BOOK_REFERENCE = 'book_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 200; $i++) {
            $book = new Books();
            $book->setTitle($faker->text(30));
            $book->setAuthor($faker->name());
            $book->setISBN($faker->ean13());
            $book->setReleaseDate($faker->year());
            $book->setBookCondition($faker->randomElement(['Excellent', 'Good', 'Fair', 'Poor']));
            $book->setSummary($faker->realText(500));
            $book->setReserved($faker->boolean());

            $manager->persist($book);

            // Ajoutez une référence
            $this->addReference(self::BOOK_REFERENCE . $i, $book);
        }

        $manager->flush();
    }
}
