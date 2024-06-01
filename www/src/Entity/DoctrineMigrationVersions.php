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

use App\Repository\DoctrineMigrationVersionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DoctrineMigrationVersions
 *
 * @package App\Entity
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
#[ORM\Entity(repositoryClass: DoctrineMigrationVersionsRepository::class)]
#[ORM\HasLifecycleCallbacks]
class DoctrineMigrationVersions implements EntityInterface
{
    #[ORM\Id]
    #[ORM\Column(name: 'version', type: Types::STRING, length: 191, nullable: false)]
    private ?string $version = null;

    #[ORM\Column(name: 'executed_at', type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private ?\DateTimeImmutable $executedAt = null;

    #[ORM\Column(name: 'execution_time', type: Types::INTEGER, length: 11, nullable: true, options: ['default' => null])]
    private int $execution_time = 0;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getExecutedAt(): ?\DateTimeImmutable
    {
        return $this->executedAt;
    }

    /**
     * @return int
     */
    public function getExecutionTime(): int
    {
        return $this->execution_time;
    }
}
