<?php

namespace App\Service\Alert;

class Alert
{
    public const DEFAULT_AUTOHIDE = true;
    public const DEFAULT_DELAY = 3000;
    public const FLASH_TYPE = 'alert';

    public const BASIC = 'basic';
    public const INFO = 'info';
    public const SUCCESS = 'success';
    public const WARNING = 'warning';
    public const DANGER = 'danger';

    /**
     * @var bool
     */
    protected bool $htmlMessage = false;

    public function __construct(
        private string $theme,
        private string $message,
        private ?bool $autoHide = self::DEFAULT_AUTOHIDE,
        private ?int $delay = self::DEFAULT_DELAY,
    ) {
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * @param string|null $theme
     */
    public function setTheme(?string $theme): void
    {
        $this->theme = $theme;
    }

    /**
     * @return int
     */
    public function getDelay(): int
    {
        return $this->delay;
    }

    /**
     * @param int $delay
     */
    public function setDelay(int $delay): void
    {
        $this->delay = $delay;
    }

    /**
     * @return bool
     */
    public function isAutoHide(): bool
    {
        return $this->autoHide;
    }

    /**
     * @param bool $autoHide
     */
    public function setAutoHide(bool $autoHide): void
    {
        $this->autoHide = $autoHide;
    }

    /**
     * @return bool
     */
    public function isHtmlMessage(): bool
    {
        return $this->htmlMessage;
    }
}
