<?php
declare(strict_types=1);

namespace App\Entity;

abstract class PackageItem implements PackageItemInterface
{
    protected string $name = '';
    protected array $efferents = [];
    protected array $afferents = [];
    protected string $file = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEfferents(): array
    {
        return $this->efferents;
    }

    public function addEfferent(Efferent $efferent): self
    {
        $this->efferents[] = $efferent;

        return $this;
    }

    public function getAfferents(): array
    {
        return $this->afferents;
    }

    public function addAfferent(Afferent $afferent): self
    {
        $this->afferents[] = $afferent;

        return $this;
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }
}