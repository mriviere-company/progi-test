<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BidController extends AbstractController
{
    #[Route('/', name: 'bid_calculation')]
    public function index(): Response
    {
        return $this->render('bid_calculation/index.html.twig');
    }
}
