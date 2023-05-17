<?php

namespace App\Controller;

use App\Entity\TUser;
use App\Form\RegistrationType;
use App\Repository\TUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * This method allows a user to register on the website
     * @return Response
     */
    #[Route('/inscription', name: 'app_registration')]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher, TUserRepository $TUserRepository): Response
    {
        //If the user is already logged in and tries to open the page -> get redirected to the home page
        if ($this->getUser()) {
            return $this->redirectToRoute('app_product');
        }

        //crating registration form
        $user = new TUser();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        //if submitted AND valid
        if($form->isSubmitted() && $form->isValid())
        {
            //set today's date
            $user->setUseCreatedDate(new \DateTime());

            //hash the password of the user
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            // set the user role
            $user->setRoles(['ROLES_USER']);

            //save in database
            $manager->persist($user);
            $manager->flush();

            //redirect to login page
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('security/registration.html.twig', [
            'controller_name' => 'SecurityController',
            'form' => $form->createView()
        ]);
    }

    /**
     * This method allows a user to login on the website
     * @return Response
     */
    #[Route('/connexion', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        //If the user is already logged in and tries to open the page -> he is redirected to the home page
        if ($this->getUser()) {
            return $this->redirectToRoute('app_product');
        }

        if ($request->isMethod('post')) {
        
            dump($request);
            die();
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error
        ]);
    }

    /**
     * This method allows a user to logout of the website
     * @return Response
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
