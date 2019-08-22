<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Storage;

use Amp\Promise;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;

interface Repository
{
    /**
     * @return Promise<bool>
     */
    public function hasPreviousStatus(): Promise;

    /**
     * @return Promise<Status|null>
     */
    public function getPreviousStatus(): Promise;

    /**
     * @return Promise<null>
     */
    public function setStatus(Status $status): Promise;
}
