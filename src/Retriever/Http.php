<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Retriever;

use Amp\Promise;
use AsyncBot\Core\Http\Client;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;
use AsyncBot\Plugin\GitHubStatus\Parser\Html as Parser;
use function Amp\call;

final class Http implements Retriever
{
    private Client $httpClient;

    private Parser $statusParser;

    public function __construct(Client $httpClient, Parser $statusParser)
    {
        $this->httpClient   = $httpClient;
        $this->statusParser = $statusParser;
    }

    /**
     * @return Promise<Status>
     */
    public function retrieve(): Promise
    {
        return call(function () {
            /** @var \DOMDocument $dom */
            $dom = yield $this->httpClient->requestHtml('https://www.githubstatus.com');

            return $this->statusParser->parse($dom);
        });
    }
}
