<?php

namespace App\Repository;

use App\Entity\Facturation;
use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

/**
 * @method Facturation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facturation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facturation[]    findAll()
 * @method Facturation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturationRepository extends ServiceEntityRepository
{



    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facturation::class);
    }

    /**
     * @param VoitureRepository $voitureRepository
     * @throws \Doctrine\ORM\ORMException
     */
    public function  update(){
        $factures = $this->findAll();
        $datetime = new \DateTime('now');
        $voitureRepository = $this->_em->getRepository(Voiture::class);

        foreach ($factures as $f){
            $voiture = $voitureRepository->find($f->getIdv());
            if ($datetime < $f->getDateD()){
                $voiture->setDisponible(true)
                    ->setEtat("Opérationnel");
            }else{
                if ($datetime < $f->getDateF()){
                    $voiture->setDisponible(false)
                        ->setEtat("Opérationnel");
                }else{$voiture->setDisponible(true)
                    ->setEtat("Opérationnel");
                }
            }
            $this->_em->persist($voiture);
            $this->_em->persist($f);
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Facturation[] Returns an array of Facturation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Facturation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
