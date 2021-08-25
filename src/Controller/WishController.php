<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wishlist", name="wishlist")
     */
    public function wishlist(WishRepository $wr): Response
    {
        $wishes = $wr->findAll();
        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes
        ]);
    }

    /**
     * @Route("/detail_wish", name="detail")
     */
    public function detail($id, WishRepository $wr): Response
    {
        return $this->render('wish/detail.html.twig');
    }
}
