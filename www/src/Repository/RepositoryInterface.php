<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 09:28
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;

/**
 * Interface RepositoryInterface
 *
 * @package App\Repository
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * @return EntityInterface
     */
    public function getFreshEntity(): EntityInterface;
}
