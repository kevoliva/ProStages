<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;

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
    $stages = $repositoryStage->findAll();
    // Envoyer les stages récupérés à la vue chargée de les afficher
    return $this->render('pro_stages/index.html.twig', ['stages'=>$stages]);
  }

  /**
  * @Route("/entreprises", name="entreprises_prostages")
  */
  public function entreprises()
  {
    return $this->render('pro_stages/entreprises.html.twig');
  }

  /**
  * @Route("/formations", name="formations_prostages")
  */
  public function formations()
  {
    return $this->render('pro_stages/formations.html.twig');
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
