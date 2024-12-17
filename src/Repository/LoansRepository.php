<?php

namespace App\Repository;

use App\Entity\Books;
use App\Entity\Loans;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Loans>
 */
class LoansRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loans::class);
    }

    public function findLastLoanByUser(int $userId, int $bookId): ?Loans
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.user_id = :userId')
            ->andWhere('l.book_id = :bookId')
            ->setParameter(':userId', $userId)
            ->setParameter(':bookId', $bookId)
            ->orderBy('l.dueDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findRetardLoans()
    {
            return $this->createQueryBuilder('l')
                ->andWhere('l.dueDate < :today')
                ->setParameter('today', new \DateTime())
                ->getQuery()
                ->getResult();
    }

    public function findLatestLoanByBook(Books $book): ?Loans
{
    return $this->createQueryBuilder('l')
        ->andWhere('l.book = :book')
        ->andWhere('l.returned = false')
        ->orderBy('l.dueDate', 'DESC')
        ->setParameter('book', $book)
        ->setMaxResults(1) 
        ->getQuery()
        ->getOneOrNullResult();
}

    //    /**
    //     * @return Loans[] Returns an array of Loans objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Loans
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
