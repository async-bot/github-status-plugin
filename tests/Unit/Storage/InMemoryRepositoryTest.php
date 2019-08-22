<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit\Storage;

use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;
use AsyncBot\Plugin\GitHubStatus\Storage\InMemoryRepository;
use PHPUnit\Framework\TestCase;
use function Amp\Promise\wait;

final class InMemoryRepositoryTest extends TestCase
{
    public function testHasPreviousStatusReturnsFalseWhenNoPreviousStatusIsDefined(): void
    {
        $this->assertFalse(wait((new InMemoryRepository())->hasPreviousStatus()));
    }

    public function testHasPreviousStatusReturnsTrueWhenPreviousStatusIsDefined(): void
    {
        $repository = new InMemoryRepository();

        wait($repository->setStatus(
            new Status('global', 'git', 'api', 'issues', 'notifications', 'gists', 'pages'),
        ));

        $this->assertTrue(wait($repository->hasPreviousStatus()));
    }

    public function testGetPreviousStatusReturnsNullWhenNoPreviousStatusIsDefined(): void
    {
        $this->assertNull(wait((new InMemoryRepository())->getPreviousStatus()));
    }

    public function testGetPreviousStatusReturnsStatusWhenPreviousStatusIsDefined(): void
    {
        $repository = new InMemoryRepository();

        wait($repository->setStatus(
            new Status('global', 'git', 'api', 'issues', 'notifications', 'gists', 'pages'),
        ));

        $this->assertInstanceOf(Status::class, wait($repository->getPreviousStatus()));
    }


    public function testSetStatus(): void
    {
        $repository = new InMemoryRepository();

        wait($repository->setStatus(
            new Status('global', 'git', 'api', 'issues', 'notifications', 'gists', 'pages'),
        ));

        $this->assertInstanceOf(Status::class, wait($repository->getPreviousStatus()));
    }
}
