<?php

declare(strict_types=1);

namespace TheFramework\Helpers\Tests\Unit\Traits;

use DOMDocument;
use DOMElement;
use DOMXPath;

trait HtmlAssertionsTrait
{
    protected function assertHtmlHasElement(string $html, string $tagName, string $message = ''): void
    {
        $doc = $this->parseHtml($html);
        $elements = $doc->getElementsByTagName($tagName);
        $this->assertGreaterThan(0, $elements->length, $message ?: "Expected element <{$tagName}> not found");
    }

    protected function assertHtmlElementHasAttribute(
        string $html,
        string $tagName,
        string $attribute,
        ?string $expectedValue = null,
        string $message = ''
    ): void {
        $element = $this->getFirstElement($html, $tagName);
        $this->assertNotNull($element, "Element <{$tagName}> not found");
        $this->assertTrue($element->hasAttribute($attribute), $message ?: "Attribute '{$attribute}' not found on <{$tagName}>");

        if ($expectedValue !== null) {
            $this->assertEquals(
                $expectedValue,
                $element->getAttribute($attribute),
                $message ?: "Attribute '{$attribute}' value mismatch"
            );
        }
    }

    protected function assertHtmlElementHasId(string $html, string $tagName, string $expectedId): void
    {
        $this->assertHtmlElementHasAttribute($html, $tagName, 'id', $expectedId);
    }

    protected function assertHtmlElementHasName(string $html, string $tagName, string $expectedName): void
    {
        $this->assertHtmlElementHasAttribute($html, $tagName, 'name', $expectedName);
    }

    protected function assertHtmlElementHasType(string $html, string $tagName, string $expectedType): void
    {
        $this->assertHtmlElementHasAttribute($html, $tagName, 'type', $expectedType);
    }

    protected function assertHtmlElementHasClass(string $html, string $tagName, string $expectedClass): void
    {
        $element = $this->getFirstElement($html, $tagName);
        $this->assertNotNull($element, "Element <{$tagName}> not found");

        $classes = explode(' ', $element->getAttribute('class'));
        $this->assertContains($expectedClass, $classes, "Class '{$expectedClass}' not found on <{$tagName}>");
    }

    protected function assertHtmlElementContainsText(string $html, string $tagName, string $expectedText): void
    {
        $element = $this->getFirstElement($html, $tagName);
        $this->assertNotNull($element, "Element <{$tagName}> not found");
        $this->assertStringContainsString($expectedText, $element->textContent);
    }

    protected function assertHtmlElementIsBooleanAttribute(string $html, string $tagName, string $attribute): void
    {
        $element = $this->getFirstElement($html, $tagName);
        $this->assertNotNull($element, "Element <{$tagName}> not found");
        $this->assertTrue(
            $element->hasAttribute($attribute),
            "Boolean attribute '{$attribute}' not found on <{$tagName}>"
        );
    }

    protected function assertHtmlHasElementCount(string $html, string $tagName, int $expectedCount): void
    {
        $doc = $this->parseHtml($html);
        $elements = $doc->getElementsByTagName($tagName);
        $this->assertEquals($expectedCount, $elements->length, "Expected {$expectedCount} <{$tagName}> elements");
    }

    protected function assertHtmlOptionSelected(string $html, string $value): void
    {
        $doc = $this->parseHtml($html);
        $xpath = new DOMXPath($doc);
        $options = $xpath->query("//option[@value='{$value}']");

        $this->assertGreaterThan(0, $options->length, "Option with value '{$value}' not found");

        $option = $options->item(0);
        $this->assertTrue(
            $option->hasAttribute('selected'),
            "Option with value '{$value}' is not selected"
        );
    }

    protected function getFirstElement(string $html, string $tagName): ?DOMElement
    {
        $doc = $this->parseHtml($html);
        $elements = $doc->getElementsByTagName($tagName);

        if ($elements->length === 0) {
            return null;
        }

        $element = $elements->item(0);
        return $element instanceof DOMElement ? $element : null;
    }

    protected function parseHtml(string $html): DOMDocument
    {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML("<html><body>{$html}</body></html>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        return $doc;
    }
}
