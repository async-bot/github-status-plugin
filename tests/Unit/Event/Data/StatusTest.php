<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit\Event\Data;

use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;
use AsyncBot\Plugin\GitHubStatus\ValueObject\ComponentIssue;
use PHPUnit\Framework\TestCase;

final class StatusTest extends TestCase
{
    private Status $noIssues;

    public function setUp(): void
    {
        $this->noIssues = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );
    }

    public function testGetGlobalStatus(): void
    {
        $this->assertSame('All Systems Operational', $this->noIssues->getOverallStatus());
    }

    public function testHasIncidentReturnsFalseWhenNoIncidentIsActive(): void
    {
        $this->assertFalse($this->noIssues->hasActiveIncident());
    }

    public function testHasIncidentReturnsTrueWhenAnIncidentIsActive(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->assertTrue($status->hasActiveIncident());
    }

    public function testGetGitOperations(): void
    {
        $this->assertSame('Operational', $this->noIssues->getGitOperationsStatus());
    }

    public function testHasGitOperationsIssuesReturnsFalseWhenNoIncidentIsActive(): void
    {
        $this->assertFalse($this->noIssues->hasGitOperationsIssues());
    }

    public function testHasGitOperationsIssuesReturnsTrueWhenAnIncidentIsActive(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Broken',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->assertTrue($status->hasGitOperationsIssues());
    }

    public function testGetApiRequests(): void
    {
        $this->assertSame('Operational', $this->noIssues->getApiRequestsStatus());
    }

    public function testHasApiRequestsIssuesReturnsFalseWhenNoIncidentIsActive(): void
    {
        $this->assertFalse($this->noIssues->hasApiRequestsIssues());
    }

    public function testHasApiRequestsIssuesReturnsTrueWhenAnIncidentIsActive(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Operational',
            'Broken',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->assertTrue($status->hasApiRequestsIssues());
    }

    public function testGetIssuesPrsDashboardProjects(): void
    {
        $this->assertSame('Operational', $this->noIssues->getIssuesPrsDashboardProjectsStatus());
    }

    public function testHasIssuesPrsDashboardProjectsIssuesReturnsFalseWhenNoIncidentIsActive(): void
    {
        $this->assertFalse($this->noIssues->hasIssuesPrsDashboardProjectsIssues());
    }

    public function testHasIssuesPrsDashboardProjectsIssuesReturnsTrueWhenAnIncidentIsActive(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Operational',
            'Operational',
            'Broken',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->assertTrue($status->hasIssuesPrsDashboardProjectsIssues());
    }

    public function testGetNotifications(): void
    {
        $this->assertSame('Operational', $this->noIssues->getNotificationsStatus());
    }

    public function testHasNotificationsIssuesReturnsFalseWhenNoIncidentIsActive(): void
    {
        $this->assertFalse($this->noIssues->hasNotificationsIssues());
    }

    public function testHasNotificationsIssuesReturnsTrueWhenAnIncidentIsActive(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Operational',
            'Operational',
            'Operational',
            'Broken',
            'Operational',
            'Operational',
        );

        $this->assertTrue($status->hasNotificationsIssues());
    }

    public function testGetGists(): void
    {
        $this->assertSame('Operational', $this->noIssues->getGistsStatus());
    }

    public function testHasGistsIssuesReturnsFalseWhenNoIncidentIsActive(): void
    {
        $this->assertFalse($this->noIssues->hasGistsIssues());
    }

    public function testHasGistsIssuesReturnsTrueWhenAnIncidentIsActive(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Broken',
            'Operational',
        );

        $this->assertTrue($status->hasGistsIssues());
    }

    public function testGetGithubPages(): void
    {
        $this->assertSame('Operational', $this->noIssues->getGitHubPagesStatus());
    }

    public function testHasGithubPagesIssuesReturnsFalseWhenNoIncidentIsActive(): void
    {
        $this->assertFalse($this->noIssues->hasGistsIssues());
    }

    public function testHasGithubPagesIssuesReturnsTrueWhenAnIncidentIsActive(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Broken',
        );

        $this->assertTrue($status->hasGithubPagesIssues());
    }

    public function testGetIssuesReturnsEmptyArrayWhenThereAreNoIssues(): void
    {
        $this->assertEmpty($this->noIssues->getIssues());
    }

    public function testGetIssuesReturnsArrayWithIssues(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Broken',
            'Broken',
            'Broken',
            'Broken',
            'Broken',
            'Broken',
        );

        $this->assertCount(6, $status->getIssues());
    }

    public function testGetIssuesReturnsArrayWithCorrectlyNamesIssues(): void
    {
        $status = new Status(
            'Some systems are broken',
            'Broken1',
            'Broken2',
            'Broken3',
            'Broken4',
            'Broken5',
            'Broken6',
        );

        $expectedIssues = [
            ['name' => 'Git Operations', 'issue' => 'Broken1'],
            ['name' => 'API Requests', 'issue' => 'Broken2'],
            ['name' => 'Issues, PRs, Dashboard, Projects', 'issue' => 'Broken3'],
            ['name' => 'Notifications', 'issue' => 'Broken4'],
            ['name' => 'Gists', 'issue' => 'Broken5'],
            ['name' => 'GitHub Pages', 'issue' => 'Broken6'],
        ];

        /** @var ComponentIssue $issue */
        foreach ($status->getIssues() as $index => $issue) {
            $this->assertSame($expectedIssues[$index]['name'], $issue->getName());
            $this->assertSame($expectedIssues[$index]['issue'], $issue->getIssue());
        }
    }

    public function testEqualsReturnTrueWhenBothStatusesAreEqual(): void
    {
        $this->assertTrue($this->noIssues->equals($this->noIssues));
    }

    public function testEqualsReturnFalseWhenGlobalStatusDoesNotMatch(): void
    {
        $comparand = new Status(
            'Some systems are broken',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->assertFalse($this->noIssues->equals($comparand));
    }

    public function testEqualsReturnFalseWhenGitOperationsStatusDoesNotMatch(): void
    {
        $comparand = new Status(
            'All Systems Operational',
            'Broken',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->assertFalse($this->noIssues->equals($comparand));
    }

    public function testEqualsReturnFalseWhenApiRequestsStatusDoesNotMatch(): void
    {
        $comparand = new Status(
            'All Systems Operational',
            'Operational',
            'Broken',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->assertFalse($this->noIssues->equals($comparand));
    }

    public function testEqualsReturnFalseWhenIssuesPrsDashboardProjectsStatusDoesNotMatch(): void
    {
        $comparand = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Broken',
            'Operational',
            'Operational',
            'Operational',
        );

        $this->assertFalse($this->noIssues->equals($comparand));
    }

    public function testEqualsReturnFalseWhenNotificationsStatusDoesNotMatch(): void
    {
        $comparand = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Operational',
            'Broken',
            'Operational',
            'Operational',
        );

        $this->assertFalse($this->noIssues->equals($comparand));
    }

    public function testEqualsReturnFalseWhenGistsStatusDoesNotMatch(): void
    {
        $comparand = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Broken',
            'Operational',
        );

        $this->assertFalse($this->noIssues->equals($comparand));
    }

    public function testEqualsReturnFalseWhenGitHubPagesStatusDoesNotMatch(): void
    {
        $comparand = new Status(
            'All Systems Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Operational',
            'Broken',
        );

        $this->assertFalse($this->noIssues->equals($comparand));
    }
}
