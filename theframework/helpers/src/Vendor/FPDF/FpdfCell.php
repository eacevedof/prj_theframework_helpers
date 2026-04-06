<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Helpers\Vendor\FpdfCell
 */
namespace TheFramework\Helpers\Vendor;

final class FpdfCell
{
    protected bool $isSingle = false;

    protected int $width = 1;
    protected int $height = 1;
    protected string $text = "";
    protected int $border = 0;
    protected int $numNl = 0;
    protected string $align = "";
    protected bool $isFill = false;
    protected string $urlPageLink = "";

    protected ?int $x = null;
    protected ?int $y = null;

    protected ?string $font = null;
    protected ?int $fontColor = null;
    protected ?int $fontSize = null;
    protected ?string $fontStyle = null;
    protected ?int $backColor = null;
    protected bool $isResetColors = false;

    public function __construct(bool $isSingle = false)
    {
        $this->isSingle = $isSingle;
        $this->width = 1;
        $this->height = 1;
        $this->text = "";
        $this->border = 0;
        $this->numNl = 0;
        $this->isFill = false;
        $this->urlPageLink = "";
    }

    public function setYByHeight(): void
    {
    }

    public function setSingle(bool $isOn = true): void
    {
        $this->isSingle = $isOn;
    }

    public function setWidth(int $value): void
    {
        $this->width = $value;
    }

    public function setHeight(int $value): void
    {
        $this->height = $value;
    }

    public function setText(string $value): void
    {
        $this->text = $value;
    }

    public function setBorder(int $width): void
    {
        $this->border = $width;
    }

    public function setNumlineUnit(int $unit): void
    {
        $this->numNl = $unit;
    }

    public function setTypeAlign(string $align): void
    {
        $this->align = $align;
    }

    public function setUsefill(bool $isOn = true): void
    {
        $this->isFill = $isOn;
    }

    public function setPagelink(string $value): void
    {
        $this->urlPageLink = $value;
    }

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }

    public function setFont(string $value): void
    {
        $this->font = $value;
    }

    public function setFontstyle(string $value): void
    {
        $this->fontStyle = $value;
    }

    public function setFontsize(int $size): void
    {
        $this->fontSize = $size;
    }

    public function setFontcolor(int $value): void
    {
        $this->fontColor = $value;
    }

    public function setBackcolor(int $value): void
    {
        $this->backColor = $value;
    }

    public function setResetcolors(bool $isOn = true): void
    {
        $this->isResetColors = $isOn;
    }

    public function isSingle(): bool
    {
        return $this->isSingle;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getBorder(): int
    {
        return $this->border;
    }

    public function getNumlineUnit(): int
    {
        return $this->numNl;
    }

    public function getTypeAlign(): string
    {
        return $this->align;
    }

    public function getUsefill(): bool
    {
        return $this->isFill;
    }

    public function getPagelink(): string
    {
        return $this->urlPageLink;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function getFontstyle(): ?string
    {
        return $this->fontStyle;
    }

    public function getFontsize(): ?int
    {
        return $this->fontSize;
    }

    public function getFontcolor(): ?int
    {
        return $this->fontColor;
    }

    public function getBackcolor(): ?int
    {
        return $this->backColor;
    }

    public function isResetcolors(): bool
    {
        return $this->isResetColors;
    }
}
