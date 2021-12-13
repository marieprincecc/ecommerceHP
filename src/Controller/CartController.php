<?php 

namespace App\Controller;

use App\Repository\ProductRepository;
use App\MesServices\CartService\CartItem;
use App\MesServices\CartService\CartService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("panier/ajout/{id}",name="add_product")
     */
    public function add(int $id, ProductRepository $productRepository,CartService $cartService)
    {
        //JE VERIFIE SI LE PRODUIT EXISTE BEL ET BIEN DANS LA BDD
        $product = $productRepository->find($id);
        if(!$product)
        {
             $this->addFlash("danger","Le produit est introuvable.");
             return $this->redirectToRoute("customer_home");
        }

        $cartService->addProduct($id);

        $this->addFlash("success","Le produit a bien été ajouté.");
        
        return $this->redirectToRoute("customer_product_show",['id' => $id]);        

    }

        /**
        * @Route("panier/detail",name="cart_detail")
        */
        public function detail(CartService $cartService)
        {
        $detailCart = $cartService->getDetailedCartItems();

        return $this->render("customer/detail_cart.html.twig",[
        'detailCart' => $detailCart
        ]);
        } 
}