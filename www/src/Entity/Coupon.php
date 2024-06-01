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

use App\Enum\CouponType;
use App\Repository\CouponRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Product
 *
 * @package App\Entity
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ORM\Index(name: 'is_used', columns: ['is_used'])]
#[ORM\HasLifecycleCallbacks]
class Coupon implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'coupon_id', type: Types::INTEGER, nullable: false, options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(name: 'code', type: Types::STRING, length: 255, nullable: false)]
    #[Assert\NotNull(message: 'error.field.required')]
    #[Assert\Length(min: 2, max: 255, minMessage: 'error.field.length.min', maxMessage: 'error.field.length.max')]
    private ?string $code = null;

    #[ORM\Column(name: 'type_id', type: Types::SMALLINT, nullable: false, enumType: CouponType::class, options: ['unsigned' => true])]
    #[Assert\NotNull(message: 'error.field.required')]
    private ?CouponType $type = null;

    #[ORM\Column(name: 'amount', type: Types::DECIMAL, precision: 10, scale: 2, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotNull(message: 'error.field.required')]
    private ?string $amount = null;

    #[ORM\Column(name: 'is_used', type: Types::BOOLEAN, nullable: false, options: ['unsigned' => true, 'default' => 0])]
    private bool $isUsed = false;

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
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     * @return $this
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return CouponType|null
     */
    public function getType(): ?CouponType
    {
        return $this->type;
    }

    /**
     * @param CouponType|null $type
     * @return $this
     */
    public function setType(?CouponType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return try_to_float($this->amount);
    }

    /**
     * @param float|null $amount
     * @return $this
     */
    public function setAmount(?float $amount): self
    {
        $this->amount = $amount !== null ? number_format($amount, 2, '.', '') : null;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsUsed(): bool
    {
        return $this->isUsed;
    }

    /**
     * @param bool $isUsed
     * @return $this
     */
    public function setIsUsed(bool $isUsed): self
    {
        $this->isUsed = $isUsed;

        return $this;
    }
}
