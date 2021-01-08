<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Afferent;
use App\Entity\Dependencies;
use App\Entity\Efferent;
use App\Entity\Package;
use App\Entity\PackageClass;
use PHPUnit\Framework\TestCase;

class XmlObjectParserTest extends TestCase
{
    public function testXmlObjectParser()
    {
        $xmlObjectParser = new XmlObjectParser();
        $xmlObjectParser->parse();
        $actual = $xmlObjectParser->getDependencies();
        $this->assertEquals($this->expectedDependencies(), $actual);
    }

    private function expectedDependencies(): Dependencies
    {
        $effInvalidArgumentException = (new Efferent())->setName('InvalidArgumentException');
        $effPdependExtension = (new Efferent())->setNamespace('PDepend\DependencyInjection')->setName('PdependExtension');
        $affCommand = (new Afferent())->setNamespace('PDepend\TextUI')->setName('Command');

        $classApplication = (new PackageClass())
            ->setName('Application')
            ->addEfferent($effInvalidArgumentException)
            ->addEfferent($effPdependExtension)
            ->addAfferents($affCommand)
            ->setFile('/var/www/pdepend/src/main/php/PDepend/Application.php');

        $packagePDepend = (new Package())
            ->setPackageName('PDepend')
            ->addPackageClass($classApplication)
        ;

        return (new Dependencies())
            ->setGenerated('2021-01-02T13:37:28')
            ->setPdepend('@package_version@')
            ->addPackage($packagePDepend)
        ;
    }
}