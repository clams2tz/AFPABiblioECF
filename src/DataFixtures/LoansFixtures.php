<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Loans;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class LoansFixtures extends Fixture implements FixtureGroupInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $users = $this->entityManager->getRepository('App\Entity\Users')->findAll();
        $books = $this->entityManager->getRepository('App\Entity\Books')->findAll();

        for ($i = 0; $i < 100; $i++) {
            $loan = new Loans();

            $user = $faker->randomElement($users);
            $book = $faker->randomElement($books);
            $loan->setUser($user);
            $loan->setBook($book);

            $borrowDate = $faker->dateTimeBetween('-3 months', 'now');
            $borrowDateImmutable = \DateTimeImmutable::createFromMutable($borrowDate);

            $dueDateImmutable = $borrowDateImmutable->modify('+1 week');

            $loan->setBorrowDate($borrowDateImmutable);
            $loan->setDueDate($dueDateImmutable);
            $loan->setExtension($faker->boolean(33));
            $loan->setReturned($faker->boolean(50));

            $manager->persist($loan);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['loans'];
    }
}
