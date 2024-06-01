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

use App\Exception\ServiceNotFoundException;
use App\Exception\ValidationException;
use App\Service\Calculator\DTO\CalculationDTO;
use App\Service\Response\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Validator\Constraint;

/**
 * Class PaymentModel
 *
 * @package App\Model
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class PaymentModel extends AbstractModel
{
    /**
     * @param Request $request
     * @return Response
     * @throws ServiceNotFoundException
     */
    public function calculatePrice(Request $request): Response
    {
        try {
            $calculation = $this->serviceLocator->getCalculationService()->initCalculation($request->request->all());
        } catch (ValidationException $ex) {
            $this->processViolations($ex);

            return $this->response;
        }

        $this->response->addData('price', $this->serviceLocator->getCalculationService()->calculatePrice($calculation));

        return $this->response;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ServiceNotFoundException
     */
    public function purchase(Request $request): Response
    {
        try {
            $calculation = $this->serviceLocator->getCalculationService()->initCalculation(
                $request->request->all(),
                [Constraint::DEFAULT_GROUP, CalculationDTO::VALIDATION_GROUP_PURCHASE],
            );
        } catch (ValidationException $ex) {
            $this->processViolations($ex);

            return $this->response;
        }

        $price = $this->serviceLocator->getCalculationService()->calculatePrice($calculation);

        $result = $this->serviceLocator->getPaymentProcessor()->purchase($price, $calculation->getPaymentProcessor());

        // ... Сохранение платежа

        $message = $result ? 'success.purchase' : 'error.purchase';
        $this->response->addMessage($this->serviceLocator->getTranslator()->trans($message));

        if (!$result) {
            $this->response->setStatusCode(SymfonyResponse::HTTP_BAD_REQUEST);
        }

        return $this->response;
    }
}
