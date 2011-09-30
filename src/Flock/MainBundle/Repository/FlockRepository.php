<?php

namespace Flock\MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * FlockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FlockRepository extends EntityRepository
{
    /**
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getActiveFlocks($limit, $offset)
    {
        $query = $this->createQueryBuilder('f')
            ->select()
            ->where('f.startsAt > :currentDateTime')
            ->andWhere('f.deleted != TRUE')
            ->orderBy('f.startsAt','ASC')
            ->setParameter('currentDateTime', new \DateTime('now', new \DateTimeZone('Pacific/Honolulu')))
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();
        return $query->getResult();
    }

    public function getActiveFlocksCount()
    {
        $query = $this->getEntityManager()->createQuery('SELECT COUNT(f.id) FROM '.$this->getEntityName().' f WHERE f.startsAt > :currentDateTime AND f.deleted != TRUE');
        $query->setParameter('currentDateTime', new \DateTime('now', new \DateTimeZone('Pacific/Honolulu')));

        return $query->getSingleScalarResult();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) {
        return parent::findBy($this->fixCriteria($criteria), $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria) {
        return parent::findOneBy($this->fixCriteria($criteria));
    }

    public function find($id, $lockMode = \Doctrine\DBAL\LockMode::NONE, $lockVersion = null) {
        return $this->findOneBy(array(
            'id' => $id
        ));
    }

    private function fixCriteria(array $criteria) {
        //if asked to ignore delete return all data without delete
        if (isset($criteria['ignore_delete'])) {
            unset($criteria['ignore_delete']);

            return $criteria;
        }

        //Unless explicitly requested to return deleted items, we want to return non-deleted items by default
        if(!in_array('deleted', $criteria)) {
            $criteria['deleted'] = false;
        }

        return $criteria;
    }
}
