<?php

declare(strict_types=1);

namespace TheFramework\Helpers\Tests\Unit\Form;

use PHPUnit\Framework\TestCase;
use TheFramework\Helpers\Form\Select;
use TheFramework\Helpers\Enums\HtmlTypeEnum;
use TheFramework\Helpers\Tests\Unit\Traits\HtmlAssertionsTrait;

final class SelectTest extends TestCase
{
    use HtmlAssertionsTrait;

    public function testGetHtmlReturnsValidSelectElement(): void
    {
        $options = ['1' => 'Option 1', '2' => 'Option 2'];
        $select = new Select($options, 'test-select', 'test_select');

        $html = $select->getHtml();

        $this->assertHtmlHasElement($html, HtmlTypeEnum::SELECT);
        $this->assertHtmlElementHasId($html, HtmlTypeEnum::SELECT, 'test-select');
        $this->assertHtmlElementHasName($html, HtmlTypeEnum::SELECT, 'test_select');
    }

    public function testGetHtmlContainsCorrectNumberOfOptions(): void
    {
        $options = ['a' => 'Alpha', 'b' => 'Beta', 'c' => 'Gamma'];
        $select = new Select($options, 'my-select', 'my_select');

        $html = $select->getHtml();

        $this->assertHtmlHasElementCount($html, HtmlTypeEnum::OPTION, 3);
    }

    public function testGetHtmlOptionsHaveCorrectValues(): void
    {
        $options = ['val1' => 'Text 1', 'val2' => 'Text 2'];
        $select = new Select($options, 'sel', 'sel');

        $html = $select->getHtml();

        $this->assertHtmlHasElement($html, HtmlTypeEnum::OPTION);
        $this->assertStringContainsString('value="val1"', $html);
        $this->assertStringContainsString('value="val2"', $html);
        $this->assertStringContainsString('Text 1', $html);
        $this->assertStringContainsString('Text 2', $html);
    }

    public function testGetHtmlWithSelectedValue(): void
    {
        $options = ['1' => 'One', '2' => 'Two', '3' => 'Three'];
        $select = new Select($options, 'sel', 'sel', valueToSelect: '2');

        $html = $select->getHtml();

        $this->assertHtmlOptionSelected($html, '2');
    }

    public function testGetHtmlWithMultiple(): void
    {
        $options = ['1' => 'One', '2' => 'Two'];
        $select = new Select($options, 'sel', 'sel', isMultiple: true);

        $html = $select->getHtml();

        $this->assertHtmlElementIsBooleanAttribute($html, HtmlTypeEnum::SELECT, 'multiple');
        $this->assertHtmlElementHasName($html, HtmlTypeEnum::SELECT, 'sel[]');
    }

    public function testGetHtmlWithSize(): void
    {
        $options = ['1' => 'One', '2' => 'Two'];
        $select = new Select($options, 'sel', 'sel', size: 5);

        $html = $select->getHtml();

        $this->assertHtmlElementHasAttribute($html, HtmlTypeEnum::SELECT, 'size', '5');
    }

    public function testGetHtmlWithDisabled(): void
    {
        $options = ['1' => 'One'];
        $select = new Select($options, 'sel', 'sel');
        $select->setDisabled();

        $html = $select->getHtml();

        $this->assertHtmlElementIsBooleanAttribute($html, HtmlTypeEnum::SELECT, 'disabled');
    }

    public function testGetHtmlWithRequired(): void
    {
        $options = ['1' => 'One'];
        $select = new Select($options, 'sel', 'sel');
        $select->setRequired();

        $html = $select->getHtml();

        $this->assertHtmlElementIsBooleanAttribute($html, HtmlTypeEnum::SELECT, 'required');
    }

    public function testGetHtmlWithCssClass(): void
    {
        $options = ['1' => 'One'];
        $select = new Select($options, 'sel', 'sel', class: 'form-control');

        $html = $select->getHtml();

        $this->assertHtmlElementHasClass($html, HtmlTypeEnum::SELECT, 'form-control');
    }
}
