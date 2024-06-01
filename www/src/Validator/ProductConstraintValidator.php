<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:47
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Validator;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class ProductConstraintValidator
 *
 * @package App\Validator
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class ProductConstraintValidator extends ConstraintValidator
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
        if (!$constraint instanceof ProductConstraint) {
            throw new UnexpectedTypeException($constraint, ProductConstraint::class);
        }

        $entity = static::getCalculationFromContext($this->context);
        $productId = $entity->getProduct();

        if ($productId === null) {
            return;
        }

        $product = $this->entityManager->getRepository(Product::class)->getEntityById($productId);

        if ($product === null) {
            $this->context->buildViolation('error.field.product.invalid')->addViolation();
        }
    }
}
