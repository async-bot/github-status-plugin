<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Fakes\HttpClient;

use Amp\ByteStream\InputStream;
use Amp\CancellationToken;
use Amp\Http\Client\ApplicationInterceptor;
use Amp\Http\Client\Client;
use Amp\Http\Client\Request;
use Amp\Http\Client\Response;
use Amp\Promise;
use Amp\Success;
use PHPUnit\Framework\MockObject\Generator;

final class MockResponseInterceptor implements ApplicationInterceptor
{
    private string $body;

    public function __construct(string $body)
    {
        $this->body = $body;
    }

    /**
     * phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     *
     * @return Promise<Response>
     */
    public function request(Request $request, CancellationToken $cancellation, Client $client): Promise
    {
        // phpcs:enable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
        $body = (new Generator())->getMock(InputStream::class);

        $body
            ->method('read')
            ->willReturnOnConsecutiveCalls(new Success($this->body), new Success(null))
        ;

        return new Success(new Response('2.0', 200, 'OK', [], $body, $request));
    }
}
