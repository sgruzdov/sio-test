<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 14:37
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Model;

use App\Service\Calculator\CalculationService;
use App\Service\Payment\PaymentProcessor;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use App\Exception\ServiceNotFoundException;

/**
 * Class ServiceLocator
 *
 * @package App\Model
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class ServiceLocator implements ServiceSubscriberInterface
{
    private ContainerInterface $container;

    /**
     * Constructor ServiceLocator
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return TranslatorInterface
     * @throws ServiceNotFoundException
     */
    public function getTranslator(): TranslatorInterface
    {
        try {
            return $this->container->get(TranslatorInterface::class);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface) {
            throw ServiceNotFoundException::create(TranslatorInterface::class);
        }
    }

    /**
     * @return EntityManagerInterface
     * @throws ServiceNotFoundException
     */
    public function getEntityManager(): EntityManagerInterface
    {
        try {
            return $this->container->get(EntityManagerInterface::class);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface) {
            throw ServiceNotFoundException::create(EntityManagerInterface::class);
        }
    }

    /**
     * @return CalculationService
     * @throws ServiceNotFoundException
     */
    public function getCalculationService(): CalculationService
    {
        try {
            return $this->container->get(CalculationService::class);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface) {
            throw ServiceNotFoundException::create(CalculationService::class);
        }
    }

    /**
     * @return PaymentProcessor
     * @throws ServiceNotFoundException
     */
    public function getPaymentProcessor(): PaymentProcessor
    {
        try {
            return $this->container->get(PaymentProcessor::class);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface) {
            throw ServiceNotFoundException::create(PaymentProcessor::class);
        }
    }

    /**
     * @return string[]
     */
    public static function getSubscribedServices(): array
    {
        return [
            TranslatorInterface::class,
            EntityManagerInterface::class,
            CalculationService::class,
            PaymentProcessor::class,
        ];
    }
}
