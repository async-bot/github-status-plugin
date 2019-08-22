<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit\Event\Data;

use AsyncBot\Plugin\GitHubStatus\Event\Data\ComponentIssue;
use PHPUnit\Framework\TestCase;

final class ComponentIssueTest extends TestCase
{
    private ComponentIssue $issue;

    public function setUp(): void
    {
        $this->issue = new ComponentIssue('Git Operations', 'Something is broken');
    }

    public function testGetName(): void
    {
        $this->assertSame('Git Operations', $this->issue->getName());
    }

    public function testGetIssue(): void
    {
        $this->assertSame('Something is broken', $this->issue->getIssue());
    }
}
