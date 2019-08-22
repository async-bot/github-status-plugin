<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Exception;

class UnexpectedHtmlFormat extends Exception
{
    public function __construct(string $element)
    {
        parent::__construct(sprintf('Could not find the "%s" element on the page', $element));
    }
}
