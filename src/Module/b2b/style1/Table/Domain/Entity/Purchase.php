<?php

namespace App\Module\b2b\style1\Table\Domain\Entity;

use App\Module\b2b\style1\Table\Infrastructure\Repository\PurchaseRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
#[ORM\Table(name: 'b2b_style1_purchase')]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    #[ORM\JoinColumn(name: 'organizerId', nullable: false)]
    private Organization $organizer;

    #[ORM\Column(type: 'string', length: 255)]
    private string $type;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $info;

    #[ORM\Column(name: 'maxPrice', type: 'integer')]
    private int $maxPrice;

    #[ORM\Column(name: 'closeDateTime', type: 'datetime')]
    private DateTime $closeDateTime;


    public const ELECTRONIC_AUCTION = 'electronicAuction';
    private static $typeNames = [
        self::ELECTRONIC_AUCTION => 'Электронный аукцион',
    ];


    public function __construct(int $id = null) {
        if ($id !== null) {
            $this->id = $id;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrganizer(): Organization
    {
        return $this->organizer;
    }

    public function setOrganizer(Organization $organizer): self
    {
        $this->organizer = $organizer;

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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
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

    public function getMaxPrice(): int
    {
        return $this->maxPrice;
    }

    public function setMaxPrice(int $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    public function getCloseDateTime(): DateTime
    {
        return $this->closeDateTime;
    }

    public function setCloseDateTime(string $closeDateTime): self
    {
        $this->closeDateTime = new DateTime($closeDateTime);

        return $this;
    }


    public function getMaxPriceWithSpaces(): string
    {
        return number_format(
            num: $this->maxPrice,
            thousands_separator: ' '
        );
    }

    /**
     * Получить название типа данной закупки
     */
    public function getCurrentTypeName(): string
    {
        return isset($this->type) ? self::getTypeName($this->type) : '';
    }

    /**
     * Получить название типа по его значению в системе
     *
     * @param string $type - тип закупки
     */
    public static function getTypeName(string $type): string
    {
        return array_key_exists($type, self::$typeNames) ? self::$typeNames[$type] : '';
    }
}
