<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\Admin;
use App\Entity\AbstractUtilisateur;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ClientresetpasswordController extends AbstractController
{

    #[Route('/email', name: 'app_email')]
    public function email(Request $request): Response
    {
        $errorMessage = null;
        return $this->render('clientresetpassword/EmailOTP.html.twig', ['errorMessage' => $errorMessage]);
    }

    #[Route('/verifieremail', name: 'app_verifyemail')]
    public function verifyEmail(Request $request, ManagerRegistry $doctrine, SessionInterface $session): Response
    {
        $email = $request->request->get('email');
        $entityManager = $doctrine->getManager();
        $user= $entityManager->getRepository(AbstractUtilisateur::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $errorMessage = "L'email entré n’est pas associé à aucun compte.";
            return $this->render('clientresetpassword/EmailOTP.html.twig' , ['errorMessage' => $errorMessage]);
        }

        $userId = $user->getId();

        $OTP=rand(1000, 9999);
        $session->set('OTP', $OTP);
        $session->set('userId', $userId);

        return $this->render('clientresetpassword/OTP.html.twig', [
            'email'=>$email,
            'OTP' => $OTP
        ]);
    }

    #[Route('/otp', name: 'app_otp')]
    public function otp(Request $request): Response
    {
        return $this->render('clientresetpassword/OTP.html.twig' );
    }

    #[Route('/verifierotp', name: 'app_verifyotp')]
    public function verifyOtp(Request $request, SessionInterface $session): Response
    {
        $otp1 = $request->request->get('otp1');
        $otp2 = $request->request->get('otp2');
        $otp3 = $request->request->get('otp3');
        $otp4 = $request->request->get('otp4');
        $userOtp = intval($otp1 . $otp2 . $otp3 . $otp4);

        $OTPFromSession = $session->get('OTP');

        if($userOtp !== $OTPFromSession){
            return $this -> redirectToRoute('app_email' );
        }

        return $this->render('clientresetpassword/modifypassword.html.twig' , ['userOtp'=>$userOtp]);
    }

    #[Route('/motdepasse', name: 'app_password')]
    public function Motdepasse(): Response
    {
        return $this->render('clientresetpassword/modifypassword.html.twig');
    }

    #[Route('/modifiermotdepasse', name: 'app_modifypassword')]
    public function modifierMotdepasse(Request $request, SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $userId = $session->get('userId');
        $entityManager = $doctrine->getManager();
        $user= $entityManager->getRepository(AbstractUtilisateur::class)->find($userId);
        $password = $request->request->get('password');
        $user->setMotDePasse($password);
        $entityManager->flush();

        return $this->redirectToRoute('app_signin');
    }


}
