<?php

namespace App\Entity;

use App\Repository\GameRepository;
use App\Traits\SlugableEntity;
use App\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
#[ORM\HasLifecycleCallbacks]

class Game
{

    use TimestampableEntity;
    use SlugableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $stock = null;
    /**
     * @var Collection<int, GameCategory>
     */
    #[ORM\ManyToMany(targetEntity: GameCategory::class, inversedBy: 'games')]
    private Collection $category;

    /**
     * @var Collection<int, GameImage>
     */
    #[ORM\OneToMany(targetEntity: GameImage::class, mappedBy: 'game', orphanRemoval: true)]
    private Collection $gameImages;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'game', orphanRemoval: true)]
    private Collection $reviews;

    /**
     * @var Collection<int, OrderLine>
     */
    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'game')]
    private Collection $orderLines;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->gameImages = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->orderLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return Collection<int, GameCategory>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(GameCategory $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(GameCategory $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, GameImage>
     */
    public function getGameImages(): Collection
    {
        return $this->gameImages;
    }

    public function addGameImage(GameImage $gameImage): static
    {
        if (!$this->gameImages->contains($gameImage)) {
            $this->gameImages->add($gameImage);
            $gameImage->setGame($this);
        }

        return $this;
    }

    public function removeGameImage(GameImage $gameImage): static
    {
        if ($this->gameImages->removeElement($gameImage)) {
            // set the owning side to null (unless already changed)
            if ($gameImage->getGame() === $this) {
                $gameImage->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setGame($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getGame() === $this) {
                $review->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderLine>
     */
    public function getOrderLines(): Collection
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): static
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines->add($orderLine);
            $orderLine->setGame($this);
        }

        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine): static
    {
        if ($this->orderLines->removeElement($orderLine)) {
            // set the owning side to null (unless already changed)
            if ($orderLine->getGame() === $this) {
                $orderLine->setGame(null);
            }
        }

        return $this;
    }

    private function getSlug()
    {
        return $this->getName();
    }
}
