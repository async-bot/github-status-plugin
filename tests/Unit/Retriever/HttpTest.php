<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit\Retriever;

use Amp\Http\Client\Client;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;
use AsyncBot\Plugin\GitHubStatus\Parser\Html as Parser;
use AsyncBot\Plugin\GitHubStatus\Retriever\Http;
use AsyncBot\Plugin\GitHubStatusTest\Fakes\HttpClient\MockResponseInterceptor;
use PHPUnit\Framework\TestCase;
use function Amp\Promise\wait;

final class HttpTest extends TestCase
{
    public function testRetrieveReturnNewStatus(): void
    {
        $httpClient = new Client();
        $httpClient->addApplicationInterceptor(new MockResponseInterceptor(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/valid.html')));

        $status = wait((new Http($httpClient, new Parser()))->retrieve());

        $this->assertInstanceOf(Status::class, $status);
    }
}
