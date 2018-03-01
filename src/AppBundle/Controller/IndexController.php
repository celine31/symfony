<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Produit;
use AppBundle\Form\Type\ProduitType;
use AppBundle\Util\Image;
use Doctrine\ORM\NoResultException;

class IndexController extends Controller {

    /**
     * @Route("/produit/all1", name="accueil")
     */
    public function all1Action() {
        $tabCategorie = $this->getDoctrine()->getRepository("AppBundle:Categorie")->findBy([], ['nom' => 'ASC']); //findBy avec tableau vide = findByAll
        // replace this example code with whatever you need
        return $this->render('index.html.twig', ['tabCategorie' => $tabCategorie]);
    }

    /**
     * @Route("/produit/detail/{id_produit}", name="detail")
     */
    public function detailAction($id_produit) {
        if (filter_var($id_produit, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            try {
                $produit = $this->getDoctrine()->getRepository("AppBundle:Produit")->findJoin($id_produit);
            } catch (NoResultException $e) {
                return $this->render('indispo.html.twig');
            }
            //$produit = $this->getDoctrine()->getRepository("AppBundle:Produit")->find($id_produit);
            return $this->render('detail.html.twig', ['produit' => $produit]); //chemin à partir de twig
        }
        return $this->render('indispo.html.twig');
    }

    /**
     * @Route("/produit/editer/{id_produit}", defaults={"id_produit"=null}, name="editer")
     */
    public function editerAction(Request $request, $id_produit) {
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
            if ($produit->getImage()) {
                $image = new Image($produit->getImage()->getPathName());
                $repImg = $this->container->getParameter('kernel.root_dir') . '\..\web\img';
                $image->copier(150, 150, "{$repImg}/prod_{$produit->getId_produit()}_v.jpg", Image::REDIM_COVER);
                $image->copier(300, 300, "{$repImg}/prod_{$produit->getId_produit()}_p.jpg");
            }
            return $this->redirectToRoute('accueil'); //sinon le client se trouve avec editer dans l'url 
        }
        return $this->render('editer.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/produit/supprimer/{id_produit}", name="supprimer")
     */
    public function supprimer($id_produit) {
        if (filter_var($id_produit, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
            $produit = $this->getDoctrine()->getRepository("AppBundle:Produit")->find($id_produit);
            if (!$produit) {
                return $this->redirectToRoute('accueil');
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
            $repImg = $this->container->getParameter('kernel.root_dir') . '\..\web\img';
            @unlink("{$repImg}/prod_{$produit->getId_produit()}_v.jpg");
            @unlink("{$repImg}/prod_{$produit->getId_produit()}_p.jpg");
            return $this->redirectToRoute('accueil');
        }
    }

}
