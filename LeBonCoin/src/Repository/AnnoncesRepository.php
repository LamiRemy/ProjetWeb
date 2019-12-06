<?php

namespace App\Repository;

use App\Entity\Annonces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Annonces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonces[]    findAll()
 * @method Annonces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnoncesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonces::class);
    }

    public function getByWord($word)
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :word')
            ->setParameter('word','%'.$word.'%')
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByMin($prixmin)
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix >= :prix')
            ->setParameter('prix',$prixmin)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByMax($prixmax)
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix <= :prix')
            ->setParameter('prix',$prixmax)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByCategory($category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.category = :cat')
            ->setParameter('cat',$category)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByWordandMin($word,$prixmin)
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :word')
            ->andWhere('a.prix >= :prix')
            ->setParameter('word','%'.$word.'%')
            ->setParameter('prix',$prixmin)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByWordandMax($word,$prixmax)
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :word')
            ->andWhere('a.prix <= :prix')
            ->setParameter('word','%'.$word.'%')
            ->setParameter('prix',$prixmax)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByWordandCat($word,$category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :word')
            ->andWhere('a.category = :cat')
            ->setParameter('word','%'.$word.'%')
            ->setParameter('cat',$category)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByMinAndMax($prixmin,$prixmax)
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix >= :prixmin')
            ->andWhere('a.prix <= :prixmax')
            ->setParameter('prixmin',$prixmin)
            ->setParameter('prixmax',$prixmax)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByMinAndCat($prixmin,$category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix >= :prixmin')
            ->andWhere('a.category = :cat')
            ->setParameter('prixmin',$prixmin)
            ->setParameter('cat',$category)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByMaxAndCat($prixmax,$category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix <= :prixmax')
            ->andWhere('a.category = :cat')
            ->setParameter('prixmax',$prixmax)
            ->setParameter('cat',$category)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getByNameMinandMax($word,$prixmin,$prixmax)
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :word')
            ->andWhere('a.prix >= :prixmin')
            ->andWhere('a.prix <= :prixmax')
            ->setParameter('word','%'.$word.'%')
            ->setParameter('prixmin',$prixmin)
            ->setParameter('prixmax',$prixmax)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getByNameMinandCat($word,$prixmin,$category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :word')
            ->andWhere('a.prix >= :prixmin')
            ->andWhere('a.category = :cat')
            ->setParameter('word','%'.$word.'%')
            ->setParameter('prixmin',$prixmin)
            ->setParameter('cat',$category)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByNameMaxandCat($word,$prixmax,$category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.name LIKE :word')
            ->andWhere('a.prix <= :prixmax')
            ->andWhere('a.category = :cat')
            ->setParameter('word','%'.$word.'%')
            ->setParameter('prixmax',$prixmax)
            ->setParameter('cat',$category)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByMinMaxandCat($prixmin,$prixmax,$category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix >= :prixmin')
            ->andWhere('a.prix <= :prixmax')
            ->andWhere('a.category = :cat')
            ->setParameter('prixmin',$prixmin)
            ->setParameter('prixmax',$prixmax)
            ->setParameter('cat',$category)
            ->getQuery()
            ->getResult()
            ;
    }
    public function getByAll($word,$prixmin,$prixmax,$category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.prix >= :prixmin')
            ->andWhere('a.name LIKE :word')
            ->andWhere('a.prix <= :prixmax')
            ->andWhere('a.category = :cat')
            ->setParameter('prixmin',$prixmin)
            ->setParameter('prixmax',$prixmax)
            ->setParameter('cat',$category)
            ->setParameter('word','%'.$word.'%')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return Annonces[] Returns an array of Annonces objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonces
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
