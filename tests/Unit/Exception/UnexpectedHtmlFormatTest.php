<?php declare(strict_types=1);

namespace AsyncBot\Plugin\GitHubStatusTest\Unit\Exception;

use AsyncBot\Plugin\GitHubStatus\Exception\Exception;
use AsyncBot\Plugin\GitHubStatus\Exception\UnexpectedHtmlFormat;
use PHPUnit\Framework\TestCase;

final class UnexpectedHtmlFormatTest extends TestCase
{
    public function testExceptionExtendsPluginBaseException(): void
    {
        $this->expectException(Exception::class);

        throw new UnexpectedHtmlFormat('element');
    }

    public function testConstructorFormatsMessage(): void
    {
        $this->expectException(UnexpectedHtmlFormat::class);
        $this->expectExceptionMessage('Could not find the "ELEMENT" element on the page');

        throw new UnexpectedHtmlFormat('ELEMENT');
    }
}
