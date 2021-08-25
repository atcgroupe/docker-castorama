<?php

namespace App\Service\Alert;

class HtmlAlert extends Alert
{
    public function __construct(
        string $theme,
        string $message,
        ?bool $autoHide = self::DEFAULT_AUTOHIDE,
        ?int $delay = self::DEFAULT_DELAY
    ) {
        parent::__construct($theme, $message, $autoHide, $delay);

        $this->htmlMessage = true;
    }
}
