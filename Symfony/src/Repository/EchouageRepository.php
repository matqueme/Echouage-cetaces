<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr;
use App\Entity\Echouage;


/**
 * @method Echouage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Echouage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Echouage[]    findAll()
 * @method Echouage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EchouageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Echouage::class);
    }


    public function findByParameters($date_start, $date_end, $espece): ?array
    {
        $em = $this->createQueryBuilder('e');

        $em->join('e.zone', 'z')
            ->select('e.date,z.zone,z.id AS zone_id,sum(e.nombre) AS nombre')
            ->groupBy('e.date,z.zone');

        if ($date_start) {
            $em->andWhere('e.date >= :date_start')
                ->setParameter('date_start', $date_start);
        }

        if ($date_end) {
            $em->andWhere('e.date <= :date_end')
                ->setParameter('date_end', $date_end);
        }

        if ($espece) {
            $em->andWhere('e.espece = :espece')
                ->setParameter('espece', $espece);
        }

        $em->orderBy('zone_id,e.date,z.id');

        return $em->getQuery()->getArrayResult();
    }


    public function getEchouages($zone_id, $espece_id)
    {
        $em = $this->createQueryBuilder('e');

        if ($zone_id) { //Si une zone précise est sélectionnée
            $em->andWhere('e.zone = :zone_id')
                ->setParameter('zone_id', $zone_id);
        }

        //Sélection de l'espèce choisie
        $em->andWhere('e.espece = :espece_id')
            ->setParameter('espece_id', $espece_id);

        $em->orderBy('e.date', 'ASC');

        return $em->getQuery()->getArrayResult();
    }

    public function getDates($zone_id = 0)
    {
        $em = $this->createQueryBuilder('e')
            ->select('e.date');

        if ($zone_id) { //Si une zone précise est sélectionnée
            $em->andWhere('e.zone = :zone_id')
                ->setParameter('zone_id', $zone_id);
        }

        $em->orderBy('e.date', 'ASC')
            ->groupBy('e.date');

        return $em->getQuery()->getResult();
    }
}
