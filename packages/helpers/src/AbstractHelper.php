<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link eduardoaf.com
 * @name TheFramework\Helpers\AbstractHelper
 */
namespace TheFramework\Helpers;

use TheFramework\Helpers\Form\Label;
use TheFramework\Helpers\Html\Style;

abstract class AbstractHelper implements InterfaceHelper
{
    protected string $comment = "";
    protected string $type = "";
    protected string $id = "";
    protected string $name = "";
    protected string $idPrefix = "";
    protected string $maxLength = "";
    protected string $placeholder = "";
    protected string $class = "";
    protected string $style = "";

    protected string $innerHtml = "";
    protected array $extras = [];
    protected bool $display = true;

    protected array $classes = [];
    protected array $styles = [];
    protected array $innerHelpers = [];
    protected mixed $value = "";

    protected bool $readonly = false;
    protected bool $required = false;
    protected bool $disabled = false;
    protected bool $isRequired = false;
    protected bool $isPrimaryKey = false;

    protected string $jsOnClick = "";
    protected string $jsOnChange = "";
    protected string $jsOnKeypress = "";
    protected string $jsOnKeydown = "";
    protected string $jsOnKeyup = "";

    protected string $jsOnBlur = "";
    protected string $jsOnFocus = "";
    protected string $jsOnMouseover = "";
    protected string $jsOnMouseout = "";

    protected ?Label $label = null;
    protected ?Style $styleObject = null;

    protected string $attrDbfield = "";
    protected string $attrDbtype = "";

    protected function loadCssClass(): self
    {
        if ($this->classes) {
            $this->class = trim(implode(" ", $this->classes));
        }
        return $this;
    }

    protected function loadStyle(): self
    {
        if ($this->styles) {
            $this->style = trim(implode(";", $this->styles));
        }
        return $this;
    }

    protected function loadInnerObjects(): self
    {
        $innerParts = [];
        foreach ($this->innerHelpers as $innerValue) {
            if (is_object($innerValue) && method_exists($innerValue, "getHtml")) {
                if ($this->readonly && method_exists($innerValue, "setReadonly")) {
                    $innerValue->setReadonly();
                }
                $innerParts[] = $innerValue->getHtml();
            }
            elseif (is_string($innerValue)) {
                $innerParts[] = $innerValue;
            }
        }
        if ($innerParts) {
            $this->innerHtml .= implode("", $innerParts);
        }
        return $this;
    }

    public function show(): void
    {
        if ($this->display) {
            echo $this->getHtml();
        }
    }

    public function setComment(string $value): self
    {
        $this->comment = $value;
        return $this;
    }

    public function setIdPrefix(string $value): self
    {
        $this->idPrefix = $value;
        return $this;
    }

    public function setId(string $value): self
    {
        $this->id = $value;
        return $this;
    }

    public function setDisplay(bool $display = true): self
    {
        $this->display = $display;
        return $this;
    }

    public function setRequired(bool $required = true): self
    {
        $this->required = $required;
        $this->isRequired = $required;
        return $this;
    }

    public function setReadonly(bool $readonly = true): self
    {
        $this->readonly = $readonly;
        return $this;
    }

    public function setDisabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    public function setOnClick(string $jsCode): self
    {
        $this->jsOnClick = $jsCode;
        return $this;
    }

    public function setOnChange(string $jsCode): self
    {
        $this->jsOnChange = $jsCode;
        return $this;
    }

    public function setOnKeypress(string $jsCode): self
    {
        $this->jsOnKeypress = $jsCode;
        return $this;
    }

    public function setOnKeydown(string $jsCode): self
    {
        $this->jsOnKeydown = $jsCode;
        return $this;
    }

    public function setOnKeyup(string $jsCode): self
    {
        $this->jsOnKeyup = $jsCode;
        return $this;
    }

    public function setOnBlur(string $jsCode): self
    {
        $this->jsOnBlur = $jsCode;
        return $this;
    }

    public function setOnFocus(string $jsCode): self
    {
        $this->jsOnFocus = $jsCode;
        return $this;
    }

