<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table('tasks')]
#[ORM\HasLifecycleCallbacks]
class Task
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $closingDate = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?TaskStatus $status = null;

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getClosingDate(): ?\DateTimeImmutable
    {
        return $this->closingDate;
    }

    public function setClosingDate(\DateTimeImmutable $closingDate): self
    {
        $this->closingDate = $closingDate;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?TaskStatus
    {
        return $this->status;
    }

    public function setStatus(?TaskStatus $status): self
    {
        $this->status = $status;

        return $this;
    }
}