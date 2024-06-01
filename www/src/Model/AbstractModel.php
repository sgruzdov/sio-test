<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 14:25
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Model;

use App\Exception\ValidationException;
use App\Service\Response\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class AbstractModel
 *
 * @package App\Model
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
abstract class AbstractModel implements ModelInterface
{
    protected Response $response;
    protected ServiceLocator $serviceLocator;

    /**
     * Constructor AbstractModel
     *
     * @param Response       $response
     * @param ServiceLocator $serviceLocator
     */
    public function __construct(Response $response, ServiceLocator $serviceLocator)
    {
        $this->response = $response;
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param ValidationException $exception
     * @return void
     */
    protected function processViolations(ValidationException $exception): void
    {
        foreach ($exception->getViolations() as $violation) {
            $this->response->addError($violation->getPropertyPath(), $violation->getMessage());
        }

        $this->response->setStatusCode(SymfonyResponse::HTTP_BAD_REQUEST);
    }
}
