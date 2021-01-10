<?php
declare(strict_types=1);

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

class Package
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("name")
     */
    public string $packageName;
    /**
     * @var PackageClass[]
     * @Serializer\Type("array<App\XML\Entity\PackageClass>")
     * @Serializer\SerializedName("class")
     */
    public array $packageClasses = [];
    /**
     * @var PackageInterface[]
     */
    public array $packageInterfaces = [];

    public function getPackageName(): string
    {
        return $this->packageName;
    }

    public function setPackageName(string $packageName): self
    {
        $this->packageName = $packageName;

        return $this;
    }

    public function getPackageClasses(): array
    {
        return $this->packageClasses;
    }

    public function addPackageClass(PackageClass $packageClass): self
    {
        $this->packageClasses[] = $packageClass;

        return $this;
    }

    public function getPackageInterfaces(): array
    {
        return $this->packageInterfaces;
    }

    public function addPackageInterface(PackageInterface $packageInterface): self
    {
        $this->packageInterfaces[] = $packageInterface;

        return $this;
    }

    public function hasInterfaces(): bool
    {
        return 0 !== count($this->packageInterfaces);
    }

    public function calculateStability()
    {
        foreach ($this->packageClasses as $class) {
            $class->calculateStability();
        }
        foreach ($this->packageInterfaces as $interface) {
            $interface->calculateStability();
        }
    }
}