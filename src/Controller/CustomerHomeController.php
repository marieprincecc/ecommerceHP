<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerHomeController extends AbstractController
{
    #[Route('/', name: 'customer_home')]
    public function index(CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findall();
        return $this->render('customer/index.html.twig');
    }
}
