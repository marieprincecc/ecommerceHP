<?php 

namespace App\MesServices;

use App\Entity\CommandDeliveryAddress;
use App\Entity\CommandListProduct;
use DateTime;
use App\Entity\User;
use App\Entity\CommandShop;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendContactMail(array $data)
    {
        $email = (new TemplatedEmail())
                ->from('contact@symfonyecommerce.com')
                ->to('contact@symfonyecommerce.com')
                ->subject($data['subject'])

                // path of the Twig template to render
                ->htmlTemplate('emails/email_contact.html.twig')

                // pass variables (name => value) to the template
                ->context([
                    'subject' => $data['subject'],
                    'content' => $data['content'],
                    'fullname' => $data['fullname'],
                    'email_customer' => $data['email'],
                    'telephone' => $data['telephone']
                ])
            ;

        $this->mailer->send($email);
    }

    public function sendCommandMail(User $user,CommandShop $command,CommandDeliveryAddress $commandDeliveryAddress, array $commandListProduct)
    {
        $email = (new TemplatedEmail())
        ->from('support@symfonyecommerce.com')
        ->to($user->getEmail())
        ->subject('SymEcommerce | Commande :' . $command->getId())

        // path of the Twig template to render
        ->htmlTemplate('emails/email_command_customer.html.twig')

        
        // pass variables (name => value) to the template
        ->context([
            'contents' => $commandListProduct,
            'user' => $user,
            'address' => $commandDeliveryAddress,
            'total' => $command->getTotal(),
            'id' => $command->getId(),
            'createdAt' => $command->getCreatedAt()
        ])
    ;

$this->mailer->send($email);
    }
}