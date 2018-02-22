<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Produit;

class ProduitController extends Controller {

    /**
     * @Route("/produit1/")
     */
    public function produit1Action() {
        $produit = new Produit();
        $produit->setNom("Ray-ban");
        $produit->setRef("RB");
        $produit->setPrix(229.99);
        //créer un nouveau produit, l'ajouter en base et afficher son id auto incrémenter  

        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        return new Response("nouveau produit :{$produit->getId_produit()}");
    }

    /**
     * @Route("/produit2/{id_produit}")
     */
    public function produit2Action($id_produit) {
        if (filter_var($id_produit, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]])) {
            $produit = $this->getDoctrine()->getManager()->getRepository("AppBundle:Produit")->find($id_produit);
            if ($produit) {
                return $this->render('produit2.html.twig', ['produit'=>$produit]); //chemin à partir de twig
            }
        }
     throw $this->createNotFoundException("Produit indisponible");
    }

}
