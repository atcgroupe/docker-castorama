<?php

namespace App\Entity;

interface FixedOrderSignApiInterface extends OrderSignApiInterface
{
    /**
     * Returns the production file name for Enfocus Switch flow
     *
     * @return string
     */
    public function getProductionFilename(): string;
}
