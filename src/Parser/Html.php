<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Parser;

use AsyncBot\Plugin\GitHubStatus\Event\Data\Status;
use AsyncBot\Plugin\GitHubStatus\Exception\UnexpectedHtmlFormat;
use function Room11\DOMUtils\domdocument_load_html;
use function Room11\DOMUtils\xpath_html_class;

final class Html
{
    public function parse(string $html): Status
    {
        $xpath = $this->buildXPathInstance($html);

        return new Status(
            $this->getOverallStatus($xpath),
            $this->getGitOperationsStatus($xpath),
            $this->getApiRequestsStatus($xpath),
            $this->getIssuesPrsDashboardProjectsStatus($xpath),
            $this->getNotificationsStatus($xpath),
            $this->getGistsStatus($xpath),
            $this->getGitHubPagesStatus($xpath),
        );
    }

    private function buildXPathInstance(string $html): \DOMXPath
    {
        $dom = domdocument_load_html($html);

        return new \DOMXPath($dom);
    }

    private function getOverallStatus(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $statusElements */
        $statusElements = $xpath->evaluate('//div[' . xpath_html_class('page-status') . ']/span[' . xpath_html_class('status') . ']');

        if ($statusElements->length !== 1) {
            throw new UnexpectedHtmlFormat('Overall Status');
        }

        return trim($statusElements->item(0)->textContent);
    }

    private function getGitOperationsStatus(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $statusElements */
        $statusElements = $xpath->evaluate('(//span[' . xpath_html_class('component-status') . '])[1]');

        if ($statusElements->length !== 1) {
            throw new UnexpectedHtmlFormat('Git Operations');
        }

        return trim($statusElements->item(0)->textContent);
    }

    private function getApiRequestsStatus(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $statusElements */
        $statusElements = $xpath->evaluate('(//span[' . xpath_html_class('component-status') . '])[2]');

        if ($statusElements->length !== 1) {
            throw new UnexpectedHtmlFormat('API Requests');
        }

        return trim($statusElements->item(0)->textContent);
    }

    private function getIssuesPrsDashboardProjectsStatus(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $statusElements */
        $statusElements = $xpath->evaluate('(//span[' . xpath_html_class('component-status') . '])[3]');

        if ($statusElements->length !== 1) {
            throw new UnexpectedHtmlFormat('Issues, PRs, Dashboard, Projects');
        }

        return trim($statusElements->item(0)->textContent);
    }

    private function getNotificationsStatus(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $statusElements */
        $statusElements = $xpath->evaluate('(//span[' . xpath_html_class('component-status') . '])[4]');

        if ($statusElements->length !== 1) {
            throw new UnexpectedHtmlFormat('Notifications');
        }

        return trim($statusElements->item(0)->textContent);
    }

    private function getGistsStatus(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $statusElements */
        $statusElements = $xpath->evaluate('(//span[' . xpath_html_class('component-status') . '])[5]');

        if ($statusElements->length !== 1) {
            throw new UnexpectedHtmlFormat('Gists');
        }

        return trim($statusElements->item(0)->textContent);
    }

    private function getGitHubPagesStatus(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $statusElements */
        $statusElements = $xpath->evaluate('(//span[' . xpath_html_class('component-status') . '])[6]');

        if ($statusElements->length !== 1) {
            throw new UnexpectedHtmlFormat('GitHub Pages');
        }

        return trim($statusElements->item(0)->textContent);
    }
}
