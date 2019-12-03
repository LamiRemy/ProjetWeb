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
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE User u SET u.firstname = :firstname WHERE u.id = :id';

        $stmt = $conn->prepare($sql);
        $stmt -> execute(['firstname' => $firstname, 'id' => $id]);
    ;}

    public function setLastname($id, $lastname)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE User u SET u.lastname = :lastname WHERE u.id = :id';

        $stmt = $conn->prepare($sql);
        $stmt -> execute(['lastname' => $lastname, 'id' => $id]);
        ;}

    public function setPseudo($id, $pseudo)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE User u SET u.pseudo = :pseudo WHERE u.id = :id';

        $stmt = $conn->prepare($sql);
        $stmt -> execute(['pseudo' => $pseudo, 'id' => $id]);
        ;}

    public function setMail($id, $mail)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE User u SET u.mail = :mail WHERE u.id = :id';

        $stmt = $conn->prepare($sql);
        $stmt -> execute(['mail' => $mail, 'id' => $id]);
        ;}

    public function setPhone($id, $phone)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE User u SET u.phone = :phone WHERE u.id = :id';

        $stmt = $conn->prepare($sql);
        $stmt -> execute(['phone' => $phone, 'id' => $id]);
        ;}

        public function checkPassword($id, $lastpass)
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.id = :id')
                ->andWhere('u.password = :lastpass')
                ->setParameter('id' , $id)
                ->setParameter('lastpass',$lastpass)
                ->getQuery()
                ->getResult()
        ;}

    public function setPass($id, $password)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'UPDATE User u SET u.password = :password WHERE u.id = :id';

        $stmt = $conn->prepare($sql);
        $stmt -> execute(['password' => $password, 'id' => $id]);
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
