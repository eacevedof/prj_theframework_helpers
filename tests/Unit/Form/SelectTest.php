<?php

declare(strict_types=1);

namespace TheFramework\Helpers\Tests\Unit\Form;

use PHPUnit\Framework\TestCase;
use TheFramework\Helpers\Form\Select;
use TheFramework\Helpers\Enums\HtmlTypeEnum;

final class SelectTest extends TestCase
{
    public function testGetHtmlReturnsValidSelectElement(): void
    {
        $options = ['1' => 'Option 1', '2' => 'Option 2'];
        $select = new Select($options, 'test-select', 'test_select');

        $html = $select->getHtml();

        $this->assertStringContainsString('<' . HtmlTypeEnum::SELECT, $html);
        $this->assertStringContainsString('</' . HtmlTypeEnum::SELECT . '>', $html);
        $this->assertStringContainsString('id="test-select"', $html);
        $this->assertStringContainsString('name="test_select"', $html);
    }

    public function testGetHtmlContainsOptions(): void
    {
        $options = ['a' => 'Alpha', 'b' => 'Beta'];
        $select = new Select($options, 'my-select', 'my_select');

        $html = $select->getHtml();

        $this->assertStringContainsString('<' . HtmlTypeEnum::OPTION, $html);
        $this->assertStringContainsString('value="a"', $html);
        $this->assertStringContainsString('Alpha', $html);
        $this->assertStringContainsString('value="b"', $html);
        $this->assertStringContainsString('Beta', $html);
    }

    public function testGetHtmlWithSelectedValue(): void
    {
        $options = ['1' => 'One', '2' => 'Two'];
        $select = new Select($options, 'sel', 'sel', valueToSelect: '2');

        $html = $select->getHtml();

        $this->assertStringContainsString('value="2" selected', $html);
    }

    public function testGetHtmlWithMultiple(): void
    {
        $options = ['1' => 'One', '2' => 'Two'];
        $select = new Select($options, 'sel', 'sel', isMultiple: true);

        $html = $select->getHtml();

        $this->assertStringContainsString('multiple', $html);
        $this->assertStringContainsString('name="sel[]"', $html);
    }
}
