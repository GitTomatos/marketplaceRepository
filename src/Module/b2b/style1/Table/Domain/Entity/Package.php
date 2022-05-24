<?php

namespace App\Module\b2b\style1\Table\Domain\Entity;

use App\Module\b2b\style1\Table\Infrastructure\Repository\PackageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackageRepository::class)]
#[ORM\UniqueConstraint(columns: ['userId', 'purchaseId'])]
#[ORM\Table(name: 'b2b_style1_package')]
class Package
{
    public const inProcessing = 'В обработке';
    public const processed = 'Обработано';


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', unique: true, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $info;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $state;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $price;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Purchase::class)]
    #[ORM\JoinColumn(name: "purchaseId", nullable: false)]
    private Purchase $purchaseId;

    public function __construct(int $id = null)
    {
        $this->state = self::inProcessing;

        if ($id !== null) {
            $this->id = $id;
        }
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

    public function getInfo(): ?string
    {
        return $this->info;
    }

    public function setInfo(string $info): self
    {
        $this->info = $info;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPurchaseId(): ?Purchase
    {
        return $this->purchaseId;
    }

    public function setPurchaseId(Purchase $purchaseId): self
    {
        $this->purchaseId = $purchaseId;

        return $this;
    }
}
