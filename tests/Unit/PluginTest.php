<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit;

use Amp\Loop;
use Amp\Success;
use AsyncBot\Core\Logger\Logger;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;
use AsyncBot\Plugin\GitHubStatus\Event\Listener\StatusChange;
use AsyncBot\Plugin\GitHubStatus\Exception\UnexpectedHtmlFormat;
use AsyncBot\Plugin\GitHubStatus\Plugin;
use AsyncBot\Plugin\GitHubStatus\Retriever\Retriever;
use AsyncBot\Plugin\GitHubStatus\Storage\Repository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class PluginTest extends TestCase
{
    private MockObject $psrLogger;

    private MockObject $retriever;

    private MockObject $repository;

    private Plugin $plugin;

    public function setUp(): void
    {
        $this->psrLogger  = $this->createMock(LoggerInterface::class);
        $this->retriever  = $this->createMock(Retriever::class);
        $this->repository = $this->createMock(Repository::class);

        $this->plugin = new Plugin(new Logger($this->psrLogger), $this->retriever, $this->repository);
    }

    public function testRunLogsErrorWhenExceptionIsThrown(): void
    {
        $exception = new UnexpectedHtmlFormat('Overall Status');

        $this->retriever
            ->expects($this->once())
            ->method('retrieve')
            ->willThrowException($exception)
        ;

        $this->psrLogger
            ->expects($this->once())
            ->method('error')
            ->with('Exception', ['exception' => $exception])
        ;

        Loop::run(function () {
            Loop::defer(fn() => Loop::stop());

            yield $this->plugin->run();
        });
    }

    public function testRunReschedulesAfterException(): void
    {
        $this->retriever
            ->expects($this->exactly(2))
            ->method('retrieve')
            ->willThrowException(new UnexpectedHtmlFormat('Overall Status'))
        ;

        $this->psrLogger
            ->expects($this->exactly(2))
            ->method('error')
        ;

        Loop::run(function () {
            Loop::delay(900, fn() => Loop::stop());

            $plugin = new Plugin(new Logger($this->psrLogger), $this->retriever, $this->repository, 500);

            yield $plugin->run();
        });
    }

    public function testOnStatusChangeLogsNewListenerRegistration(): void
    {
        $this->psrLogger
            ->expects($this->once())
            ->method('info')
            ->with('New listener registered')
        ;

        $this->plugin->onStatusChange($this->createMock(StatusChange::class));
    }

    public function testRunDoesNotExecuteListenerWhenThereIsNoPreviousStatusToMatchAgainst(): void
    {
        $status = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->retriever
            ->expects($this->once())
            ->method('retrieve')
            ->willReturn(new Success($status))
        ;

        $this->repository
            ->expects($this->once())
            ->method('hasPreviousStatus')
            ->willReturn(new Success(false))
        ;

        $this->repository
            ->expects($this->once())
            ->method('setStatus')
            ->willReturn(new Success())
        ;

        $listener = $this->createMock(StatusChange::class);

        $listener
            ->expects($this->never())
            ->method('__invoke')
        ;

        $this->plugin->onStatusChange($listener);

        Loop::run(function () {
            Loop::defer(fn() => Loop::stop());

            yield $this->plugin->run();
        });
    }

    public function testRunReschedules(): void
    {
        $status = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->retriever
            ->expects($this->exactly(2))
            ->method('retrieve')
            ->willReturn(new Success($status))
        ;

        $this->repository
            ->expects($this->exactly(2))
            ->method('hasPreviousStatus')
            ->willReturn(new Success(false))
        ;

        $this->repository
            ->expects($this->exactly(2))
            ->method('setStatus')
            ->willReturn(new Success())
        ;

        Loop::run(function () {
            Loop::delay(900, fn() => Loop::stop());

            $plugin = new Plugin(new Logger($this->psrLogger), $this->retriever, $this->repository, 500);

            yield $plugin->run();
        });
    }

    public function testRunDoesNotExecuteListenerWhenNewStatusMatchesThePreviousStatus(): void
    {
        $status = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->retriever
            ->expects($this->once())
            ->method('retrieve')
            ->willReturn(new Success($status))
        ;

        $this->repository
            ->expects($this->once())
            ->method('hasPreviousStatus')
            ->willReturn(new Success(true))
        ;

        $this->repository
            ->expects($this->once())
            ->method('getPreviousStatus')
            ->willReturn(new Success($status))
        ;

        $listener = $this->createMock(StatusChange::class);

        $listener
            ->expects($this->never())
            ->method('__invoke')
        ;

        $this->plugin->onStatusChange($listener);

        Loop::run(function () {
            Loop::defer(fn() => Loop::stop());

            yield $this->plugin->run();
        });
    }

    public function testRunExecutesListener(): void
    {
        $previousStatus = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $newStatus = new Status(
            'Some systems or broken',
            'Operational',
            'Operational',
            'Broken',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->retriever
            ->expects($this->once())
            ->method('retrieve')
            ->willReturn(new Success($newStatus))
        ;

        $this->repository
            ->expects($this->once())
            ->method('hasPreviousStatus')
            ->willReturn(new Success(true))
        ;

        $this->repository
            ->expects($this->once())
            ->method('getPreviousStatus')
            ->willReturn(new Success($previousStatus))
        ;

        $this->repository
            ->expects($this->once())
            ->method('setStatus')
        ;

        $listener = $this->createMock(StatusChange::class);

        $listener
            ->expects($this->once())
            ->method('__invoke')
        ;

        $this->plugin->onStatusChange($listener);

        Loop::run(function () {
            Loop::defer(fn() => Loop::stop());

            yield $this->plugin->run();
        });
    }
}
