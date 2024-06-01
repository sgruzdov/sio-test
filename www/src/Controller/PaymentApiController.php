<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 14:21
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Controller;

use App\Model\PaymentModel;
use App\Service\Response\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class PaymentApiController
 *
 * @package App\Controller
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class PaymentApiController extends AbstractController
{
    private TranslatorInterface $translator;
    private PaymentModel $model;

    /**
     * Constructor IndexController
     *
     * @param TranslatorInterface $translator
     * @param PaymentModel        $model
     */
    public function __construct(TranslatorInterface $translator, PaymentModel $model)
    {
        $this->translator = $translator;
        $this->model = $model;
    }

    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function calculatePrice(Request $request): Response
    {
        try {
            $response = $this->model->calculatePrice($request);
        } catch (\Throwable) {
            $response = Response::createResponse($this->translator->trans('error.common'), SymfonyResponse::HTTP_BAD_REQUEST);
        }

        return $response;
    }

    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    public function purchase(Request $request): Response
    {
        try {
            $response = $this->model->purchase($request);
        } catch (\Throwable) {
            $response = Response::createResponse($this->translator->trans('error.common'), SymfonyResponse::HTTP_BAD_REQUEST);
        }

        return $response;
    }
}
