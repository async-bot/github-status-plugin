<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Event\Listener;

use Amp\Promise;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;

interface StatusChange
{
    /**
     * @return Promise<null>
     */
    public function __invoke(Status $status): Promise;
}
