<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 08:46
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class JsonRequestSubscriber
 *
 * @package App\Event
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class JsonRequestSubscriber implements EventSubscriberInterface
{
    /**
     * @param RequestEvent $event
     * @throws \JsonException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$this->supports($request)) {
            return;
        }

        $data = \json_decode(to_string($request->getContent()), true, 512, JSON_THROW_ON_ERROR);

        if (\is_array($data)) {
            $request->request->replace($data);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function supports(Request $request): bool
    {
        return $request->getContentTypeFormat() === 'json' && $request->getContent();
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 100],
        ];
    }
}
