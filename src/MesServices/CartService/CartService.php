<?php 

namespace App\MesServices\CartService;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $session;

    private $productRepository;

    public function __construct(SessionInterface $session,ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function getCart()
    {
        return $this->session->get('cart',[]);
    }

    public function saveCart(array $cart)
    {
        $this->session->set('cart',$cart);
    }

    public function addProduct(int $id)
    {
        //JE VAIS CHERCHER MON PANIER DANS LA SESSION
        // SI IL EXISTE , UN PANIER VA ETRE CREER AUTOMATIQUEMENT
        $cart = $this->getCart();

        //JE DETERMINE LA QUANTITE
        $qty = 1;

        //JE VERIFIE SI LE PRODUIT EST DEJA DANS MON PANIER
        //DANS CE CAS, JE NE FAIS QUE AUGMENTER LA QUANTITE
        foreach($cart as $item)
        {
            if($item->getId() === $id)
            {
                $qtyActuel = $item->getQty();

                $item->setQty($qtyActuel + $qty);

                $this->saveCart($cart);
                return;
            }
        }

        //SI LE PRODUIT N EST PAS ENCORE DANS LE PANIER
        //JE CREE UNE INSTANCE DE LA CLASSE CARTITEM 
        //PUIS JE L AJOUTE DANS MON PANIER
        $cartItem = new CartItem();
        $cartItem->setId($id);
        $cartItem->setQty($qty);

        $cart[] = $cartItem;

        //JE SAUVEGARDE LA NOUVELLE VALEUR DE MON PANIER DANS LA SESSION
        $this->saveCart($cart);
        return;
    }

    public function getDetailedCartItems()
    {
        $detailCart = [];

        $cart = $this->getCart();

        foreach($cart as $item)
        {
            $product = $this->productRepository->find($item->getId());

            if(!$product)
            {
                continue;
            }

            $cartRealProduct = new CartRealProduct();
            $cartRealProduct->setProduct($product);
            $cartRealProduct->setQty($item->getQty());

            $detailCart[] = $cartRealProduct;
        }

        return $detailCart;
    }

    public function getTotal()
    {
        $total = 0;

        $cart = $this->getCart();

        foreach($cart as $item)
        {
            $product = $this->productRepository->find($item->getId());

            if(!$product)
            {
                continue;
            }

            $total += $product->getPrice() * $item->getQty();
        }

        return $total;
    }

    public function removeItem(int $id)
    {
        $cart = $this->getCart();

        foreach($cart as $key => $item)
        {
            if($item->getId() === $id)
            {
                unset($cart[$key]);
                $this->saveCart($cart);
            }
        }
    }
    
    public function decrementProduct(int $id)
    {
        $cart = $this->getCart();

        foreach($cart as $key => $item)
        {
            if($item->getId() === $id)
            {
                $qty = $item->getQty();

                if($qty === 1)
                {
                    unset($cart[$key]);
                    $this->saveCart($cart);
                    return;
                }
                else 
                {
                    $item->setQty($qty - 1);
                    $this->saveCart($cart);
                    return;
                }
            }
        }
    }

    public function emptyCart()
    {
        $this->saveCart([]);
    }
}