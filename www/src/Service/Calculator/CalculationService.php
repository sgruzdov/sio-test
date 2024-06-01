<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:06
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Calculator;

use App\Exception\ValidationException;
use App\Service\Calculator\DTO\CalculationDTO;
use App\Service\Calculator\Resolver\PriceResolver;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CalculationService
 *
 * @package App\Service\Calculator
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CalculationService
{
    private ValidatorInterface $validator;
    private PriceResolver $priceResolver;

    /**
     * Constructor CalculatorService
     *
     * @param ValidatorInterface $validator
     * @param PriceResolver      $priceResolver
     */
    public function __construct(ValidatorInterface $validator, PriceResolver $priceResolver)
    {
        $this->validator = $validator;
        $this->priceResolver = $priceResolver;
    }

    /**
     * @param array      $data
     * @param array|null $validationGroups
     * @return CalculationDTO
     * @throws ValidationException
     */
    public function initCalculation(array $data, array $validationGroups = null): CalculationDTO
    {
        $calculation = CalculationDTO::from($data);

        $errors = $this->validator->validate($calculation, groups: $validationGroups);

        if ($errors->count() > 0) {
            throw ValidationException::create($errors);
        }

        return $calculation;
    }

    /**
     * @param CalculationDTO $calculation
     * @return float
     */
    public function calculatePrice(CalculationDTO $calculation): float
    {
        return $this->priceResolver->resolve($calculation);
    }
}
