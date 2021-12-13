<?php 

namespace App\Controller;

use App\Repository\ProductRepository;
use App\MesServices\CartService\CartItem;
use App\MesServices\CartService\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("panier/ajout/{id}",name="add_product")
     */
    public function add(int $id, ProductRepository $productRepository,CartService $cartService,Request $request)
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


        $returnToCart = $request->query->get('returnToCart');

        if(isset($returnToCart))
        {
            return $this->redirectToRoute("cart_detail");  
        }
        
        return $this->redirectToRoute("customer_product_show",['id' => $id]);        
    }

    /**
     * @Route("panier/detail",name="cart_detail")
     */
    public function detail(CartService $cartService)
    {
        $detailCart = $cartService->getDetailedCartItems();

        $total = $cartService->getTotal();

        return $this->render("customer/detail_cart.html.twig",[
            'detailCart' => $detailCart,
            'totalCart' => $total
        ]);
    }

     /**
     * @Route("panier/supprimer/{id}",name="remove_item_cart")
     */
    public function removeItem(int $id,ProductRepository $productRepository,CartService $cartService)
    {
        $product = $productRepository->find($id);

        if(!$product)
        {
             $this->addFlash("danger","Le produit est introuvable.");
             return $this->redirectToRoute("cart_detail");
        }

        $cartService->removeItem($id);

        $this->addFlash("success","Le produit a bien été supprimé du panier.");
        return $this->redirectToRoute("cart_detail");
    }

    /**
     * @Route("panier/decrementer/{id}",name="decrement_product_cart")
     */
    public function decrementProduct(int $id,ProductRepository $productRepository,CartService $cartService)
    {
        $product = $productRepository->find($id);

        if(!$product)
        {
             $this->addFlash("danger","Le produit est introuvable.");
             return $this->redirectToRoute("cart_detail");
        }

        $cartService->decrementProduct($id);

        $this->addFlash("success","La quantité du produit a bien été décrémentée.");
        return $this->redirectToRoute("cart_detail");
    }
}