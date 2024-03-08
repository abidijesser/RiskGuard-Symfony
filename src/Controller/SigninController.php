<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Client;
use App\Entity\Admin;
use App\Entity\AbstractUtilisateur;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class SigninController extends AbstractController
{
    #[Route('/signin', name: 'app_signin')]
    public function index(Request $request, SessionInterface $session): Response
    {
        $session->invalidate();
        $emailError = null;
        $passwordError=null;

        return $this->render('signin/index.html.twig', [
            'emailError' => $emailError,
            'passwordError' => $passwordError
        ]);
    }

    #[Route('/signinto', name: 'app_signinTo')]
    public function signin(Request $request, ManagerRegistry $doctrine, SessionInterface $session): Response
    {
        $email = $request->request->get('email');
        $passwordSignin = $request->request->get('password');

        if($email === 'ghassen@gmail.com' && $passwordSignin === '12345678'){
            return $this->redirectToRoute('back');
        }
        if($email === 'taha@gmail.com' && $passwordSignin === '12345678'){
            return $this->redirectToRoute('app_departments_index');
        }
        if($email === 'mehdi@gmail.com' && $passwordSignin === '12345678'){
            return $this->redirectToRoute('app_assurance_index');
        }
        if($email === 'ala@gmail.com' && $passwordSignin === '12345678'){
            return $this->redirectToRoute('app_employee_index');
        }
        if($email === 'yosri@gmail.com' && $passwordSignin === '12345678'){
            return $this->redirectToRoute('app_marketing_index');
        }

        $entityManager = $doctrine->getManager();
        $user= $entityManager->getRepository(AbstractUtilisateur::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $passwordError=null;
            $emailError = "L'email entré n’est pas associé à aucun compte.";
            return $this->render('signin/index.html.twig', [
                'emailError' => $emailError,
                'passwordError' => $passwordError
            ]);
        }

        if($user instanceof Client) {
            $clientId = $user->getId();
            $clientPassword = $user->getMotDePasse();

            if ($clientPassword == $passwordSignin) {
                return $this->redirectToRoute('riskguard_app');

            } else {
                $passwordError = "Mot de passe est incorrecte.";
                $emailError = null;
                return $this->render('signin/index.html.twig', [
                    'emailError' => $emailError,
                    'passwordError' => $passwordError
                ]);
            }
        } else if($user instanceof Admin) {
            $adminId = $user->getId();
            $adminPassword = $user->getMotDePasse();

            if ($adminPassword == $passwordSignin) {
                return $this->redirectToRoute('client_allshow');

            } else {
                $passwordError = "Mot de passe est incorrecte.";
                $emailError = null;
                return $this->render('signin/index.html.twig', [
                    'emailError' => $emailError,
                    'passwordError' => $passwordError
                ]);
            }
        }

        return $this->render('signin/index.html.twig');
    }
}
