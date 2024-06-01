<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:46
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Validator;

use App\Enum\Country;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class CalculationValidator
 *
 * @package App\Validator
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CalculationValidator
{
    use ContextManagerTrait;

    /**
     * @param                           $object
     * @param ExecutionContextInterface $context
     * @return void
     */
    public static function validateTaxNumber($object, ExecutionContextInterface $context): void
    {
        $entity = static::getCalculationFromContext($context);

        $taxNumber = $entity->getTaxNumber();

        if ($taxNumber !== null && Country::tryFromTaxNumber($taxNumber) === null) {
            $context->buildViolation('error.field.tax_number.invalid')->addViolation();
        }
    }

}
