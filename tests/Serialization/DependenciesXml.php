<?php
declare(strict_types=1);

namespace App\Tests\Serialization;

final class DependenciesXml
{
    public static function get(): string
    {
        return <<<XML
<dependencies generated="2021-01-02T13:37:28" pdepend="@package_version@">
    <package name="PDepend">
        <class name="Application">
            <efferent>
                <type namespace="" name="InvalidArgumentException"/>
                <type namespace="PDepend\DependencyInjection" name="PdependExtension"/>
            </efferent>
            <afferent>
                <type namespace="PDepend\TextUI" name="Command"/>
            </afferent>
            <file name="/var/www/pdepend/src/main/php/PDepend/Application.php"/>
        </class>
        <class name="Engine">
            <efferent>
                <type namespace="PDepend\Util" name="Configuration"/>
                <type namespace="PDepend\Util\Cache" name="CacheFactory"/>
                <type namespace="PDepend\Metrics" name="AnalyzerFactory"/>
            </efferent>
            <afferent>
                <type namespace="PDepend\TextUI" name="Runner"/>
            </afferent>
            <file name="/var/www/pdepend/src/main/php/PDepend/Engine.php"/>
        </class>
        <interface name="ProcessListener">
            <efferent>
                <type namespace="PDepend\Source\ASTVisitor" name="ASTVisitListener"/>
                <type namespace="PDepend\Metrics" name="AnalyzerListener"/>
            </efferent>
            <afferent>
                <type namespace="PDepend" name="Engine"/>
                <type namespace="PDepend\DbusUI" name="ResultPrinter"/>
            </afferent>
            <file name="/var/www/pdepend/src/main/php/PDepend/ProcessListener.php"/>
        </interface>
    </package>
    <package name="PDepend\DbusUI">
        <class name="ResultPrinter">
            <efferent>
                <type namespace="PDepend" name="ProcessListener"/>
                <type namespace="PDepend\Source\ASTVisitor" name="AbstractASTVisitListener"/>
                <type namespace="" name="DBusDict"/>
            </efferent>
            <afferent>
                <type namespace="PDepend\TextUI" name="Command"/>
            </afferent>
            <file name="/var/www/pdepend/src/main/php/PDepend/DbusUI/ResultPrinter.php"/>
        </class>
    </package>
    <package name="PDepend\DependencyInjection\Compiler">
        <class name="ProcessListenerPass">
            <efferent>
                <type namespace="Symfony\Component\DependencyInjection\Compiler" name="CompilerPassInterface"/>
                <type namespace="Symfony\Component\DependencyInjection" name="ContainerBuilder"/>
            </efferent>
            <afferent>
                <type namespace="PDepend" name="Application"/>
            </afferent>
            <file name="/var/www/pdepend/src/main/php/PDepend/DependencyInjection/Compiler/ProcessListenerPass.php"/>
        </class>
    </package>
</dependencies>
XML;
    }
}