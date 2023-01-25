<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Espece;


/**
 * @method Espece|null find($id, $lockMode = null, $lockVersion = null)
 * @method Espece|null findOneBy(array $criteria, array $orderBy = null)
 * @method Espece[]    findAll()
 * @method Espece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspeceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Espece::class);
    }


    public function getEspeceName($espece_id)
    {
        $em = $this->createQueryBuilder('e')
        ->select('e.espece')
        ->andWhere('e.id = :espece_id')
        ->setParameter('espece_id', $espece_id);


        return $em->getQuery()->getOneOrNullResult();
    }

    public function getEspeces()
    {
        $em = $this->createQueryBuilder('e')
        ->select('e.espece,e.id');

        return $em->getQuery()->getArrayResult();
    }
    
}
