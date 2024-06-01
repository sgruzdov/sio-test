<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 15:40
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Service\Response\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ServerBag;

/**
 * Class ResponseTest
 *
 * @package App\Tests\Unit\Service
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class ResponseTest extends TestCase
{
    private Response $response;
    private Request $request;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->response = new Response();
        $this->request = $this->createMock(Request::class);

        $serverBag = $this->createMock(ServerBag::class);
        $serverBag->method('get')->willReturn('');

        $this->request->server = $serverBag;
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAddMessage(): void
    {
        $this->response->addMessage('a success message');
        $this->response->prepare($this->request);

        $expectedResult = [
            'payload'  => new \ArrayObject(),
            'messages' => [
                'a success message',
            ],
            'errors'   => [],
        ];

        self::assertIsString($this->response->getContent());
        self::assertEquals(json_encode($expectedResult, JSON_THROW_ON_ERROR), $this->response->getContent());
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAddMultipleMessage(): void
    {
        $this->response->addMessage('a success message');
        $this->response->addMessage('an info message');
        $this->response->prepare($this->request);

        $expectedResult = [
            'payload'  => new \ArrayObject(),
            'messages' => [
                'a success message',
                'an info message',
            ],
            'errors'   => [],
        ];

        self::assertIsString($this->response->getContent());
        self::assertEquals(json_encode($expectedResult, JSON_THROW_ON_ERROR), $this->response->getContent());
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAddFieldError(): void
    {
        $this->response->addError('field', 'an error');
        $this->response->prepare($this->request);

        $expectedResult = [
            'payload'  => new \ArrayObject(),
            'messages' => [],
            'errors'   => ['field' => 'an error'],
        ];

        self::assertIsString($this->response->getContent());
        self::assertEquals(json_encode($expectedResult, JSON_THROW_ON_ERROR), $this->response->getContent());
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAddAssociativeFieldError(): void
    {
        $this->response->addError('entity.field.property', 'an error');
        $this->response->prepare($this->request);

        $expectedResult = [
            'payload'  => new \ArrayObject(),
            'messages' => [],
            'errors'   => [
                'entity' => [
                    'field' => [
                        'property' => 'an error',
                    ],
                ],
            ],
        ];

        self::assertIsString($this->response->getContent());
        self::assertEquals(json_encode($expectedResult, JSON_THROW_ON_ERROR), $this->response->getContent());
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAddAssociativeByEqualFieldError(): void
    {
        $this->response->addError('entity.field.property', 'an error');
        $this->response->addError('entity.field.property', 'second error');
        $this->response->prepare($this->request);

        $expectedResult = [
            'payload'  => new \ArrayObject(),
            'messages' => [],
            'errors'   => [
                'entity' => [
                    'field' => [
                        'property' => [
                            'an error',
                            'second error',
                        ],
                    ],
                ],
            ],
        ];

        self::assertIsString($this->response->getContent());
        self::assertEquals(json_encode($expectedResult, JSON_THROW_ON_ERROR), $this->response->getContent());
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAddMultipleErrors(): void
    {
        $this->response->addError('field', 'an error');
        $this->response->addError('entity.property', 'second error');
        $this->response->addError('entity.secProperty.field', 'third error');
        $this->response->prepare($this->request);

        $expectedResult = [
            'payload'  => new \ArrayObject(),
            'messages' => [],
            'errors'   => [
                'field'  => 'an error',
                'entity' => [
                    'property'    => 'second error',
                    'secProperty' => [
                        'field' => 'third error',
                    ],
                ],
            ],
        ];

        self::assertIsString($this->response->getContent());
        self::assertEquals(json_encode($expectedResult, JSON_THROW_ON_ERROR), $this->response->getContent());
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testAddData(): void
    {
        $this->response->addData('key', 'value');
        $this->response->prepare($this->request);

        $expectedResult = [
            'payload'  => ['key' => 'value'],
            'messages' => [],
            'errors'   => [],
        ];

        self::assertIsString($this->response->getContent());
        self::assertEquals(json_encode($expectedResult, JSON_THROW_ON_ERROR), $this->response->getContent());
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function testSetData(): void
    {
        $this->response->setData(['key' => 1, 'key2' => 'value', 'key3' => ['nested_key' => true]]);
        $this->response->prepare($this->request);

        $expectedResult = [
            'payload'  => [
                'key'  => 1,
                'key2' => 'value',
                'key3' => [
                    'nested_key' => true,
                ],
            ],
            'messages' => [],
            'errors'   => [],
        ];

        self::assertIsString($this->response->getContent());
        self::assertEquals(json_encode($expectedResult, JSON_THROW_ON_ERROR), $this->response->getContent());
    }
}
