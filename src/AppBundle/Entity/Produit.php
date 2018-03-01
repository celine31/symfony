<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Table(name="produit")
* @ORM\Entity(repositoryClass="AppBundle\Entity\ProduitRepository")
* @UniqueEntity("ref", message="La ref doit être unique.")
*/

class Produit {
    /**
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $image;
    
    /**
    *@ORM\Column(name="id_produit",type="integer")
    *@ORM\Id
    *@ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id_produit;
    
     /**
    *@ORM\Column(name="id_categorie",type="integer")
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
    *@ORM\Column(name="ref",type="string",length=10,nullable=true)
    *@Assert\Type(type="string")
    *@Assert\Length(min="3",max="10",minMessage="Ref : au moins 3 car.",maxMessage="Ref : au plus 10 car.")
    *@Assert\NotBlank(message="La ref est obligatoire.")
    */
    private $ref;
    
    /**
    *@ORM\Column(name="prix",type="decimal",precision=8,scale=2,nullable=true)
    *@Assert\Type(type="numeric",message="Le prix doit être un nombre.")
    *@Assert\GreaterThan(value="0",message="Le prix doit être strictement positif.")
    */
    private $prix;
          
    /**
    * @ORM\ManyToOne(targetEntity="Categorie",inversedBy="tabProduit")
    * @ORM\JoinColumn(name="id_categorie",referencedColumnName="id_categorie")
    */
    private $categorie;
    
        
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
    
    function getImage() {
        return $this->image;
    }
    
    function setImage($image) {
        $this->image = $image;
    }
    function getCategorie() {
        return $this->categorie;
    }

    function setCategorie($categorie) {
        $this->categorie = $categorie;
    }
   function getId_categorie() {
        return $this->id_categorie;
    }

    function setId_categorie($id_categorie) {
        $this->id_categorie = $id_categorie;
    }
}
