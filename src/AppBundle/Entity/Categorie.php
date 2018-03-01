<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @ORM\Table(name="categorie")
* @ORM\Entity
*/
class Categorie {
   
    /**
    *@ORM\Column(name="id_categorie",type="integer")
    *@ORM\Id
    *@ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id_categorie;
   
    /**
    *@ORM\Column(name="nom",type="string",length=50,nullable=true)
    *@Assert\Type(type="string")
    *@Assert\Length(max="50",maxMessage="nom : au plus 50 car.")
    *@Assert\NotBlank(message="Le nom est obligatoire.")
     */
    private $nom;
  
     /**
     * @ORM\OneToMany(targetEntity="Produit",mappedBy="categorie")
     * @ORM\OrderBy({"nom"="ASC"})
     */
    private $tabProduit;

    public function __construct() {
        $this->tabProduit = new ArrayCollection();
    }

    function getNom() {
        return $this->nom;
    }

    function getTabProduit() {
        return $this->tabProduit;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setTabProduit($tabProduit) {
        $this->tabProduit = $tabProduit;
    }
     function getId_categorie() {
        return $this->id_categorie;
    }

    function setId_categorie($id_categorie) {
        $this->id_categorie = $id_categorie;
    }
}
