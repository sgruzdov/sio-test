<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 09:57
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Product
 *
 * @package App\Entity
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Index(name: 'is_active', columns: ['is_active'])]
#[ORM\HasLifecycleCallbacks]
class Product implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'product_id', type: Types::INTEGER, nullable: false, options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(name: 'label', type: Types::STRING, length: 255, nullable: false)]
    #[Assert\NotNull(message: 'error.field.required')]
    #[Assert\Length(min: 2, max: 255, minMessage: 'error.field.length.min', maxMessage: 'error.field.length.max')]
    private ?string $label = null;

    #[ORM\Column(name: 'price', type: Types::DECIMAL, precision: 10, scale: 2, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotNull(message: 'error.field.required')]
    private ?string $price = null;

    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN, nullable: false, options: ['unsigned' => true, 'default' => 1])]
    private bool $isActive = true;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return $this
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return try_to_float($this->price);
    }

    /**
     * @param float|null $price
     * @return $this
     */
    public function setPrice(?float $price): self
    {
        $this->price = $price !== null ? number_format($price, 2, '.', '') : null;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
