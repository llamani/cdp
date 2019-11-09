<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
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
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProjectRelation", mappedBy="user_id", orphanRemoval=true)
     */
    private $userProjectRelations;

    public function __construct()
    {
        $this->userProjectRelations = new ArrayCollection();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|UserProjectRelation[]
     */
    public function getUserProjectRelations(): Collection
    {
        return $this->userProjectRelations;
    }

    public function addUserProjectRelation(UserProjectRelation $userProjectRelation): self
    {
        if (!$this->userProjectRelations->contains($userProjectRelation)) {
            $this->userProjectRelations[] = $userProjectRelation;
            $userProjectRelation->setUserId($this);
        }

        return $this;
    }

    public function removeUserProjectRelation(UserProjectRelation $userProjectRelation): self
    {
        if ($this->userProjectRelations->contains($userProjectRelation)) {
            $this->userProjectRelations->removeElement($userProjectRelation);
            // set the owning side to null (unless already changed)
            if ($userProjectRelation->getUserId() === $this) {
                $userProjectRelation->setUserId(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        return null;
    }
}
