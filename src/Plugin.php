<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus;

use Amp\Loop;
use Amp\Promise;
use AsyncBot\Core\Logger\Logger;
use AsyncBot\Core\Plugin\Runnable;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;
use AsyncBot\Plugin\GitHubStatus\Event\Listener\StatusChange as EventListener;
use AsyncBot\Plugin\GitHubStatus\Retriever\Retriever;
use AsyncBot\Plugin\GitHubStatus\Storage\Repository;
use function Amp\call;

final class Plugin implements Runnable
{
    private const DEFAULT_INTERVAL_IN_MS = 30_000;

    private Logger $logger;

    private Retriever $statusRetriever;

    private Repository $repository;

    private int $intervalInMs;

    private array $listeners = [];

    public function __construct(
        Logger $logger,
        Retriever $statusRetriever,
        Repository $repository,
        int $intervalInMs = self::DEFAULT_INTERVAL_IN_MS
    ) {
        $this->logger          = $logger;
        $this->statusRetriever = $statusRetriever;
        $this->repository      = $repository;
        $this->intervalInMs    = $intervalInMs;
    }

    public function onStatusChange(EventListener $listener): void
    {
        $this->logger->registeredListener($this, __METHOD__);

        $this->listeners[] = $listener;
    }

    /**
     * @return Promise<null>
     */
    public function run(): Promise
    {
        return $this->checkForStatusChange();
    }

    /**
     * @return Promise<null>
     */
    private function checkForStatusChange(): Promise
    {
        return call(function () {
            try {
                /** @var Status $status */
                $status = yield $this->getCurrentStatus();
            } catch (\Throwable $e) {
                $this->logger->error('Exception', ['exception' => $e]);

                Loop::delay($this->intervalInMs, fn () => $this->checkForStatusChange());

                return;
            }

            if (yield $this->didStatusChange($status)) {
                array_walk($this->listeners, fn (EventListener $listener) => $listener($status));
            }

            Loop::delay($this->intervalInMs, fn () => $this->checkForStatusChange());
        });
    }

    public function getCurrentStatus(): Promise
    {
        return call(function () {
            return $this->statusRetriever->retrieve();
        });
    }

    /**
     * @return Promise<bool>
     */
    private function didStatusChange(Status $status): Promise
    {
        return call(function () use ($status) {
            if (!yield $this->repository->hasPreviousStatus()) {
                $this->repository->setStatus($status);

                return false;
            }

            if ($status->equals(yield $this->repository->getPreviousStatus())) {
                return false;
            }

            $this->repository->setStatus($status);

            return true;
        });
    }
}
