<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 13:27
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Validator;

use App\Service\Calculator\DTO\CalculationDTO;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @package App\Validator
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
trait ContextManagerTrait
{
    /**
     * @param ExecutionContextInterface $context
     * @return CalculationDTO
     */
    private static function getCalculationFromContext(ExecutionContextInterface $context): CalculationDTO
    {
        $entity = $context->getObject();

        if (!$entity instanceof CalculationDTO) {
            throw new \LogicException('Unexpected entity type received');
        }

        return $entity;
    }
}
