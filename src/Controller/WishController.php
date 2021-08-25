<?php

namespace App\Controller;

use App\Entity\Wish;
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
     * @Route("/wishlist", name="wishlist")
     */
    public function wishlist(WishRepository $wr): Response
    {
        $wishes = $wr->findBy(["isPublished" => true],["dateCreated" => "DESC"]);
        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes
        ]);
    }

    /**
     * @Route("/detail_wish/{id}", name="detail")
     */
    public function detail(): Response
    {
        return $this->render('wish/detail.html.twig');
    }

    /**
     * @Route("/addWish", name="add_wish")
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
}
