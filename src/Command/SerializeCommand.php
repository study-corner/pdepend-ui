<?php

namespace App\Command;

use App\Serialization\User;
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
        $user = $this->serializer->deserialize($this->getUserXml(), User::class, 'xml');

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
