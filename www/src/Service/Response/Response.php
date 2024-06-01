<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 08:50
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Response
 *
 * @package App\Service\Response
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class Response extends JsonResponse
{
    private array|object $payload = [];
    private array $messages = [];
    private array $errors = [];

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->payload[$key] ?? null;
    }

    /**
     * @param string $key
     * @param mixed  $data
     * @return self
     */
    public function addData(string $key, mixed $data): self
    {
        $this->payload[$key] = $data;

        return $this;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function setData(mixed $data = []): static
    {
        $this->payload = $data;

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function addMessage(string $message): self
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * @param string $path
     * @param string $message
     * @return self
     */
    public function addError(string $path, string $message): self
    {
        $nestedArray = explode_string_to_nested_array('.', $path, $message);

        $this->errors = array_merge_recursive($this->errors, $nestedArray);

        return $this;
    }

    /**
     * @param string|null        $message
     * @param int                $statusCode
     * @psalm-param self::HTTP_* $statusCode
     * @return Response
     */
    public static function createResponse(?string $message = null, int $statusCode = self::HTTP_OK): Response
    {
        $response = new self();

        $response->setStatusCode($statusCode);

        if ($message !== null) {
            $response->addMessage($message);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function prepare(Request $request): static
    {
        parent::setData([
            'payload'  => $this->payload,
            'messages' => $this->messages,
            'errors'   => $this->errors,
        ]);

        $this->update();

        return parent::prepare($request);
    }
}
