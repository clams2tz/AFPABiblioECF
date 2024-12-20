<?php

namespace App\Repository;

use App\Entity\Reservations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservations>
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    public function save(Reservations $reservation, bool $flush = false): void
    {
        $this->getEntityManager()->persist($reservation);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservations $reservation, bool $flush = false): void
    {
        $this->getEntityManager()->remove($reservation);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
   /**
    * @return Reservations[] 
    */
   public function findByDates(\DateTimeInterface $start, \DateTimeInterface $end)
   {
       return $this->createQueryBuilder('r')
           ->andWhere('r.startTime >= :start')
           ->andWhere('r.endTime <= :end')
           ->setParameter('start', $start)
           ->setParameter('end', $end)
           ->orderBy('r.startTime', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Reservations
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
