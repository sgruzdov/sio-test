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

use App\Entity\Coupon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class CouponConstraintValidator
 *
 * @package App\Validator
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CouponConstraintValidator extends ConstraintValidator
{
    use ContextManagerTrait;

    private EntityManagerInterface $entityManager;

    /**
     * Constructor CalculationConstraintValidator
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CouponConstraint) {
            throw new UnexpectedTypeException($constraint, CouponConstraint::class);
        }

        $entity = static::getCalculationFromContext($this->context);
        $code = $entity->getCoupon();

        if ($code === null) {
            return;
        }

        $coupon = $this->entityManager->getRepository(Coupon::class)->getEntityByCode($code);

        if ($coupon === null) {
            $this->context->buildViolation('error.field.coupon.invalid')->addViolation();
        }
    }
}
