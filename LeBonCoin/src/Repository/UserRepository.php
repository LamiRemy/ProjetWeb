<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function connexion($identifiant, $pass)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.pseudo = :pseudo')
            ->andWhere('u.password = :pass')
            ->setParameter('pseudo' , $identifiant)
            ->setParameter('pass',$pass)
            ->getQuery()
            ->getResult()
    ;}

    public function inscription($identifiant)
    {
        return $this -> createQueryBuilder('u')
            ->andWhere('u.pseudo = :pseudo')
            ->setParameter('pseudo' , $identifiant)
            ->getQuery()
            ->getResult()
    ;}

    public function getMail($pseudo)
    {
        return $this -> createQueryBuilder('u')
            ->select('u.mail')
            ->andWhere('u.pseudo = :pseudo')
            ->setParameter('pseudo',$pseudo)
            ->getQuery()
            ->getSingleScalarResult()
    ;}

    public function getFirstname($pseudo)
    {
        return $this -> createQueryBuilder('u')
            ->select('u.firstname')
            ->andWhere('u.pseudo = :pseudo')
            ->setParameter('pseudo',$pseudo)
            ->getQuery()
            ->getSingleScalarResult()
            ;}

    public function getLastname($pseudo)
{
    return $this -> createQueryBuilder('u')
        ->select('u.lastname')
        ->andWhere('u.pseudo = :pseudo')
        ->setParameter('pseudo',$pseudo)
        ->getQuery()
        ->getSingleScalarResult()
        ;}

    public function getPhone($pseudo)
    {
        return $this -> createQueryBuilder('u')
            ->select('u.phone')
            ->andWhere('u.pseudo = :pseudo')
            ->setParameter('pseudo',$pseudo)
            ->getQuery()
            ->getSingleScalarResult()
            ;}

    public function getId($pseudo)
    {
        return $this -> createQueryBuilder('u')
            ->select('u.id')
            ->andWhere('u.pseudo = :pseudo')
            ->setParameter('pseudo',$pseudo)
            ->getQuery()
            ->getSingleScalarResult()
            ;}

    public function setFirstname($id, $firstname)
    {
        $x = $this -> createQueryBuilder('u')
            ->update('u.firstname',$firstname)
            ->where('u.id = :id')
            ->setParameter('id',$id)
            ->getQuery();
        //dd($x);
        $x->execute();
    ;}
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
