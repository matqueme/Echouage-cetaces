<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Zone;


/**
 * @method Zone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Zone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Zone[]    findAll()
 * @method Zone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ZoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zone::class);
    }


    public function findAll() //Je redéfinis la médhode findAll afin d'avoir un résultat sous forme de tableau
    {
        $em = $this->createQueryBuilder('z');

        return $em->getQuery()->getArrayResult();
    }

    public function findById($zone_id)
    {
        $em = $this->createQueryBuilder('z');

        $em->andWhere('z.id = :zone_id')
            ->setParameter('zone_id', $zone_id);

        return $em->getQuery()->getArrayResult();
    }

    public function getZones()
    {
        $em = $this->createQueryBuilder('z')
            ->select('z.zone,z.id');


        return $em->getQuery()->getArrayResult();
    }
}
