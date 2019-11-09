<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @ORM\Table(name="projects")
 */
class Project
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
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Issue", mappedBy="project", orphanRemoval=true)
     */
    private $issues;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Test", mappedBy="project", orphanRemoval=true)
     */
    private $tests;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sprint", mappedBy="project", orphanRemoval=true)
     */
    private $sprints;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProjectRelation", mappedBy="project_id", orphanRemoval=true)
     */
    private $userProjectRelations;

    public function __construct()
    {
        $this->issues = new ArrayCollection();
        $this->tests = new ArrayCollection();
        $this->sprints = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Issue[]
     */
    public function getIssues(): Collection
    {
        return $this->issues;
    }

    public function addIssue(Issue $issue): self
    {
        if (!$this->issues->contains($issue)) {
            $this->issues[] = $issue;
            $issue->setProject($this);
        }

        return $this;
    }

    public function removeIssue(Issue $issue): self
    {
        if ($this->issues->contains($issue)) {
            $this->issues->removeElement($issue);
            // set the owning side to null (unless already changed)
            if ($issue->getProject() === $this) {
                $issue->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Test[]
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->setProject($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->contains($test)) {
            $this->tests->removeElement($test);
            // set the owning side to null (unless already changed)
            if ($test->getProject() === $this) {
                $test->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Sprint[]
     */
    public function getSprints(): Collection
    {
        return $this->sprints;
    }

    public function addSprint(Sprint $sprint): self
    {
        if (!$this->sprints->contains($sprint)) {
            $this->sprints[] = $sprint;
            $sprint->setProject($this);
        }

        return $this;
    }

    public function removeSprint(Sprint $sprint): self
    {
        if ($this->sprints->contains($sprint)) {
            $this->sprints->removeElement($sprint);
            // set the owning side to null (unless already changed)
            if ($sprint->getProject() === $this) {
                $sprint->setProject(null);
            }
        }

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
            $userProjectRelation->setProjectId($this);
        }

        return $this;
    }

    public function removeUserProjectRelation(UserProjectRelation $userProjectRelation): self
    {
        if ($this->userProjectRelations->contains($userProjectRelation)) {
            $this->userProjectRelations->removeElement($userProjectRelation);
            // set the owning side to null (unless already changed)
            if ($userProjectRelation->getProjectId() === $this) {
                $userProjectRelation->setProjectId(null);
            }
        }

        return $this;
    }
}
