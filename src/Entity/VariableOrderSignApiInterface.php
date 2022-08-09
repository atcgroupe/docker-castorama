<?php

namespace App\Entity;

interface VariableOrderSignApiInterface extends OrderSignApiInterface
{
    /**
     * Used for Enfocus Switch API
     *
     * @return string
     */
    public function getData(): string;
}
