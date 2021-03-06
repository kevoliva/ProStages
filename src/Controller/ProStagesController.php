<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Form\EntrepriseType;
use App\Form\StageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

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
  public function ajouterEntreprise(Request $requeteHttp, ObjectManager $manager)
  {
    // Création d'une entreprise initialement vierge
    $entreprise = new Entreprise();

    // Création du formulaire permettant de saisir une ressource
    $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

    // Récupération des données dans $entreprise si elles ont été soumises
    $formulaireEntreprise -> handleRequest($requeteHttp);

    // Traiter les données du formulaire s'il a été soumis
    if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
      // Enregistrer les caractéristiques de l'entreprise en BD
      $manager->persist($entreprise);
      $manager->flush();

      // Rediriger l'utilisateur vers la page affichant la liste des entreprises
      return $this->redirectToRoute('entreprises_prostages');
    }
    // Générer la vue représentant le formulaire
    $vueFormulaireEntreprise = $formulaireEntreprise -> createView();

    // Afficher la page d'ajout d'une entreprise
    return $this -> render('pro_stages/ajoutModifEntreprise.html.twig',
    ['vueFormulaireEntreprise' => $vueFormulaireEntreprise, 'action' => "ajouter"]);
  }

  /**
  * @Route("/entreprises/edit/{id}", name="modifier_entreprise_prostages")
  */
  public function modifierEntreprise(Request $requeteHttp, ObjectManager $manager, Entreprise $entreprise)
  {

    // Création du formulaire permettant de modifier l'entreprise
    $formulaireEntreprise = $this -> createForm(EntrepriseType::class, $entreprise);

    // Récupération des données dans $entreprise si elles ont été soumises
    $formulaireEntreprise -> handleRequest($requeteHttp);

    // Traiter les données du formulaire s'il a été soumis
    if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid()){
      // Enregistrer les caractéristiques de l'entreprise en BD
      $manager->persist($entreprise);
      $manager->flush();

      // Rediriger l'utilisateur vers la page affichant la liste des entreprises
      return $this->redirectToRoute('entreprises_prostages');
    }
    // Générer la vue représentant le formulaire
    $vueFormulaireEntreprise = $formulaireEntreprise -> createView();

    // Afficher la page d'ajout d'une entreprise
    return $this -> render('pro_stages/ajoutModifEntreprise.html.twig',
    ['vueFormulaireEntreprise' => $vueFormulaireEntreprise, 'action' => "modifier"]);
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
  * @Route("/stages/show/{id}", name="stages_id_prostages")
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

  /**
  * @Route("/stages/new", name="ajouter_stage_prostages")
  */
  public function ajouterStage(Request $requeteHttp, ObjectManager $manager)
  {
    // Création d'un stage initialement vierge
    $stage = new Stage();

    // Création du formulaire permettant de saisir un stage
    $formulaireStage = $this->createForm(StageType::class, $stage);

    // Récupération des données dans $stage si elles ont été soumises
    $formulaireStage -> handleRequest($requeteHttp);

    // Traiter les données du formulaire s'il a été soumis
    if ($formulaireStage->isSubmitted() && $formulaireStage->isValid()){
      // Enregistrer les caractéristiques du stage en BD
      $manager->persist($stage);
      $manager->flush();

      // Rediriger l'utilisateur vers la page affichant la liste des stages
      return $this->redirectToRoute('accueil_pro_stages');
    }
    // Générer la vue représentant le formulaire
    $vueFormulaireStage = $formulaireStage -> createView();

    // Afficher la page d'ajout d'un stage
    return $this -> render('pro_stages/ajoutModifStage.html.twig',
    ['vueFormulaireStage' => $vueFormulaireStage, 'action' => "ajouter"]);
  }


/**
* @Route("/stages/edit/{id}", name="modifier_stage_prostages")
*/
public function modifierStage(Request $requeteHttp, ObjectManager $manager, Stage $stage)
{
  // Création du formulaire permettant de saisir un stage
  $formulaireStage = $this->createForm(StageType::class, $stage);

  // Récupération des données dans $stage si elles ont été soumises
  $formulaireStage -> handleRequest($requeteHttp);

  // Traiter les données du formulaire s'il a été soumis
  if ($formulaireStage->isSubmitted() && $formulaireStage->isValid()){
    // Enregistrer les caractéristiques du stage en BD
    $manager->persist($stage);
    $manager->flush();

    // Rediriger l'utilisateur vers la page affichant la liste des stages
    return $this->redirectToRoute('accueil_pro_stages');
  }
  // Générer la vue représentant le formulaire
  $vueFormulaireStage = $formulaireStage -> createView();

  // Afficher la page de modification d'un stage
  return $this -> render('pro_stages/ajoutModifStage.html.twig',
  ['vueFormulaireStage' => $vueFormulaireStage, 'action' => "modifier"]);
}
}
