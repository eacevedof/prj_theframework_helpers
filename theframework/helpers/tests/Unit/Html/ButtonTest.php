<?php

declare(strict_types=1);

namespace TheFramework\Helpers\Tests\Unit\Html;

use PHPUnit\Framework\TestCase;
use TheFramework\Helpers\Html\Button;
use TheFramework\Helpers\Enums\ButtonTypeEnum;
use TheFramework\Helpers\Enums\HtmlTypeEnum;
use TheFramework\Helpers\Tests\Unit\Traits\HtmlAssertionsTrait;

final class ButtonTest extends TestCase
{
    use HtmlAssertionsTrait;

    public function testGetHtmlReturnsValidButtonElement(): void
    {
        $button = new Button('Click me', ButtonTypeEnum::BUTTON, 'btn-test');

        $html = $button->getHtml();

        $this->assertHtmlHasElement($html, HtmlTypeEnum::BUTTON);
        $this->assertHtmlElementHasId($html, HtmlTypeEnum::BUTTON, 'btn-test');
        $this->assertHtmlElementHasType($html, HtmlTypeEnum::BUTTON, ButtonTypeEnum::BUTTON);
        $this->assertHtmlElementContainsText($html, HtmlTypeEnum::BUTTON, 'Click me');
    }

    public function testGetHtmlWithSubmitType(): void
    {
        $button = new Button('Submit', ButtonTypeEnum::SUBMIT);

        $html = $button->getHtml();

        $this->assertHtmlElementHasType($html, HtmlTypeEnum::BUTTON, ButtonTypeEnum::SUBMIT);
    }

    public function testGetHtmlWithResetType(): void
    {
        $button = new Button('Reset', ButtonTypeEnum::RESET);

        $html = $button->getHtml();

        $this->assertHtmlElementHasType($html, HtmlTypeEnum::BUTTON, ButtonTypeEnum::RESET);
    }

    public function testGetHtmlWithDisabled(): void
    {
        $button = new Button('Disabled', ButtonTypeEnum::BUTTON, 'btn-disabled');
        $button->setDisabled();

        $html = $button->getHtml();

        $this->assertHtmlElementIsBooleanAttribute($html, HtmlTypeEnum::BUTTON, 'disabled');
    }

    public function testGetOpenTagReturnsOpeningTag(): void
    {
        $button = new Button('Test', ButtonTypeEnum::BUTTON, 'my-btn');

        $openTag = $button->getOpenTag();

        $this->assertStringStartsWith('<' . HtmlTypeEnum::BUTTON, $openTag);
        $this->assertHtmlElementHasId($openTag . '</' . HtmlTypeEnum::BUTTON . '>', HtmlTypeEnum::BUTTON, 'my-btn');
    }

    public function testGetCloseTagReturnsClosingTag(): void
    {
        $button = new Button();

        $closeTag = $button->getCloseTag();

        $this->assertEquals('</' . HtmlTypeEnum::BUTTON . '>', $closeTag);
    }

    public function testGetHtmlWithCssClass(): void
    {
        $button = new Button('Styled', ButtonTypeEnum::BUTTON, 'btn-styled');
        $button->addClass('btn');
        $button->addClass('btn-primary');

        $html = $button->getHtml();

        $this->assertHtmlElementHasClass($html, HtmlTypeEnum::BUTTON, 'btn');
        $this->assertHtmlElementHasClass($html, HtmlTypeEnum::BUTTON, 'btn-primary');
    }
}
