<?php
declare(strict_types=1);

namespace App\Tests\Serialization;

use App\Serialization\Serialize;
use App\Serialization\User;
use PHPUnit\Framework\TestCase;

class SerializeTest extends TestCase
{
    public function testCreate()
    {
        $serialize = new Serialize();
        $user = $serialize->create();

        $this->assertInstanceOf(User::class, $user);
        $family = $user->getFamily();
        $this->assertCount(3, $family);
        foreach($family as $item) {
            $this->assertInstanceOf(User::class, $item);
        }
    }
}