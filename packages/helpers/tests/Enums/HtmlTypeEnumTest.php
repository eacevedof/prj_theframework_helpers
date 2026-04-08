<?php

declare(strict_types=1);

namespace EduardoAf\Helpers\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use EduardoAf\Helpers\Enums\HtmlTypeEnum;

final class HtmlTypeEnumTest extends TestCase
{
    public function testConstantsHaveCorrectValues(): void
    {
        $this->assertEquals('a', HtmlTypeEnum::ANCHOR);
        $this->assertEquals('button', HtmlTypeEnum::BUTTON);
        $this->assertEquals('div', HtmlTypeEnum::DIV);
        $this->assertEquals('form', HtmlTypeEnum::FORM);
        $this->assertEquals('input', HtmlTypeEnum::INPUT);
        $this->assertEquals('label', HtmlTypeEnum::LABEL);
        $this->assertEquals('option', HtmlTypeEnum::OPTION);
        $this->assertEquals('script', HtmlTypeEnum::SCRIPT);
        $this->assertEquals('select', HtmlTypeEnum::SELECT);
        $this->assertEquals('span', HtmlTypeEnum::SPAN);
        $this->assertEquals('table', HtmlTypeEnum::TABLE);
        $this->assertEquals('tbody', HtmlTypeEnum::TBODY);
        $this->assertEquals('td', HtmlTypeEnum::TD);
        $this->assertEquals('textarea', HtmlTypeEnum::TEXTAREA);
        $this->assertEquals('th', HtmlTypeEnum::TH);
        $this->assertEquals('thead', HtmlTypeEnum::THEAD);
        $this->assertEquals('tr', HtmlTypeEnum::TR);
    }
}
