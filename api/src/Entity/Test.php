<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestRepository")
 * @ORM\Table(name="tests")
 */
class Test
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
     * @ORM\Column(type="string", length=255, columnDefinition="enum('unit', 'fonctional', 'integration', 'ui')")
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $expected_result;

    /**
     * @ORM\Column(type="text")
     */
    private $obtained_result;

    /**
     * @ORM\Column(type="datetime")
     */
    private $test_date;

    /**
     * @ORM\Column(type="string", length=255, columnDefinition="enum('SUCCESS', 'FAIL', 'UNKNOWN')")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="tests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     */
    private $testManagers;

    public function __construct()
    {
        $this->testManagers = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getExpectedResult(): ?string
    {
        return $this->expected_result;
    }

    public function setExpectedResult(string $expected_result): self
    {
        $this->expected_result = $expected_result;

        return $this;
    }

    public function getObtainedResult(): ?string
    {
        return $this->obtained_result;
    }

    public function setObtainedResult(string $obtained_result): self
    {
        $this->obtained_result = $obtained_result;

        return $this;
    }

    public function getTestDate(): ?\DateTimeInterface
    {
        return $this->test_date;
    }

    public function setTestDate(\DateTimeInterface $test_date): self
    {
        $this->test_date = $test_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getTestManagers(): Collection
    {
        return $this->testManagers;
    }

    public function addTestManager(User $testManager): self
    {
        if (!$this->testManagers->contains($testManager)) {
            $this->testManagers[] = $testManager;
        }

        return $this;
    }

    public function removeTestManager(User $testManager): self
    {
        if ($this->testManagers->contains($testManager)) {
            $this->testManagers->removeElement($testManager);
        }

        return $this;
    }
}
