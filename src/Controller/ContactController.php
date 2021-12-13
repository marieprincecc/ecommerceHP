<?php 

namespace App\Controller;

use App\Form\ContactType;
use App\MesServices\MailerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/customer/contact",name="customer_contact")
     */
    public function contact(Request $request,MailerService $mailerService)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $mailerService->sendContactMail($data);

            return $this->redirectToRoute("customer_contact");

        }

        return $this->render("customer/contact.html.twig",[
            'form' => $form->createView()
        ]);
    }
}