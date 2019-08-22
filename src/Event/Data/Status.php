<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatus\Event\Data;

final class Status
{
    private const NO_INCIDENT_TEXT   = 'All Systems Operational';
    private const NO_COMPONENT_ISSUE = 'Operational';

    private string $overallStatus;

    private string $gitOperationsStatus;

    private string $apiRequestsStatus;

    private string $issuesPrsDashboardProjectsStatus;

    private string $notificationsStatus;

    private string $gistsStatus;

    private string $gitHubPagesStatus;

    public function __construct(
        string $overallStatus,
        string $gitOperationsStatus,
        string $apiRequestsStatus,
        string $issuesPrsDashboardProjectsStatus,
        string $notificationsStatus,
        string $gistsStatus,
        string $gitHubPagesStatus
    ) {
        $this->overallStatus                    = $overallStatus;
        $this->gitOperationsStatus              = $gitOperationsStatus;
        $this->apiRequestsStatus                = $apiRequestsStatus;
        $this->issuesPrsDashboardProjectsStatus = $issuesPrsDashboardProjectsStatus;
        $this->notificationsStatus              = $notificationsStatus;
        $this->gistsStatus                      = $gistsStatus;
        $this->gitHubPagesStatus                = $gitHubPagesStatus;
    }

    public function getOverallStatus(): string
    {
        return $this->overallStatus;
    }

    public function hasActiveIncident(): bool
    {
        return $this->overallStatus !== self::NO_INCIDENT_TEXT;
    }

    public function getGitOperationsStatus(): string
    {
        return $this->gitOperationsStatus;
    }

    public function hasGitOperationsIssues(): bool
    {
        return $this->gitOperationsStatus !== self::NO_COMPONENT_ISSUE;
    }

    public function getApiRequestsStatus(): string
    {
        return $this->apiRequestsStatus;
    }

    public function hasApiRequestsIssues(): bool
    {
        return $this->apiRequestsStatus !== self::NO_COMPONENT_ISSUE;
    }

    public function getIssuesPrsDashboardProjectsStatus(): string
    {
        return $this->issuesPrsDashboardProjectsStatus;
    }

    public function hasIssuesPrsDashboardProjectsIssues(): bool
    {
        return $this->issuesPrsDashboardProjectsStatus !== self::NO_COMPONENT_ISSUE;
    }

    public function getNotificationsStatus(): string
    {
        return $this->notificationsStatus;
    }

    public function hasNotificationsIssues(): bool
    {
        return $this->notificationsStatus !== self::NO_COMPONENT_ISSUE;
    }

    public function getGistsStatus(): string
    {
        return $this->gistsStatus;
    }

    public function hasGistsIssues(): bool
    {
        return $this->gistsStatus !== self::NO_COMPONENT_ISSUE;
    }

    public function getGitHubPagesStatus(): string
    {
        return $this->gitHubPagesStatus;
    }

    public function hasGithubPagesIssues(): bool
    {
        return $this->gitHubPagesStatus !== self::NO_COMPONENT_ISSUE;
    }

    /**
     * @return array<ComponentIssue>
     */
    public function getIssues(): array
    {
        $issues = [];

        if ($this->hasGitOperationsIssues()) {
            $issues[] = new ComponentIssue('Git Operations', $this->gitOperationsStatus);
        }

        if ($this->hasApiRequestsIssues()) {
            $issues[] = new ComponentIssue('API Requests', $this->apiRequestsStatus);
        }

        if ($this->hasIssuesPrsDashboardProjectsIssues()) {
            $issues[] = new ComponentIssue('Issues, PRs, Dashboard, Projects', $this->issuesPrsDashboardProjectsStatus);
        }

        if ($this->hasNotificationsIssues()) {
            $issues[] = new ComponentIssue('Notifications', $this->notificationsStatus);
        }

        if ($this->hasGistsIssues()) {
            $issues[] = new ComponentIssue('Gists', $this->gistsStatus);
        }

        if ($this->hasGithubPagesIssues()) {
            $issues[] = new ComponentIssue('GitHub Pages', $this->gitHubPagesStatus);
        }

        return $issues;
    }

    public function equals(Status $comparand): bool
    {
        if ($this->overallStatus !== $comparand->getOverallStatus()) {
            return false;
        }

        if ($this->gitOperationsStatus !== $comparand->getGitOperationsStatus()) {
            return false;
        }

        if ($this->apiRequestsStatus !== $comparand->getApiRequestsStatus()) {
            return false;
        }

        if ($this->issuesPrsDashboardProjectsStatus !== $comparand->getIssuesPrsDashboardProjectsStatus()) {
            return false;
        }

        if ($this->notificationsStatus !== $comparand->getNotificationsStatus()) {
            return false;
        }

        if ($this->gistsStatus !== $comparand->getGistsStatus()) {
            return false;
        }

        if ($this->gitHubPagesStatus !== $comparand->getGitHubPagesStatus()) {
            return false;
        }

        return true;
    }
}
