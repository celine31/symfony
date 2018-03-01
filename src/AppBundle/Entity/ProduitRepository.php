<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class ProduitRepository extends EntityRepository {
   public function findJoin($id_produit) {
        return $this->getEntityManager()
                       ->createQuery("SELECT p,c FROM AppBundle:Produit p JOIN p.categorie c WHERE p.id_produit=:id_produit")
                       ->setParameter('id_produit',$id_produit)
                       ->getSingleResult();//peut renvoyer une exception si aucun produit (l'exception sera traité dans le controlleur)
    }
}
