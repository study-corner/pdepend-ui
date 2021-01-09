<?php

namespace App\Command;

use App\Entity\Dependencies;
use App\Serialization\User;
use App\Service\DependenciesParser;
use App\Service\XmlClosureParser;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SerializeCommand extends Command
{
    protected static $defaultName = 'app:serialize';

    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;

        parent::__construct(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        $user = $this->serializer->deserialize($this->getUserXml(), User::class, 'xml');

        $dir = realpath(__DIR__.'/../../build');
        $xmlFile = $dir . '/dependency.xml';
        $xml = file_get_contents($xmlFile);

        $simpleXml = simplexml_load_file($xmlFile);
        $xmlParser = new XmlClosureParser();
        $parsedArray = $xmlParser->xmlToArray($simpleXml);

//        $dependencies = $this->serializer->deserialize($xml, Dependencies::class, 'xml');

        $dependenciesParser = new DependenciesParser();
        $dependenciesParser->parse($simpleXml);
        $dependencies = $dependenciesParser->getDependencies();

        return Command::SUCCESS;
    }

    private function getUserXml(): string
    {
        return <<<XML
<user>
    <name>Kes</name>
    <age>37</age>
    <hobbies>
        <entry>chess</entry>
        <entry>exercise</entry>
        <entry>prograamming</entry>
    </hobbies>
    <family>
        <entry>
            <name>Rita</name>
            <age>31</age>
            <hobbies/>
            <family/>
        </entry>
        <entry>
            <name>Rebeka</name>
            <age>12</age>
            <hobbies/>
            <family/>
        </entry>
        <entry>
            <name>Elija</name>
            <age>4</age>
            <hobbies/>
            <family/>
        </entry>
    </family>
</user>
XML;
    }
}
