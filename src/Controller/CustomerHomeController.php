<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerHomeController extends AbstractController
{
    #[Route('/', name: 'customer_home')]
    public function index(): Response
    {
        return $this->render('customer/index.html.twig');
    }
}
