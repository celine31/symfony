<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Produit;

class IndexController extends Controller {

    /**
     * @Route("/produit/all1", name="accueil")
     */
    public function all1Action() {
        $tabproduit = $this->getDoctrine()->getRepository("AppBundle:Produit")->findBy([], ['nom' => 'ASC']);
        // replace this example code with whatever you need
        return $this->render('index.html.twig', ['tabproduit' => $tabproduit]);
    }

    /**
     * @Route("/produit/detail/{id_produit}", name="detail")
     */
    public function detailAction($id_produit) {
        if (filter_var($id_produit, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            $produit = $this->getDoctrine()->getRepository("AppBundle:Produit")->find($id_produit);
            if ($produit) {
                return $this->render('detail.html.twig', ['produit' => $produit]); //chemin à partir de twig
            } 
        }
        return $this->render('indispo.html.twig');
    }

}
