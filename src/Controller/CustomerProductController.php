<?php 

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerProductController extends AbstractController
{
    /**
     * @Route("customer/product/{id}", name="customer_product_show")
     */
    public function show(int $id,ProductRepository $productRepository)
    {
        $product = $productRepository->find($id);

        if(!$product)
        {
            $this->addFlash("danger","Le produit est introuvable.");
            return $this->redirectToRoute("customer_home");
        }

        return $this->render("customer/product_show.html.twig",[
            'product' => $product
        ]);
    }

    /**
     * @Route("customer/category/{id}", name="customer_category_show")
     */
    public function productsByCategory(int $id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        if(!$category)
        {
            return $this->redirectToRoute("customer_home");
        }

        return $this->render("customer/category_show.html.twig",[
            'category' => $category
        ]);
    }
}