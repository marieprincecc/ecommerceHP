<?php 

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\User;
use App\Entity\CommandShop;
use Stripe\Checkout\Session;
use App\Entity\CommandListProduct;
use App\MesServices\MailerService;
use App\Entity\CommandDeliveryAddress;
use App\Entity\ContentListCommandShop;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\CartService\CartService;
use Symfony\Component\Routing\Annotation\Route;
use App\MesServices\CartService\CartRealProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/create-checkout-session",name="create_checkout_session")
     */
    public function createSession(CartService $cartService)
    {
        Stripe::setApiKey('sk_test_51K6F4nLYDIrRRiDkE8rmyvOFvKQAiCoyZ1MLwZcxPySnvVtdZiJ9f7aM74peGzULtBLjR4oYIbqfOq1gC70gz9oe00IuyD7tSg');

        $domain = 'https://localhost:8000';

        /** @var User $user */
        $user = $this->getUser();

        /** @var CartRealProduct[] $detailCart */
        $detailCart = $cartService->getDetailedCartItems();

        $productForStripe = [];

        foreach($detailCart as $item)
        {
            $productForStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getProduct()->getPrice(),
                    'product_data' => [
                        'name' => $item->getProduct()->getName(),
                        'images' => [
                            $domain . $item->getProduct()->getImagePath()
                        ]
                    ]
                ],
                'quantity' => $item->getQty()
            ];
        }

        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'payment_method_types' => [
                'card',
            ],
            'line_items' => [
                $productForStripe
            ],
            'mode' => 'payment',
              'success_url' => $domain . '/paiementreussi',
              'cancel_url' => $domain . '/paiementechoue',
          ]);

          return $this->redirect($checkout_session->url);
    }

    /**
     * @Route("/paiementreussi", name="payment_success")
     */
    public function paymentSuccess(CartService $cartService,EntityManagerInterface $em,
                                MailerService $mailerService)
    {
        //Je recupere le user
        /** @var User $user */
        $user = $this->getUser();

        //Je dois creer  une commande
        $commandShop = new CommandShop();
        $commandShop->setUser($user);
        $commandShop->setTotal($cartService->getTotal());
        $em->persist($commandShop);


        //Je dois creer une adresse lié a la commande
        $addressUser = $user->getAddress();

        $commandDeliveryAddress = new CommandDeliveryAddress();
        $commandDeliveryAddress->setCommandShop($commandShop);
        $commandDeliveryAddress->setCountry($addressUser->getCountry());
        $commandDeliveryAddress->setCity($addressUser->getCity());
        $commandDeliveryAddress->setPostalCode($addressUser->getPostalCode());
        $commandDeliveryAddress->setStreet($addressUser->getStreet());
        $commandDeliveryAddress->setCommentary($addressUser->getCommentary());

        $em->persist($commandDeliveryAddress);

        //Je dois creer une liste de produits lié a la commande
        $listProduct = new CommandListProduct();
        $listProduct->setCommandShop($commandShop);

        $em->persist($listProduct);


        //Je dois remplir cette liste
        /** @var CartRealProduct[] $detailCart */
        $detailCart = $cartService->getDetailedCartItems();

        foreach($detailCart as $item)
        {
            $contentList = new ContentListCommandShop();
            $contentList->setProduct($item->getProduct());
            $contentList->setListProduct($listProduct);
            $contentList->setQuantity($item->getQty());
            $em->persist($contentList);
        }

        $em->flush();

     

        //Envoyer un mail au client avec le recap de la commande
        $mailerService->sendCommandMail($user,$commandShop,$commandDeliveryAddress,$detailCart);


        $this->addFlash("success","Votre commande a bien été pris en compte.");
        $cartService->emptyCart();
        return $this->redirectToRoute("cart_detail");
    }

     /**
     * @Route("/paiementechoue", name="payment_cancel")
     */
    public function paymentCancel()
    {
        $this->addFlash("info","Votre commande n'a pu aboutir. Vous pouvez essayer avec une manière de paiement.");
        return $this->redirectToRoute("cart_detail");
    }
}