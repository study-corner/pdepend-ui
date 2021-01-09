<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Afferent;
use App\Entity\Dependencies;
use App\Entity\Efferent;
use App\Entity\Package;
use App\Entity\PackageClass;
use App\Entity\PackageInterface;
use App\Service\DependenciesParser;
use App\Tests\Serialization\DependenciesXml;
use PHPUnit\Framework\TestCase;

class DependenciesParserTest extends TestCase
{
    public function testXmlObjectParser()
    {
        $xmlElement = simplexml_load_string(DependenciesXml::get());
        $dependenciesParser = new DependenciesParser();
        $dependenciesParser->parse($xmlElement);
        $actual = $dependenciesParser->getDependencies();
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
            ->addAfferent($affCommand)
            ->setFile('/var/www/pdepend/src/main/php/PDepend/Application.php');

        $eff1 = (new Efferent())->setNamespace('PDepend\Util')->setName('Configuration');
        $eff2 = (new Efferent())->setNamespace('PDepend\Util\Cache')->setName('CacheFactory');
        $eff3 = (new Efferent())->setNamespace('PDepend\Metrics')->setName('AnalyzerFactory');
        $aff1 = (new Afferent())->setNamespace('PDepend\TextUI')->setName('Runner');
        $classEngine = (new PackageClass())
            ->setName('Engine')
            ->addEfferent($eff1)->addEfferent($eff2)->addEfferent($eff3)
            ->addAfferent($aff1)
            ->setFile('/var/www/pdepend/src/main/php/PDepend/Engine.php');

        $eff1 = (new Efferent())->setNamespace('PDepend\Source\ASTVisitor')->setName('ASTVisitListener');
        $eff2 = (new Efferent())->setNamespace('PDepend\Metrics')->setName('AnalyzerListener');
        $aff1 = (new Afferent())->setNamespace('PDepend')->setName('Engine');
        $aff2 = (new Afferent())->setNamespace('PDepend\DbusUI')->setName('ResultPrinter');
        $interface = (new PackageInterface())
            ->setName('ProcessListener')
            ->addEfferent($eff1)->addEfferent($eff2)
            ->addAfferent($aff1)->addAfferent($aff2)
            ->setFile('/var/www/pdepend/src/main/php/PDepend/ProcessListener.php');

        $package1 = (new Package())
            ->setPackageName('PDepend')
            ->addPackageClass($classApplication)
            ->addPackageClass($classEngine)
            ->addPackageInterface($interface);


        $eff1 = (new Efferent())->setNamespace('PDepend')->setName('ProcessListener');
        $eff2 = (new Efferent())->setNamespace('PDepend\Source\ASTVisitor')->setName('AbstractASTVisitListener');
        $eff3 = (new Efferent())->setName('DBusDict');
        $aff1 = (new Afferent())->setNamespace('PDepend\TextUI')->setName('Command');
        $class1 = (new PackageClass())
            ->setName('ResultPrinter')
            ->addEfferent($eff1)->addEfferent($eff2)->addEfferent($eff3)
            ->addAfferent($aff1)
            ->setFile('/var/www/pdepend/src/main/php/PDepend/DbusUI/ResultPrinter.php');

        $package2 = (new Package())
            ->setPackageName('PDepend\DbusUI')
            ->addPackageClass($class1);


        $eff1 = (new Efferent())->setNamespace('Symfony\Component\DependencyInjection\Compiler')->setName('CompilerPassInterface');
        $eff2 = (new Efferent())->setNamespace('Symfony\Component\DependencyInjection')->setName('ContainerBuilder');
        $aff1 = (new Afferent())->setNamespace('PDepend')->setName('Application');
        $class1 = (new PackageClass())
            ->setName('ProcessListenerPass')
            ->addEfferent($eff1)->addEfferent($eff2)
            ->addAfferent($aff1)
            ->setFile('/var/www/pdepend/src/main/php/PDepend/DependencyInjection/Compiler/ProcessListenerPass.php');

        $package3 = (new Package())
            ->setPackageName('PDepend\DependencyInjection\Compiler')
            ->addPackageClass($class1);

        return (new Dependencies())
            ->setGenerated('2021-01-02T13:37:28')
            ->setPdepend('@package_version@')
            ->addPackage($package1)
            ->addPackage($package2)
            ->addPackage($package3);
    }
}