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
    
    public function getRetardBooks(){
        
        return $this->createQueryBuilder('b')
        ->join('b.loans', 'l')
        ->andWhere('l.dueDate < :today')
        ->andWhere('l.returned = false')
        ->setParameter('today', new \DateTime())
        ->getQuery()
        ->getResult();
    }
    
    public function getNonRestituatedBooks()
    {
        return $this->createQueryBuilder('b')
            ->join('b.loans', 'l')
            ->andWhere('b.reserved = true') 
            ->andWhere('l.returned = false') 
            ->andWhere('l.dueDate < :now') 
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }

}
