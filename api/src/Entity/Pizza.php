<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\PizzaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ApiResource(mercure: false)]
#[Get(
    normalizationContext: ['groups' => ['pizza_read']]
)]
#[GetCollection(
    normalizationContext: ['groups' => ['pizza_read']]
)]
#[Post(
    security: "is_granted('ROLE_DIRECTOR')",
    denormalizationContext: ['groups' => ['pizza_write']],
    normalizationContext: ['groups' => ['pizza_read']]
)]
#[Patch(
    security: "is_granted('ROLE_DIRECTOR') or object.owner == user",
    denormalizationContext: ['groups' => ['pizza_write']]
)]
#[Delete(
    security: "is_granted('ROLE_DIRECTOR') or object.owner == user"
)]
#[ORM\Entity(repositoryClass: PizzaRepository::class)]
#[UniqueEntity('name', message: 'Le nom est déjà utilisé')]
class Pizza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['pizza_read', 'pizza_write'])]
    #[NotNull]
    #[NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['pizza_read', 'pizza_write'])]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'pizza')]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $ingredient;
    //IRI for POST pizza => /ingredient/42

    #[ORM\OneToMany(mappedBy: 'pizza', targetEntity: Detail::class, orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $detail;

    #[ORM\ManyToOne(inversedBy: 'pizzas')]
    #[Groups(['pizza_read'])]
    #[Gedmo\Blameable(on: 'create')]
    private ?User $owner = null;

    public function __construct()
    {
        $this->ingredient = new ArrayCollection();
        $this->detail = new ArrayCollection();
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredient(): Collection
    {
        return $this->ingredient;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredient->contains($ingredient)) {
            $this->ingredient[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredient->removeElement($ingredient);

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetail(): Collection
    {
        return $this->detail;
    }

    public function addDetail(Detail $detail): self
    {
        if (!$this->detail->contains($detail)) {
            $this->detail[] = $detail;
            $detail->setPizza($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): self
    {
        if ($this->detail->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getPizza() === $this) {
                $detail->setPizza(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
