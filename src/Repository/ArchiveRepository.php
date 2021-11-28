<?php

namespace App\Repository;

use App\Entity\Archive;
use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Archive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Archive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Archive[]    findAll()
 * @method Archive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Archive::class);
    }

    /**
     * Recherche les archives en fonction du formulaire
     * @return void 
     */
    public function search($mots = null, $service = null)
    {
        $query = $this->createQueryBuilder('a');
        # $query->where('a.active = 1');
        if ($mots != null) {
            $query->andWhere('MATCH_AGAINST(a.code_archive, a.intitule_archive) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }
        if ($service  != null) {
            $query->leftJoin('a.service ', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $service);
        }
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of "Archives" per day
     * @return void 
     */
    public function countByDate()
    {
        // $query = $this->createQueryBuilder('a')
        //     ->select('SUBSTRING(date_archivage, 1, 10) as dateArchives, COUNT(a) as count')
        //     ->groupBy('dateArchive')
        // ;
        // return $query->getQuery()->getResult();
        $query = $this->getEntityManager()->createQuery("
            SELECT SUBSTRING(date_archivage, 1, 10) as dateArchives, COUNT(a) as count FROM App\Entity\Archive a GROUP BY dateArchives
        ");
        return $query->getResult();
    }

    /**
     * Returns Archives between 2 dates
     */
    public function selectInterval($from, $to, $ser = null)
    {
        // $query = $this->getEntityManager()->createQuery("
        //     SELECT a FROM App\Entity\Archives  a WHERE a.date_archivage > :from AND a.date_archivage < :to
        // ")
        //     ->setParameter(':from', $from)
        //     ->setParameter(':to', $to)
        // ;
        // return $query->getResult();
        $query = $this->createQueryBuilder('a')
            ->where('a.date_archivage > :from')
            ->andWhere('a.date_archivage < :to')
            ->setParameter(':from', $from)
            ->setParameter(':to', $to);
        if ($ser != null) {
            $query->leftJoin('a.service', 'c')
                ->andWhere('c.id = :ser')
                ->setParameter(':ser', $ser);
        }
        return $query->getQuery()->getResult();
    }

    /**
     * Returns all Archives per page
     * @return void 
     */
    public function getPaginatedArchives($page, $limit, $filters = null)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.id != 0');

        // On filtre les données
        if ($filters != null) {
            $query->andWhere('a.service IN(:serv)')
                ->setParameter(':serv ', array_values($filters));
        }

        $query->orderBy('a.date_archivage')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit);
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of Archives
     * @return void 
     */
    public function getTotalArchives($filters = null)
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->where('a.id != 0');
        // On filtre les données
        if ($filters != null) {
            $query->andWhere('a.service IN(:serv)')
                ->setParameter(':serv', array_values($filters));
        }

        return $query->getQuery()->getSingleScalarResult();
    }


    // /**
    //  * @return Archive[] Returns an array of Archive objects
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
    public function findOneBySomeField($value): ?Archive
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function CountAllArchives()
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->select('count(a.id) as value ');

        return  $queryBuilder->getQuery()->getResult();
    }
}
