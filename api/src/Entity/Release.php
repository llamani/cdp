<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReleaseRepository")
 * @ORM\Table(name="releases")
 */
class Release
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $release_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $src_link;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $doc_description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $doc_file;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Sprint", mappedBy="realease_target", cascade={"persist", "remove"})
     */
    private $sprint;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getSrcLink(): ?string
    {
        return $this->src_link;
    }

    public function setSrcLink(string $src_link): self
    {
        $this->src_link = $src_link;

        return $this;
    }

    public function getDocDescription(): ?string
    {
        return $this->doc_description;
    }

    public function setDocDescription(?string $doc_description): self
    {
        $this->doc_description = $doc_description;

        return $this;
    }

    public function getDocFile(): ?string
    {
        return $this->doc_file;
    }

    public function setDocFile(?string $doc_file): self
    {
        $this->doc_file = $doc_file;

        return $this;
    }

    public function getSprint(): ?Sprint
    {
        return $this->sprint;
    }

    public function setSprint(?Sprint $sprint): self
    {
        $this->sprint = $sprint;

        // set (or unset) the owning side of the relation if necessary
        $newRealease_target = $sprint === null ? null : $this;
        if ($newRealease_target !== $sprint->getRealeaseTarget()) {
            $sprint->setRealeaseTarget($newRealease_target);
        }

        return $this;
    }
}
