<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Books>
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    public function getBooks(){
        return $this->findAll();
    }

    public function findAvailableBooks(){

        return $this->createQueryBuilder('b')
            ->andWhere('b.reserved = :reserved')
            ->setParameter(':reserved', 0)
            ->getQuery()
            ->getResult();
    }

}
