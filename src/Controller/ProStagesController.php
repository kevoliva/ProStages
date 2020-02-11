<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStagesController extends AbstractController
{
  /**
  * @Route("/", name="accueil_pro_stages")
  */
  public function index()
  {
    // Récupérer le repository de l'entité Stage
    $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
    // Récupérer les stages enregistrés en BD
    $stages = $repositoryStage->getStageEntrepriseEtFormation();
    // Envoyer les stages récupérés à la vue chargée de les afficher
    return $this->render('pro_stages/index.html.twig', ['stages'=>$stages]);
  }

  /**
  * @Route("/entreprises", name="entreprises_prostages")
  */
  public function entreprises()
  {

    // Récupérer le repository de l'entité Entreprise
    $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
    // Récupérer les entreprises enregistrées en BD
    $entreprises = $repositoryEntreprise->findAll();
    // Envoyer les entreprises récupérées à la vue chargée de les afficher
    return $this->render('pro_stages/entreprises.html.twig', ['entreprises'=>$entreprises]);
  }

  /**
  * @Route("/entreprises/new", name="ajouter_entreprises_prostages")
  */
  public function AjouterEntreprise()
  {
    // Création d'une entreprise initialement vierge
    $entreprise = new Entreprise();

    // Création d'un objet formulaire pour saisir une entreprise
    $formulaireEntreprise = $this -> createFormBuilder($entreprise)
    -> add('nom')
    -> add('activite')
    -> add('adresse')
    -> add('email')
    -> add('siteWeb')
    -> getForm();

    // Générer la vue représentant le formulaire
    $vueFormulaireEntreprise = $formulaireEntreprise -> createView();

    // Afficher la page d'ajout d'une entreprise
    return $this -> render('pro_stages/ajoutEntreprise.html.twig',
    ['vueFormulaireEntreprise' => $vueFormulaireEntreprise]);
  }

  /**
  * @Route("/entreprises/{nom}", name="stages_par_entreprise_prostages")
  */
  public function entreprisesParNom($nom)
  {

    // Récupérer le repository de l'entité Entreprise
    $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
    // Récupérer les entreprises enregistrées en BD
    $stagesParNomEntreprise = $repositoryStage->findByNomEntreprise($nom);
    // Envoyer les entreprises récupérées à la vue chargée de les afficher
    return $this->render('pro_stages/entreprises_nom.html.twig', ['stagesParNomEntreprise'=>$stagesParNomEntreprise]);
  }

  /**
  * @Route("/formations", name="formations_prostages")
  */
  public function formations()
  {

    // Récupérer le repository de l'entité Formation
    $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);
    // Récupérer les formations enregistrées en BD
    $formations = $repositoryFormation->findAll();
    // Envoyer les formations récupérées à la vue chargée de les afficher
    return $this->render('pro_stages/formations.html.twig', ['formations'=>$formations]);
  }

  /**
  * @Route("/formations/{nom}", name="stages_par_formation_prostages")
  */
  public function formationsParNom($nom)
  {

    // Récupérer le repository de l'entité Entreprise
    $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
    // Récupérer les entreprises enregistrées en BD
    $stagesParNomFormation = $repositoryStage->findByNomFormation($nom);
    // Envoyer les entreprises récupérées à la vue chargée de les afficher
    return $this->render('pro_stages/formations_nom.html.twig', ['stagesParNomFormation'=>$stagesParNomFormation]);
  }

  /**
  * @Route("/stages/{id}", name="stages_id_prostages")
  */
  public function stages_id($id)
  {
    // Récupérer le repository de l'entité Stage
    $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
    // Récupérer les stages enregistrés en BD
    $stage = $repositoryStage->find($id);
    // Envoyer les stages récupérés à la vue chargée de les afficher

    return $this->render('pro_stages/stages_id.html.twig',
    ['stage' => $stage]);
  }

}
