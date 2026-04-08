<?php

declare(strict_types=1);

namespace EduardoAf\Helpers\Tests\Unit\Html;

use PHPUnit\Framework\TestCase;
use EduardoAf\Helpers\Html\Button;
use EduardoAf\Helpers\Enums\ButtonTypeEnum;
use EduardoAf\Helpers\Enums\HtmlTypeEnum;

final class ButtonTest extends TestCase
{
    public function testGetHtmlReturnsValidButtonElement(): void
    {
        $button = new Button('Click me', ButtonTypeEnum::BUTTON, 'btn-test');

        $html = $button->getHtml();

        $this->assertStringContainsString('<' . HtmlTypeEnum::BUTTON, $html);
        $this->assertStringContainsString('</' . HtmlTypeEnum::BUTTON . '>', $html);
        $this->assertStringContainsString('Click me', $html);
        $this->assertStringContainsString('id="btn-test"', $html);
        $this->assertStringContainsString('type="button"', $html);
    }

    public function testGetHtmlWithSubmitType(): void
    {
        $button = new Button('Submit', ButtonTypeEnum::SUBMIT);

        $html = $button->getHtml();

        $this->assertStringContainsString('type="submit"', $html);
    }

    public function testGetOpenTagReturnsOpeningTag(): void
    {
        $button = new Button('Test', ButtonTypeEnum::BUTTON, 'my-btn');

        $openTag = $button->getOpenTag();

        $this->assertStringStartsWith('<' . HtmlTypeEnum::BUTTON, $openTag);
        $this->assertStringContainsString('id="my-btn"', $openTag);
    }

    public function testGetCloseTagReturnsClosingTag(): void
    {
        $button = new Button();

        $closeTag = $button->getCloseTag();

        $this->assertEquals('</' . HtmlTypeEnum::BUTTON . '>', $closeTag);
    }
}
