<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Retriever;

use Amp\Promise;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;

interface Retriever
{
    /**
     * @return Promise<Status>
     */
    public function retrieve(): Promise;
}
