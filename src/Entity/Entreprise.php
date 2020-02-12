<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
*/
class Entreprise
{
  /**
  * @ORM\Id()
  * @ORM\GeneratedValue()
  * @ORM\Column(type="integer")
  */
  private $id;

  /**
  * @ORM\Column(type="string", length=40)
  * @Assert\Length(
  *    min = 4,
  *    minMessage = "Le nom doit faire minimum 4 caractères"
  * )
  */
  private $nom;

  /**
  * @ORM\Column(type="string", length=40)
  * @Assert\NotBlank(message="Cette valeur doit être renseignée")
  */
  private $activite;

  /**
  * @ORM\Column(type="string", length=150)
  */
  private $adresse;

  /**
  * @ORM\Column(type="string", length=45)
  */
  private $email;

  /**
  * @ORM\Column(type="string", length=150)
  * @Assert\Url
  */
  private $siteWeb;

  /**
  * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="entreprise")
  */
  private $stages;

  public function __construct()
  {
    $this->stages = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getNom(): ?string
  {
    return $this->nom;
  }

  public function setNom(string $nom): self
  {
    $this->nom = $nom;

    return $this;
  }

  public function getActivite(): ?string
  {
    return $this->activite;
  }

  public function setActivite(?string $activite): self
  {
    $this->activite = $activite;

    return $this;
  }

  public function getAdresse(): ?string
  {
    return $this->adresse;
  }

  public function setAdresse(string $adresse): self
  {
    $this->adresse = $adresse;

    return $this;
  }

  public function getEmail(): ?string
  {
    return $this->email;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }

  public function getSiteWeb(): ?string
  {
    return $this->siteWeb;
  }

  public function setSiteWeb(string $siteWeb): self
  {
    $this->siteWeb = $siteWeb;

    return $this;
  }

  /**
  * @return Collection|Stage[]
  */
  public function getStages(): Collection
  {
    return $this->stages;
  }

  public function addStage(Stage $stage): self
  {
    if (!$this->stages->contains($stage)) {
      $this->stages[] = $stage;
      $stage->setEntreprise($this);
    }

    return $this;
  }

  public function removeStage(Stage $stage): self
  {
    if ($this->stages->contains($stage)) {
      $this->stages->removeElement($stage);
      // set the owning side to null (unless already changed)
      if ($stage->getEntreprise() === $this) {
        $stage->setEntreprise(null);
      }
    }

    return $this;
  }
}
