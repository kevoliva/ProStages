<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\User;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {

    // Création de deux utilisateurs de test

    $kevoliva = new User();
    $kevoliva->setPrenom("Kévin");
    $kevoliva->setNom("Oliva");
    $kevoliva->setEmail("olivakevin64@gmail.com");
    $kevoliva->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
    $kevoliva->setPassword('$2y$10$IP4SnULuwgbGq6juGvZgPONpGkLbZP9zK9Xwg2vjNj/qdY0ndTyYm');
    $manager->persist($kevoliva);

    $benjouy = new User();
    $benjouy->setPrenom("Benjamin");
    $benjouy->setNom("Delsol");
    $benjouy->setEmail("bdelsol40@gmail.com");
    $benjouy->setRoles(['ROLE_USER']);
    $benjouy->setPassword('$2y$10$cm/Utn.LB1IKpktUf9X.fOBdp9byvuoHDqnvyt5g1ARA4bWbDpCve');
    $manager->persist($benjouy);


    // Création d'un jeu de données faker
    $faker = \Faker\Factory::create('fr_FR');


    /***************************************
    *** CREATION DES ENTREPRISES ***
    ****************************************/

    $nbEntreprises = 15;

    for ($i = 0 ; $i < $nbEntreprises ; $i++ ) {

      $tabEntreprise[$i] = new Entreprise();
      $tabEntreprise[$i]->setNom($faker->company);
      $tabEntreprise[$i]->setActivite($faker->regexify('(Développement|Conception|Agence) (Web|Bases de données|Mobile)'));
      $tabEntreprise[$i]->setAdresse($faker->address);
      $tabEntreprise[$i]->setEmail($faker->companyEmail);
      $tabEntreprise[$i]->setSiteWeb($faker->domainName);

      $manager->persist($tabEntreprise[$i]);

    }

    /***************************************
    *** CREATION DES FORMATIONS ET DES STAGES ASSOCIES ***
    ****************************************/

    $listeFormations = array(
      "DUT INFO" => "DUT Informatique",
      "DUT GEA" => "DUT Gestion Entreprises et Administrations",
      "DUT COM" => "DUT Techniques Commercialisation",
      "Licence INFO" => "Licence Informatique",
    );

    foreach ($listeFormations as $nomCourt => $nom) {
      // ************* Création d'une nouvelle formation *************
      $formation = new Formation();
      // Définition du nom court de la formation
      $formation->setNomCourt($nomCourt);
      // Définition du nom (long) de la formation
      $formation->setNom($nom);

      $manager->persist($formation);


      // **** Création de plusieurs stages associés à la formation

      $nbStagesAGenerer = $faker->numberBetween($min = 0, $max = 10);

      for ($numStage = 0; $numStage < $nbStagesAGenerer; $numStage++) {
        $stage = new Stage();
        $stage -> setTitre("Stage - ".$faker->jobTitle);
        $stage -> setDescription($faker->realText($maxNbChars = 1000, $indexSize = 2));

        // Création relation Stage --> Formation
        $stage -> addFormation($formation);
        /****** Définir et mettre à jour l'entreprise' ******/
        // Sélectionner une entreprise au hasard parmi les 15 créées dans $tabEntreprise
        $numEntreprise = $faker->numberBetween($min = 0, $max = 14);
        // Création relation Stage --> Entreprise
        $stage -> setEntreprise($tabEntreprise[$numEntreprise]);
        // Création relation Entreprise --> Stage
        $tabEntreprise[$numEntreprise] -> addStage($stage);
        // Persister les objets modifiés
        $manager->persist($stage);
        $manager->persist($tabEntreprise[$numEntreprise]);
      }
    }


    $manager->flush();

  }
}
