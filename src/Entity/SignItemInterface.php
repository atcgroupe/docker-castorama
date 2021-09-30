<?php

namespace App\Entity;

interface SignItemInterface
{
    public function getId(): ?int;

    public function getLabel(): ?string;

    public function getIsActive(): ?bool;
}