    public function setOnMouseover(string $jsCode): self
    {
        $this->jsOnMouseover = $jsCode;
        return $this;
    }

    public function setOnMouseout(string $jsCode): self
    {
        $this->jsOnMouseout = $jsCode;
        return $this;
    }

    public function addClass(string $class): self
    {
        if ($class) {
            $this->classes[] = $class;
        }
        return $this;
    }

    public function setStyle(string $style): self
    {
        $this->styles = [];
        if ($style) {
            $this->styles[] = $style;
        }
        return $this;
    }

    public function addStyle(string $style): self
    {
        if ($style) {
            $this->styles[] = $style;
        }
        return $this;
    }

    public function addInnerHelper(InterfaceHelper|string $innerValue): self
    {
        if ($innerValue) {
            $this->innerHelpers[] = $innerValue;
        }
        return $this;
    }

    public function setExtras(array $extras): self
    {
        $this->extras = $extras;
        return $this;
    }

    public function addExtras(string $attr, string $value = ""): self
    {
        if ($attr) {
            $this->extras[$attr] = $value;
        } else {
            $this->extras[] = $value;
        }
        return $this;
    }

    public function setPlaceholder(string $value): self
    {
        $this->placeholder = htmlentities($value);
        return $this;
    }

    public function setInnerHtml(string $innerHtml, bool $rawMode = true): self
    {
        $this->innerHtml = $rawMode ? $innerHtml : htmlentities($innerHtml);
        return $this;
    }

    public function setType(string $value): self
    {
        $this->type = $value;
        return $this;
    }

    protected function setName(string $value): self
    {
        $this->name = $value;
        return $this;
    }

    public function setLabel(Label $label): void
    {
        $this->label = $label;
    }

    public function setClass(string $class): self
    {
        $this->classes = [];
        if ($class) {
            $this->classes[] = $class;
        }
        return $this;
    }

    public function setStyleObject(Style $styleObject): self
    {
        $this->styleObject = $styleObject;
        return $this;
    }

    public function resetClass(): void
    {
        $this->classes = [];
        $this->class = "";
    }

    public function resetStyle(): void
    {
        $this->styles = [];
        $this->style = "";
    }

    public function resetInnerHelpers(): self
    {
        $this->innerHelpers = [];
        return $this;
    }

    public function setValue(mixed $value, bool $rawMode = true): self
    {
        $this->value = $rawMode ? htmlentities((string) $value) : $value;
        return $this;
    }

    protected function getEscapedQuot(mixed $value): string
    {
        return str_replace("\"", "&quot;", (string) $value);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getExtras(bool $asString = true): array|string
    {
        if (!$asString) {
            return $this->extras;
        }
        $extrasArray = [];
        foreach ($this->extras as $attr => $value) {
            if (!is_integer($attr)) {
                $extrasArray[] = "{$attr}=\"{$value}\"";
                continue;
            }
            if (strstr($value, "=")) {
                $extrasArray[] = $value;
            }
            elseif ($value !== null) {
                $extrasArray[] = "{$attr}=\"{$value}\"";
            }
            else {
                $extrasArray[] = $attr;
            }
        }
        return implode(" ", $extrasArray);
    }

    public function getInnerHtml(): string
    {
        return $this->innerHtml;
    }

    protected function isDisabled(): bool
    {
        return $this->disabled;
    }

    protected function getName(): string
    {
        return $this->name;
    }

    public abstract function getOpenTag(): string;

    protected function getCloseTag(): string
    {
        return "</{$this->type}>\n";
    }

    protected function showOpenTag(): void
    {
        echo $this->getOpenTag();
    }

    protected function showCloseTag(): void
    {
        echo $this->getCloseTag();
    }

    protected function getLabel(): ?Label
    {
        return $this->label;
    }

    protected function getStyleObject(): ?Style
    {
        return $this->styleObject;
    }

    protected function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    protected function getValue(bool $rawMode = true): mixed
    {
        return $rawMode ? $this->value : htmlentities((string) $this->value);
    }
}
