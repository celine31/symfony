<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Produit;



class ProduitController extends Controller
{
    /**
     * @Route("/produit1/")
     */
    public function produit1Action()
    {
       $produit=new Produit();
       $produit->setNom("Ray-ban");
       $produit->setRef("RB");
       $produit->setPrix(229.99);
      //créer un nouveau produit, l'ajouter en base et afficher son id auto incrémenter  
    
       $em=$this->getDoctrine()->getManager();
       $em->persist($produit);
       $em->flush();
       return new Response("nouveau produit :{$produit->getId_produit()}");
    }    
}
