<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/formation")
*/
class FormationController extends AbstractController
{
  /**
  * @Route("/", name="formation_index", methods={"GET"})
  */
  public function index(FormationRepository $formationRepository): Response
  {
    return $this->render('formation/index.html.twig', [
      'formations' => $formationRepository->findAll(),
    ]);
  }

  /**
  * @Route("/new", name="formation_new", methods={"GET","POST"})
  */
  public function new(Request $request): Response
  {
    $formation = new Formation();
    $form = $this->createForm(FormationType::class, $formation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($formation);
      $entityManager->flush();

      return $this->redirectToRoute('formation_index');
    }

    return $this->render('formation/new.html.twig', [
      'formation' => $formation,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{nom}", name="formation_show", methods={"GET"})
  */
  public function showByName(Formation $formation, $nom): Response
  {
    // Récupérer le repository de l'entité Entreprise
    $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);
    // Récupérer les entreprises enregistrées en BD
    $stagesParNomFormation = $repositoryStage->findByNomFormation($nom);
    // Envoyer les entreprises récupérées à la vue chargée de les afficher
    return $this->render('formation/show.html.twig', ['stagesParNomFormation'=>$stagesParNomFormation, 'formation' => $formation]);

  }

  /**
  * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
  */
  public function edit(Request $request, Formation $formation): Response
  {
    $form = $this->createForm(FormationType::class, $formation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('formation_index');
    }

    return $this->render('formation/edit.html.twig', [
      'formation' => $formation,
      'form' => $form->createView(),
    ]);
  }

  /**
  * @Route("/{id}", name="formation_delete", methods={"DELETE"})
  */
  public function delete(Request $request, Formation $formation): Response
  {
    if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($formation);
      $entityManager->flush();
    }

    return $this->redirectToRoute('formation_index');
  }
}
