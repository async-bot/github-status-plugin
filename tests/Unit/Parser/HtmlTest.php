<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit\Parser;

use AsyncBot\Plugin\GitHubStatus\Event\Data\ComponentIssue;
use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;
use AsyncBot\Plugin\GitHubStatus\Exception\UnexpectedHtmlFormat;
use AsyncBot\Plugin\GitHubStatus\Parser\Html;
use PHPUnit\Framework\TestCase;

final class HtmlTest extends TestCase
{
    public function testParseThrowsWhenGlobalStatusElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Overall Status" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-overall-status-element.html'))
        ;
    }

    public function testParseReturnsCorrectGlobalStatus(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/valid.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertSame('All Systems Operational', $status->getOverallStatus());
    }

    public function testParseThrowsWhenGitOperationsComponentElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Git Operations" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-git-operations-component-element.html'))
        ;
    }

    public function testParseThrowsWhenGitOperationsStatusElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Git Operations" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-git-operations-status-element.html'))
        ;
    }

    public function testParseReturnsCorrectGitOperationsStatus(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/valid.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertSame('Operational', $status->getGitOperationsStatus());
    }

    public function testParseThrowsWhenApiRequestsComponentElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "API Requests" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-api-requests-component-element.html'))
        ;
    }

    public function testParseThrowsWhenApiRequestsStatusElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "API Requests" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-api-requests-status-element.html'))
        ;
    }

    public function testParseReturnsCorrectApiRequestsStatus(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/valid.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertSame('Operational', $status->getApiRequestsStatus());
    }

    public function testParseThrowsWhenIssuesPrsDashboardProjectsComponentElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Issues, PRs, Dashboard, Projects" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-issues-prs-dashboard-projects-component-element.html'))
        ;
    }

    public function testParseThrowsWhenIssuesPrsDashboardProjectsStatusElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Issues, PRs, Dashboard, Projects" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-issues-prs-dashboard-projects-status-element.html'))
        ;
    }

    public function testParseReturnsCorrectIssuesPrsDashboardProjectsStatus(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/valid.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertSame('Operational', $status->getIssuesPrsDashboardProjectsStatus());
    }

    public function testParseThrowsWhenNotificationsComponentElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Notifications" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-notifications-component-element.html'))
        ;
    }

    public function testParseThrowsWhenNotificationsStatusElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Notifications" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-notifications-status-element.html'))
        ;
    }

    public function testParseReturnsCorrectNotificationsStatus(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/valid.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertSame('Operational', $status->getNotificationsStatus());
    }

    public function testParseThrowsWhenGistsStatusComponentCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Gists" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-gists-component-element.html'))
        ;
    }

    public function testParseThrowsWhenGistsStatusElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "Gists" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-gists-status-element.html'))
        ;
    }

    public function testParseReturnsCorrectGistsStatus(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/valid.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertSame('Operational', $status->getGistsStatus());
    }

    public function testParseThrowsWhenGitHubPagesComponentCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "GitHub Pages" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-github-pages-component-element.html'))
        ;
    }

    public function testParseThrowsWhenGitHubPagesStatusElementCanNotBeFound(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "GitHub Pages" element on the page');

        (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-github-pages-status-element.html'))
        ;
    }

    public function testParseReturnsCorrectGitHubPagesStatus(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/valid.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertSame('Operational', $status->getGitHubPagesStatus());
    }

    public function testParseReturnsCorrectStatusWhenServiceIsPartiallyDegraded(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/partially-degraded-service.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertTrue($status->hasActiveIncident());
        $this->assertSame('Partially Degraded Service', $status->getOverallStatus());

        $this->assertCount(1, $status->getIssues());

        /** @var ComponentIssue $issue */
        $issue = $status->getIssues()[0];

        $this->assertSame('Notifications', $issue->getName());
        $this->assertSame('Degraded Performance', $issue->getIssue());
    }

    public function testParseReturnCorrectStatusOnIncident(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/incident.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertTrue($status->hasActiveIncident());
        $this->assertSame('Incident on 2019-08-22 10:59 UTC', $status->getOverallStatus());

        $this->assertCount(2, $status->getIssues());

        /** @var ComponentIssue $issue */
        $issue = $status->getIssues()[0];

        $this->assertSame('Issues, PRs, Dashboard, Projects', $issue->getName());
        $this->assertSame('Major Outage', $issue->getIssue());

        /** @var ComponentIssue $issue */
        $issue = $status->getIssues()[1];

        $this->assertSame('Notifications', $issue->getName());
        $this->assertSame('Major Outage', $issue->getIssue());
    }

    public function testParseReturnCorrectStatusOnIncidentWithAnUpdate(): void
    {
        $status = (new Html())
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/incident-with-update.html'))
        ;

        $this->assertInstanceOf(Status::class, $status);
        $this->assertTrue($status->hasActiveIncident());
        $this->assertSame('Incident on 2019-08-22 10:59 UTC', $status->getOverallStatus());

        $this->assertCount(2, $status->getIssues());

        /** @var ComponentIssue $issue */
        $issue = $status->getIssues()[0];

        $this->assertSame('Issues, PRs, Dashboard, Projects', $issue->getName());
        $this->assertSame('Major Outage', $issue->getIssue());

        /** @var ComponentIssue $issue */
        $issue = $status->getIssues()[1];

        $this->assertSame('Notifications', $issue->getName());
        $this->assertSame('Major Outage', $issue->getIssue());
    }
}
