<?php

namespace App\Controller;

use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function index(MailerInterface $mailer, FlashyNotifier $flashy): Response
    {
        $email = (new Email())
            ->from(new Address('riskguard.suuport@gmail.com', 'Riskguard Support'))
            ->to('jasserabidi00@gmail.com')
            ->subject('Demande de réinitialisation de mot de passe')
            ->text('Vous avez demandé la réinitialisation de votre mot de passe. 
            Voici votre code de validation (OTP) : 123456. ')
            ->html('<p>Bonjour,</p><p>Vous avez demandé la réinitialisation de votre mot de passe. 
                Voici votre code de validation (OTP) : <strong>123456</strong>.</p><p>Cordialement,<br>Riskguard Support</p>');

        $mailer->send($email);
        $flashy->success('OTP est incorrecte', 'http://your-awesome-link.com');

        return $this->render('mailer/index.html.twig');
    }
}
