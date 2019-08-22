<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit\Exception;

use AsyncBot\Plugin\GitHubStatus\Exception\Exception;
use PHPUnit\Framework\TestCase;

final class ExceptionTest extends TestCase
{
    public function testPluginExceptionExtendsException(): void
    {
        // phpcs:ignore SlevomatCodingStandard.Exceptions.ReferenceThrowableOnly.ReferencedGeneralException
        $this->expectException(\Exception::class);

        throw new Exception();
    }
}
