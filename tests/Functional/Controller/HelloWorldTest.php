<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Controller\HelloWorldAction;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

#[CoversClass(HelloWorldAction::class)]
final class HelloWorldTest extends WebTestCase
{
    public function testHelloWorld(): void
    {
        $client = self::createClient();
        $client->request('GET', '/hello-world');
        self::assertResponseIsSuccessful();
    }
}
