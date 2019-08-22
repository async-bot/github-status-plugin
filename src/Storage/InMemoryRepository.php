<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Storage;

use Amp\Promise;
use Amp\Success;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;

final class InMemoryRepository implements Repository
{
    private ?Status $previousStatus = null;

    /**
     * @return Promise<bool>
     */
    public function hasPreviousStatus(): Promise
    {
        return new Success($this->previousStatus !== null);
    }

    /**
     * @return Promise<Status|null>
     */
    public function getPreviousStatus(): Promise
    {
        return new Success($this->previousStatus);
    }

    /**
     * @return Promise<null>
     */
    public function setStatus(Status $status): Promise
    {
        $this->previousStatus = $status;

        return new Success();
    }
}
