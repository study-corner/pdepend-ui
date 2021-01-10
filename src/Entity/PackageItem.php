<?php
declare(strict_types=1);

namespace App\Entity;

abstract class PackageItem implements PackageItemInterface
{
    protected string $name = '';
    /**
     * @var Efferent[]
     */
    protected array $efferents = [];
    /**
     * @var Afferent[]
     */
    protected array $afferents = [];
    protected string $file = '';
    protected float $stability = 0.0;

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

    public function calculateStability()
    {
        $out = count($this->efferents);
        $in = count($this->afferents);


        $division = $in + $out;
        if ($division === 0) {
            $this->stability = -1;
            return;
        }
        $this->stability = round($out / $division, 2);
    }

    public function getStability(): float
    {
        return $this->stability;
    }
}