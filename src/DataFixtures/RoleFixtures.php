<?php 

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Users;
use App\Enum\UserRole;
use App\Entity\Abonnement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RoleFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $abonnements = [];
        for ($i = 0; $i < 5; $i++) {
            $abonnement = new Abonnement();
            $abonnement->setSubscriptionType($faker->randomElement(['Monthly', 'Annual']));
            $abonnement->setPrice($faker->numerify('23.99', '288'));
            $abonnement->setRenewal($faker->dateTimeBetween('now', '+1 years'));
            $manager->persist($abonnement);
            $abonnements[] = $abonnement;
        }
        
        for ( $i = 0; $i < 5; $i++ ) {
            $admin = new Users();
            $admin->setFirstName($faker->name($gender = null));
            $admin->setLastName($faker->name($gender = null));
            $admin->setAddress($faker->address());
            $admin->setPostalCode($faker->numberBetween(10000, 99999));
            $admin->setVille($faker->city());
            $admin->setTelephone($faker->numberBetween(10000000, 99999999));
            $admin->setBirthday($faker->dateTimeBetween('-50 years', '-18 years'));
            $admin->setEmail($faker->unique()->safeEmail());
            $admin->setPassword($this->passwordHasher->hashPassword($admin, '123456'));
            $admin->setRoles(UserRole::ADMIN);
            $manager->persist($admin);

            $admin->setAbonnement($abonnements[array_rand($abonnements)]);


        }
        $manager->flush();
    }
}
