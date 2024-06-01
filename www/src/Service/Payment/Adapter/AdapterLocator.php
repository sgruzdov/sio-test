<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 15:15
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Payment\Adapter;

use App\Enum\PaymentProcessorType;
use App\Exception\ServiceNotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

/**
 * Class AdapterLocator
 *
 * @package App\Service\Payment\Adapter
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class AdapterLocator implements ServiceSubscriberInterface
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
     * @param PaymentProcessorType $type
     * @return PaymentAdapterInterface
     * @throws ServiceNotFoundException
     */
    public function getByType(PaymentProcessorType $type): PaymentAdapterInterface
    {
        try {
            return $this->container->get($type->getAdapterClassName());
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface) {
            throw ServiceNotFoundException::create($type->getAdapterClassName());
        }
    }

    /**
     * @return string[]
     */
    public static function getSubscribedServices(): array
    {
        return [
            PaypalAdapter::class,
            StripeAdapter::class,
        ];
    }
}
