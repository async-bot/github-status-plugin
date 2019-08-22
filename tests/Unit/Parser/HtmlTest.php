<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit\Parser;

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
            ->parse(file_get_contents(TEST_DATA_DIR . '/ResponseHtml/missing-global-status-element.html'))
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
        $this->assertSame('Operational', $status->getApiRequestsStatus());
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
        $this->assertSame('Operational', $status->getApiRequestsStatus());
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
        $this->assertSame('Operational', $status->getApiRequestsStatus());
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
        $this->assertSame('Operational', $status->getApiRequestsStatus());
    }
}
