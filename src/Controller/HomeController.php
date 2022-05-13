<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homePaage(ProductRepository $repo): Response
    {
        $products = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products
        ]);
    }
}
