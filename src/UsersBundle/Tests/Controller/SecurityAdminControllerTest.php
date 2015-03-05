<?php

namespace UsersBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityAdminControllerTest extends WebTestCase
{
    public function testLoginadmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/login');
    }

}
