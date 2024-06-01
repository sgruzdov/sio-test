<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 09:55
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Entity;

/**
 * Interface EntityInterface
 *
 * @package App\Entity
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
interface EntityInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;
}
