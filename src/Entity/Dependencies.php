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

    public function hasAllProperties(): bool
    {
        return null !== $this->generated && null !== $this->pdepend;
    }

    public function calculateStability()
    {
        foreach ($this->packages as $package) {
            $package->calculateStability();
        }

        $this->updateEfferentsStability();
    }

    private function updateEfferentsStability()
    {
        foreach ($this->packages as $package) {
            foreach ($package->getPackageClasses() as $class) {
                foreach ($class->getEfferents() as $efferent) {
                    $stability = $this->findPackageItemStability($efferent);
                    $efferent->setStability($stability);
                }
                foreach ($class->getAfferents() as $afferent) {
                    $stability = $this->findPackageItemStability($afferent);
                    $afferent->setStability($stability);
                }
            }

            foreach ($package->getPackageInterfaces() as $interface) {
                foreach ($interface->getEfferents() as $efferent) {
                    $stability = $this->findPackageItemStability($efferent);
                    $efferent->setStability($stability);
                }
                foreach ($interface->getAfferents() as $afferent) {
                    $stability = $this->findPackageItemStability($afferent);
                    $afferent->setStability($stability);
                }
            }
        }
    }

    private function findPackageItemStability(Ferent $ferent): float
    {
        $name = $ferent->getName();
        $namespace = $ferent->getNamespace();

        foreach ($this->packages as $package) {
            if ($package->getPackageName() === $namespace) {
                foreach ($package->getPackageClasses() as $class) {
                    if ($class->getName() === $name) {
                        return $class->getStability();
                    }
                }
                foreach ($package->getPackageInterfaces() as $interface) {
                    if ($interface->getName() === $name) {
                        return $interface->getStability();
                    }
                }
            }
        }

        return -1;
    }
}