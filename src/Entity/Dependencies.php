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
    private array $package = [];

    public function getGenerated(): string
    {
        return $this->generated;
    }

    public function setGenerated(string $generated): void
    {
        $this->generated = $generated;
    }

    public function getPdepend(): string
    {
        return $this->pdepend;
    }

    public function setPdepend(string $pdepend): void
    {
        $this->pdepend = $pdepend;
    }

    public function getPackages(): array
    {
        return $this->package;
    }

    public function addPackage(Package $package): void
    {
        $this->package[] = $package;
    }
}