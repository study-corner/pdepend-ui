<?php
declare(strict_types=1);

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

class Dependencies
{
    /**
     * @Serializer\Type("string")
     */
    private ?string $generated = null;
    /**
     * @Serializer\Type("string")
     */
    private ?string $pdepend = null;
    /**
     * @var Package[]
     * @Serializer\Type("array<App\XML\Entity\Package>")
     */
    private array $packages = [];

    public function getGenerated(): string
    {
        return $this->generated;
    }

    public function setGenerated(string $generated): self
    {
        $this->generated = $generated;

        return $this;
    }

    public function getPdepend(): string
    {
        return $this->pdepend;
    }

    public function setPdepend(string $pdepend): self
    {
        $this->pdepend = $pdepend;

        return $this;
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    public function addPackage(Package $package): self
    {
        $this->packages[] = $package;

        return $this;
    }
}