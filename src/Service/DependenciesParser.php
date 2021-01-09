<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Afferent;
use App\Entity\Dependencies;
use App\Entity\Efferent;
use App\Entity\FerentInterface;
use App\Entity\Package;
use App\Entity\PackageClass;
use App\Entity\PackageInterface;
use App\Entity\PackageItemInterface;

class DependenciesParser
{
    private Dependencies $dependencies;

    public function parse(\SimpleXMLElement $xmlElement)
    {
        $this->dependencies = new Dependencies();

        $this->parseDependenciesProperties($xmlElement);

        foreach ($xmlElement->children() as $packageXml) {
            $package = new Package();
            $this->parsePackageName($package, $packageXml);
            $this->dependencies->addPackage($package);
            foreach ($packageXml->children() as $name => $item) {
                if ('class' === $name ) {
                    $class = new PackageClass();
                    $package->addPackageClass($class);
                    $this->parsePackageItems($class, $item);
                }
                if ('interface' === $name ) {
                    $interface = new PackageInterface();
                    $package->addPackageInterface($interface);
                    $this->parsePackageItems($interface, $item);
                }
            }
        }
    }

    public function getDependencies(): Dependencies
    {
        return $this->dependencies;
    }

    private function parseDependenciesProperties(\SimpleXMLElement $xmlElement): void
    {
        $attributes = $xmlElement->attributes();
        foreach ($attributes as $attrName => $attrValue) {
            if ($this->dependencies->hasAllProperties()) {
                return;
            }
            if ('generated' === $attrName) {
                $this->dependencies->setGenerated(strval($attrValue));
            }
            if ('pdepend' === $attrName) {
                $this->dependencies->setPdepend(strval($attrValue));
            }
        }
    }

    private function parsePackageName(Package $package, \SimpleXMLElement $packageXml)
    {
        foreach ($packageXml->attributes() as $attrName => $attrValue) {
            if ('name' === $attrName) {
                $package->setPackageName(strval($attrValue));
            }
        }
    }

    private function parsePackageItems(PackageItemInterface $class,\SimpleXMLElement $item)
    {
        $this->parsePackageItemName($class, $item);
        foreach ($item->children() as $key => $node) {
            if ('efferent' === $key) {
                $this->createEfferents($class, $node);
            }
            if ('afferent' === $key) {
                $this->createAfferents($class, $node);
            }
            if ('file' === $key) {
                $this->parsePackageItemFile($class, $node);
            }
        }
    }

    private function createEfferents(PackageItemInterface $packageItem,\SimpleXMLElement $node)
    {
        foreach ($node as $leaf) {
            $efferent = new Efferent();
            $packageItem->addEfferent($efferent);
            $this->parseFerrentProperties($efferent, $leaf);
        }
    }

    private function createAfferents(PackageItemInterface $packageItem,\SimpleXMLElement $node)
    {
        foreach ($node as $leaf) {
            $afferent = new Afferent();
            $packageItem->addAfferent($afferent);
            $this->parseFerrentProperties($afferent, $leaf);
        }
    }

    private function parsePackageItemName(PackageItemInterface $packageItem, \SimpleXMLElement $item)
    {
        foreach ($item->attributes() as $attrName => $attrValue) {
            if ('name' === $attrName) {
                $packageItem->setName(strval($attrValue));
            }
        }
    }

    private function parsePackageItemFile(PackageItemInterface $packageItem, \SimpleXMLElement $item)
    {
        foreach ($item->attributes() as $attrName => $attrValue) {
            if ('name' === $attrName) {
                $packageItem->setFile(strval($attrValue));
            }
        }
    }

    private function parseFerrentProperties(FerentInterface $ferent, \SimpleXMLElement $leaf)
    {
        foreach ($leaf->attributes() as $attrName => $attrValue) {
            if ('namespace' === $attrName) {
                $ferent->setNamespace(strval($attrValue));
            }
            if ('name' === $attrName) {
                $ferent->setName(strval($attrValue));
            }
        }
    }
}