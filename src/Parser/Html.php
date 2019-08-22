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

        $componentNodes = $xpath->evaluate('(//div[' . xpath_html_class('component-inner-container') . '])');

        return new Status(
            $this->getOverallStatus($xpath),
            $this->getGitOperationsStatus($componentNodes),
            $this->getApiRequestsStatus($componentNodes),
            $this->getIssuesPrsDashboardProjectsStatus($componentNodes),
            $this->getNotificationsStatus($componentNodes),
            $this->getGistsStatus($componentNodes),
            $this->getGitHubPagesStatus($componentNodes),
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
            return $this->getIncidentStatus($xpath);
        }

        return trim($statusElements->item(0)->textContent);
    }

    private function getIncidentStatus(\DOMXPath $xpath): string
    {
        /** @var \DOMNodeList $statusElements */
        $statusElements = $xpath->evaluate('(//div[' . xpath_html_class('unresolved-incident') . ']/div/a[' . xpath_html_class('actual-title with-ellipsis') . '])[1]');

        if ($statusElements->length !== 1) {
            throw new UnexpectedHtmlFormat('Overall Status');
        }

        return trim($statusElements->item(0)->textContent);
    }

    private function getComponentStatus(\DOMNodeList $componentNodes, int $index, string $elementName): string
    {
        $componentNode = $componentNodes->item($index);

        if ($componentNode === null) {
            throw new UnexpectedHtmlFormat($elementName);
        }

        $statusNode = $componentNode->getElementsBytagName('span')->item(2);

        if ($statusNode === null) {
            throw new UnexpectedHtmlFormat($elementName);
        }

        return trim($statusNode->textContent);
    }

    private function getGitOperationsStatus(\DOMNodeList $componentNodes): string
    {
        return $this->getComponentStatus($componentNodes, 0, 'Git Operations');
    }

    private function getApiRequestsStatus(\DOMNodeList $componentNodes): string
    {
        return $this->getComponentStatus($componentNodes, 1, 'API Requests');
    }

    private function getIssuesPrsDashboardProjectsStatus(\DOMNodeList $componentNodes): string
    {
        return $this->getComponentStatus($componentNodes, 2, 'Issues, PRs, Dashboard, Projects');
    }

    private function getNotificationsStatus(\DOMNodeList $componentNodes): string
    {
        return $this->getComponentStatus($componentNodes, 4, 'Notifications');
    }

    private function getGistsStatus(\DOMNodeList $componentNodes): string
    {
        return $this->getComponentStatus($componentNodes, 5, 'Gists');
    }

    private function getGitHubPagesStatus(\DOMNodeList $componentNodes): string
    {
        return $this->getComponentStatus($componentNodes, 6, 'GitHub Pages');
    }
}
