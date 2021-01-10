<?php
declare(strict_types=1);

namespace App\Entity;

abstract class Ferent implements FerentInterface
{
    protected string $namespace = '';
    protected string $name = '';
    protected float $stability = 0.00;

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function setNamespace(string $namespace): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStability(): float
    {
        return $this->stability;
    }

    public function setStability(float $stability): self
    {
        $this->stability = $stability;

        return $this;
    }
}