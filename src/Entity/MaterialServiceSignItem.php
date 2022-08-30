<?php

namespace App\Entity;

use App\Repository\MaterialServiceSignItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaterialServiceSignItemRepository::class)
 */
class MaterialServiceSignItem extends AbstractSignItem
{
}
