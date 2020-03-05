<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
     public function inscription(Request $requeteHttp, ObjectManager $manager)
     {
       // Création d'un utilisateur vide
       $utilisateur = new User();

       // Création du formulaire permettant de saisir un utilisateur
       $formulaireUtilisateur = $this->createForm(UserType::class, $utilisateur);

       // Récupération des données dans $utilisateur si elles ont été soumises
       $formulaireUtilisateur -> handleRequest($requeteHttp);

       // Traiter les données du formulaire s'il a été soumis
       if ($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid()){
         // Enregistrer les caractéristiques de l'utilisateur en BD
         $manager->persist($utilisateur);
         $manager->flush();

         // Rediriger l'utilisateur vers la page d'accueil
         return $this->redirectToRoute('accueil_pro_stages');
       }
       // Générer la vue représentant le formulaire
       $vueFormulaireUtilisateur = $formulaireUtilisateur -> createView();

       // Afficher la page d'ajout d'une entreprise
       return $this -> render('security/ajoutUtilisateur.html.twig',
       ['vueFormulaireUtilisateur' => $vueFormulaireUtilisateur]);
     }
}
