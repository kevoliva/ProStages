<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProStagesController extends AbstractController
{
  /**
   * @Route("/", name="accueil_pro_stages")
   */
  public function index()
  {
      return $this->render('pro_stages/index.html.twig', [
          'controller_name' => 'ProStagesController',
      ]);
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
      return $this->render('pro_stages/stages_id.html.twig',
    ['idRessource' => $id]);
  }
}
