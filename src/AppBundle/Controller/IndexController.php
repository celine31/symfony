<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Produit;
use AppBundle\Form\Type\ProduitType;

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

    /**
     * @Route("/produit/modifier/{id_produit}", defaults={"id_produit"=null}, name="modifier")
     */
    public function modifierAction(Request $request, $id_produit) {
        if ($id_produit && filter_var($id_produit, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            $produit = $this->getDoctrine()
                    ->getRepository('AppBundle:Produit')
                    ->find($id_produit);
            if (!$produit) {
                return $this->render('indispo.html.twig');
            }
        } elseif ($id_produit === null) {
            $produit = new Produit();
        } else {
            return $this->render('indispo.html.twig');
        }
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
// Sauvegarde de $produit en base.
// Redirection vers Accueil.
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('accueil'); //sinon le client se trouve avec editer dans l'url 
        }
        return $this->render('editer.html.twig', ['form' => $form->createView()]);
    }
}
