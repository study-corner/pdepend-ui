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
     * @Serializer\Type("array<App\XML\Entity\PackageClass>")
     * @Serializer\SerializedName("class")
     */
    public array $packageClasses = [];

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * @param string $packageName
     */
    public function setPackageName(string $packageName): void
    {
        $this->packageName = $packageName;
    }

    public function getPackageClasses(): array
    {
        return $this->packageClasses;
    }

    public function addPackageClass(PackageClass $packageClass): void
    {
        $this->packageClasses[] = $packageClass;
    }
}