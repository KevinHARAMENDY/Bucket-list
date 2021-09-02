<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {
        return $this->render('main/accueil.html.twig');
    }

    /**
     * @Route("/co/wishlist", name="wishlist")
     */
    public function wishlist(WishRepository $wr): Response
    {
        $wishes = $wr->findBy(["isPublished" => true],["dateCreated" => "DESC"]);
        return $this->render('main/list.html.twig', [
            "wishes" => $wishes
        ]);
    }

    /**
     * @Route("/co/detail_wish/{id}", name="detail")
     */
    public function detail(Wish $w): Response
    {
       return $this->render('main/detail.html.twig',[
            "wish" => $w
        ]);
    }
}
