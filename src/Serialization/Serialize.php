<?php
declare(strict_types=1);

namespace App\Serialization;

use JMS\Serializer\SerializerBuilder;

class Serialize
{
    public function create(): User
    {
        $wife = (new User())->setName('Rita')->setAge(31);
        $daughter1 = (new User())->setName('Rebeka')->setAge(12);
        $daughter2 = (new User())->setName('Elija')->setAge(4);
        $hobbies = ['chess', 'exercise', 'prograamming'];
        $user = (new User())
            ->setName('Kes')
            ->setAge(37)
            ->setHobbies($hobbies);
        $user
            ->addFamilyMember($wife)
            ->addFamilyMember($daughter1)
            ->addFamilyMember($daughter2);

        $serializer = SerializerBuilder::create()
            ->setCacheDir('/var/www/pdepend-ui/var/cache/dev')
            ->build();

        $user = $serializer->deserialize($this->getJmsXml(), User::class, 'xml');

        return $user;
    }

    private function getJmsXml(): string
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
