<?php

namespace App\Module\b2b\style1\Table\Domain\Entity;

use App\Module\b2b\style1\Table\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'b2b_style1_user')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $organization;

    public function __construct(int $id = null)
    {
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

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

//    /**
//     * @return array
//     */
//    public function getPackages(): array
//    {
//        return $this->packages;
//    }
//
//    /**
//     * @param array $packages
//     */
//    public function setPackages(array $packages): void
//    {
//        $this->packages = $packages;
//    }
}
