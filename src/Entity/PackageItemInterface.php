<?php
declare(strict_types=1);

namespace App\Entity;

interface PackageItemInterface
{
    public function setName(string $name): self;
    public function addEfferent(Efferent $efferent): self;
    public function addAfferent(Afferent $afferent): self;
    public function setFile(string $file): self;
}