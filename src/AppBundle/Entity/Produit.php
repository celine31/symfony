<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Table(name="produit")
* @ORM\Entity
*/

class Produit {
    

        /**
    * @ORM\Column(name="id_produit",type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id_produit;
    
    /**
    * @ORM\Column(name="nom",type="string",length=50,nullable=true)
    */
    private $nom;
    
    /**
    * @ORM\Column(name="ref",type="string",length=10,nullable=true)
    */
    private $ref;
    
    /**
    * @ORM\Column(name="prix",type="decimal",precision=8,scale=2,nullable=true)
    */
    private $prix;
    
    function getId_produit() {
        return $this->id_produit;
    }

    function getNom() {
        return $this->nom;
    }

    function getRef() {
        return $this->ref;
    }

    function getPrix() {
        return $this->prix;
    }

    function setId_produit($id_produit) {
        $this->id_produit = $id_produit;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setRef($ref) {
        $this->ref = $ref;
    }

    function setPrix($prix) {
        $this->prix = $prix;
    }
}
