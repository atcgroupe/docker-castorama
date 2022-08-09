<?php

namespace App\Entity;

interface OrderSignApiInterface
{
    /**
     * Used for Enfocus Switch API
     *
     * @return int
     */
    public function getOrderId(): int;

    /**
     * Returns the XML File name.
     *
     * @return string
     */
    public function getXmlFilename(): string;

    /**
     * Used to know if sign has variable data.
     *
     * @return string
     */
    public function isSignVariable(): string;

    /**
     * Returns the sign name that is used in switch flow.
     *
     * @return string
     */
    public function getSignName(): string;

    /**
     * Returns the Callas pdf template name that is used to generate production file.
     *
     * Note: the name is returned without file extension.
     *
     * @return string
     */
    public function getSwitchTemplateFilename(): string;
}
