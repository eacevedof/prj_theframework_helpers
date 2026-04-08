<?php
/**
 * @link eduardoaf.com
 */
namespace EduardoAf\Helpers\Html;

use EduardoAf\Helpers\AbstractHelper;

final class Style extends AbstractHelper
{
    private string $classWarning = "";
    private string $classError = "";
    private string $classSuccess = "";
    private string $classTips = "";
    private string $classDefault = "";
    private string $classInverse = "";

    public function __construct()
    {
        $this->type = "style";
    }

    public function getHtml(): string
    {
        return "";
    }

    public function getOpenTag(): string
    {
        return "<{$this->type}>";
    }

    public function setClassWarning(string $value): void
    {
        $this->classWarning = $value;
    }

    public function setClassError(string $value): void
    {
        $this->classError = $value;
    }

    public function setClassSuccess(string $value): void
    {
        $this->classSuccess = $value;
    }

    public function setClassTips(string $value): void
    {
        $this->classTips = $value;
    }

    public function setClassDefault(string $value): void
    {
        $this->classDefault = $value;
    }

    public function setClassInverse(string $value): void
    {
        $this->classInverse = $value;
    }

    public function getClassWarning(): string
    {
        return $this->classWarning;
    }

    public function getClassError(): string
    {
        return $this->classError;
    }

    public function getClassSuccess(): string
    {
        return $this->classSuccess;
    }

    public function getClassTips(): string
    {
        return $this->classTips;
    }

    public function getClassDefault(): string
    {
        return $this->classDefault;
    }

    public function getClassInverse(): string
    {
        return $this->classInverse;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
