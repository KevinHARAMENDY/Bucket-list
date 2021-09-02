<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Wish;
use App\Form\WishAddFastType;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/admin", name="all_wishlist")
     */
    public function all_wishlist(WishRepository $wr, Request $req, EntityManagerInterface $em): Response
    {
        $wishes = $wr->findBy([],["dateCreated" => "DESC"]);

        $wish = new Wish();
        $form = $this->createForm(WishAddFastType::class,$wish);
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $wish->setAuteur("Lambdadmin");
            $wish->setDescription("Ajout rapide d'un admin");
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $em->persist($wish);
            $em->flush();
            return $this->redirectToRoute("wishlist");
        }

        return $this->render('wish/listAll.html.twig', [
            "wishes" => $wishes,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/ajouter", name="add_wish")
     */
    public function add_wish(Request $req, EntityManagerInterface $em): Response
    {
        $wish = new Wish();
        $form = $this->createForm(WishType::class,$wish);
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $em->persist($wish);
            $em->flush();
            return $this->redirectToRoute("wishlist");
        } else {
            return $this->render('wish/add.html.twig',[
                "form" => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/modifier/{id}", name="edit_wish")
     */
    public function edit_wish(Wish $w, Request $req, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(WishType::class,$w);
        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $em->flush();
            return $this->redirectToRoute("wishlist");
        } else {
            return $this->render('wish/edit.html.twig',[
                "form" => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/delete/{id}", name="delete_wish")
     */
    public function delete_wish(Wish $w, EntityManagerInterface $em): Response
    {
        $em->remove($w);
        $em->flush();
        return $this->redirectToRoute("wishlist");
    }
}
