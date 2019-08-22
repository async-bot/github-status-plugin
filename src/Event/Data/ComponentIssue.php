<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Event\Data;

final class ComponentIssue
{
    private string $name;

    private string $issue;

    public function __construct(string $name, string $issue)
    {
        $this->name  = $name;
        $this->issue = $issue;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIssue(): string
    {
        return $this->issue;
    }
}
