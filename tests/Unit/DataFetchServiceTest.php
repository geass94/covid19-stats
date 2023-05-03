<?php

namespace Tests\Unit;

use App\Services\Impl\Devtestge;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class DataFetchServiceTest extends TestCase
{
    private $mockClient;

    private const sampleCountriesResponse = [
            [
                'name' => [
                    'en' => 'English A',
                    'ka' => 'Georgian A'
                ],
                'code' => 'KA'
            ],
            [
                'name' => [
                    'en' => 'English B',
                    'ka' => 'Georgian B'
                ],
                'code' => 'EN'
            ],
            [
                'name' => [
                    'en' => 'English C',
                    'ka' => 'Georgian C'
                ],
                'code' => 'UA'
            ],
        ];

    private const sampleCountryStatsResponse = [];
    protected function setUp(): void
    {
        $mock = new MockHandler([
            function ($request) {
                $this->assertEquals('GET', $request->getMethod());
                return new Response(
                    200,
                    [
                        'accept' => 'application/json'
                    ],
                    json_encode(self::sampleCountriesResponse)
                );
            }
        ]);
        $handler = HandlerStack::create($mock);
        $this->mockClient = new Client(['handler' => $handler]);
    }

    public function testFetchCountriesReturnsArrayOfCountries()
    {
        $testService = new Devtestge($this->mockClient);

        $result = $testService->fetchCountries();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('code', $result[0]);
        $this->assertArrayHasKey("en", $result[0]['name']);
        $this->assertArrayHasKey("ka", $result[0]['name']);
    }

    public function testFetchCountriesThrowsExceptionOnFailedRequest()
    {
        $mockResponse = new Response(500, ['content-type' => 'application/json'], 'Server Error');
        $mockHandler = new MockHandler([$mockResponse]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);
        $testService = new Devtestge($mockClient);

        $this->expectException(ServerException::class);
//        $this->req
        $testService->fetchCountries();
    }
}
