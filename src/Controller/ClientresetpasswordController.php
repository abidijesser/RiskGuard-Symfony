<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\Admin;
use App\Entity\AbstractUtilisateur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;

class ClientresetpasswordController extends AbstractController
{

    #[Route('/email', name: 'app_email')]
    public function email(Request $request): Response
    {
        return $this->render('clientresetpassword/EmailOTP.html.twig');
    }

    #[Route('/verifieremail', name: 'app_verifyemail')]
    public function verifyEmail(Request $request, ManagerRegistry $doctrine, SessionInterface $session, FlashyNotifier $flashy, MailerInterface $mailer): Response
    {
        $email = $request->request->get('email');
        $entityManager = $doctrine->getManager();
        $user= $entityManager->getRepository(AbstractUtilisateur::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $flashy->error('L\'email entré n’est pas associé à aucun compte.');
            return $this->redirectToRoute('app_email' );
        }

        $userId = $user->getId();
        $OTP=rand(1000, 9999);

        $emailOTP = (new Email())
            ->from(new Address('riskguard.suuport@gmail.com', 'Riskguard Support'))
            ->to($email)
            ->subject('Demande de réinitialisation de mot de passe')
            ->html('<p>Bonjour,</p><p>Vous avez demandé la réinitialisation de votre mot de passe. 
            Voici votre code de validation : <strong>' . $OTP . '</strong>.</p><p>Cordialement,<br>Riskguard Support</p>');
        $mailer->send($emailOTP);

        $session->set('userId', $userId);
        $session->set('OTP', $OTP);
        $session->set('email',$email);

        return $this->render('clientresetpassword/OTP.html.twig');
    }

    #[Route('/otp', name: 'app_otp')]
    public function otp(SessionInterface $session): Response
    {
        $email=$session->get('email');
        $OTP=$session->get('OTP');
        $userId=$session->get('userId');
        if(!$userId){
            return $this->redirectToRoute('app_signin');
        }
        return $this->render('clientresetpassword/OTP.html.twig', [ 'email'=>$email, 'OTP'=>$OTP ]);
    }

    #[Route('/verifierotp', name: 'app_verifyotp')]
    public function verifyOtp(Request $request, SessionInterface $session, FlashyNotifier $flashy): Response
    {
        $otp1 = $request->request->get('otp1');
        $otp2 = $request->request->get('otp2');
        $otp3 = $request->request->get('otp3');
        $otp4 = $request->request->get('otp4');
        $userOtp = intval($otp1 . $otp2 . $otp3 . $otp4);
        $session->set('userOTP', $userOtp);

        $OTPFromSession = $session->get('OTP');
        $email = $session->get('email');

        if($userOtp !== $OTPFromSession){
            $flashy->error('OTP est incorrecte', 'http://your-awesome-link.com');
            return $this -> render('clientresetpassword/OTP.html.twig', ['email' =>$email,  'OTP'=>$OTPFromSession] );
        }

        return $this->render('clientresetpassword/modifypassword.html.twig');
    }

    #[Route('/motdepasse', name: 'app_password')]
    public function Motdepasse(SessionInterface $session): Response
    {
        $userOTP=$session->get('userOTP');
        if(!$userOTP){
            return $this->redirectToRoute('app_signin');
        }
        return $this->render('clientresetpassword/modifypassword.html.twig');
    }

    #[Route('/modifiermotdepasse', name: 'app_modifypassword')]
    public function modifierMotdepasse(Request $request, SessionInterface $session, ManagerRegistry $doctrine, FlashyNotifier $flashy): Response
    {
        $userId = $session->get('userId');
        $entityManager = $doctrine->getManager();
        $user= $entityManager->getRepository(AbstractUtilisateur::class)->find($userId);
        $password = $request->request->get('password');
        if ($password === null) {
            $flashy->success('Invalid Mot de passe ', 'http://your-awesome-link.com');
            return $this->redirectToRoute('app_password');
        }
        $user->setMotDePasse($password);
        $session->invalidate();
        $entityManager->flush();

        $flashy->success('Votre mot de passe a été changé avec succès.');
        $session->set('flashy_message', 'Votre mot de passe a été changé avec succès.');
        return $this->redirectToRoute('app_signin');
    }


}
