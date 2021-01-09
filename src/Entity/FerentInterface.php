<?php
declare(strict_types=1);

namespace App\Entity;

interface FerentInterface
{
    public function setNamespace(string $namespace): self;
    public function setName(string $name): self;
}