<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:23
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidationException
 *
 * @package App\Exception
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class ValidationException extends \Exception
{
    private ConstraintViolationListInterface $violations;

    /**
     * Constructor ValidationException
     *
     * @param ConstraintViolationListInterface $violations
     * @param string|null                      $message
     */
    public function __construct(ConstraintViolationListInterface $violations, ?string $message = 'Validation error')
    {
        parent::__construct($message);

        $this->violations = $violations;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }

    /**
     * @param ConstraintViolationListInterface $violations
     * @param string|null                      $message
     * @return static
     */
    public static function create(ConstraintViolationListInterface $violations, ?string $message = 'Validation error'): static
    {
        return new static($violations, $message);
    }
}
