<?php

//Fichier à enlever du dossier avant de générer les fixtures.
//Ensuite, remettre ce fichier dans src/DataFixtures
//Dans la console, run : symfony console doctrine:fixtures:load --append --group=reservations

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\SalleDeTravail;
use App\Entity\Reservations;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;


class ReservationsFixtures extends Fixture implements FixtureGroupInterface
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
        $salles = $this->entityManager->getRepository('App\Entity\SalleDeTravail')->findAll();

        for ($i = 0; $i < count($salles); $i++) {
            $reservation = new reservations();

            $user = $faker->randomElement($users);
            $salle = $faker->randomElement($salles);
            $reservation->setUser($user);
            $reservation->setSalle($salle);

            $reservationDate = $faker->dateTimeBetween('-3 months', 'now');
            $reservationDateImmutable = \DateTimeImmutable::createFromMutable($reservationDate);

            $endTimeImmutable = $reservationDateImmutable->modify('+4 hours');

            $reservation->setStartTime($reservationDate);
            $reservation->setEndTime($endTimeImmutable);

            $manager->persist($reservation);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['reservations'];
    }
}
