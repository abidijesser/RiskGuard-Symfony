<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Form\Client1Type;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ClientresetpasswordController extends AbstractController
{

    #[Route('/email', name: 'app_email')]
    public function email(Request $request): Response
    {
        $errorMessage = $request->query->get('errorMessage', '');
        return $this->render('clientresetpassword/EmailOTP.html.twig', ['errorMessage' => $errorMessage]);
    }

    #[Route('/verifieremail', name: 'app_verifyemail')]
    public function verifyEmail(Request $request, ManagerRegistry $doctrine, SessionInterface $session): Response
    {
        $email = $request->request->get('email');
        $entityManager = $doctrine->getManager();
        $client= $entityManager->getRepository(Client::class)->findOneBy(['email' => $email]);

        if (!$client) {
            $errorMessage = "L'email saisi n'existe pas.";
            return $this->redirectToRoute('app_email' , ['errorMessage' => $errorMessage]);
        }

        $OTP=rand(1000, 9999);
        $session->set('OTP', $OTP);

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

    #[Route('/modificationmotdepasse', name: 'app_modifypassword')]
    public function modifierMotdepasse(): Response
    {
        return $this->render('clientresetpassword/modifypassword.html.twig');
    }


}
