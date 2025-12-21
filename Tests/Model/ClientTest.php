<?php

namespace Model;

use FOS\OAuthServerBundle\Model\Client;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
class ClientTest extends TestCase
{
    /**
     * Test that getRedirectUris returns an empty array by default.
     */
    public function testGetRedirectUrisReturnsEmptyArrayByDefault(): void
    {
        $client = new Client();
        $this->assertSame([], $client->getRedirectUris());
    }

    /**
     * Test that getRedirectUris returns the same array that was set.
     */
    public function testGetRedirectUrisReturnsSetArray(): void
    {
        $client = new Client();
        $redirectUris = ['https://example.com/callback', 'https://another-example.com/callback'];

        $client->setRedirectUris($redirectUris);

        $this->assertSame($redirectUris, $client->getRedirectUris());
    }

    /**
     * Test that getRedirectUris handles an empty array properly when set.
     */
    public function testGetRedirectUrisHandlesEmptyArray(): void
    {
        $client = new Client();
        $redirectUris = [];

        $client->setRedirectUris($redirectUris);

        $this->assertSame($redirectUris, $client->getRedirectUris());
    }

    /**
     * Test that getSalt returns null.
     */
    public function testGetSaltReturnsNull(): void
    {
        $client = new Client();

        $this->assertNull($client->getSalt());
    }

    /**
     * Test that getRoles returns the default role 'ROLE_USER'.
     */
    public function testGetRolesReturnsDefaultRole(): void
    {
        $client = new Client();
        $this->assertSame(['ROLE_USER'], $client->getRoles());
    }

    /**
     * Test that getPassword returns the set secret.
     */
    public function testGetPasswordReturnsExpectedValue(): void
    {
        $client = new Client();
        $secret = 'my_secret_value';

        $client->setSecret($secret);

        $this->assertSame($secret, $client->getPassword());
    }

    /**
     * Test that getPassword returns null if no secret is set.
     */
    public function testGetPasswordReturnsNullWithoutSecret(): void
    {
        $client = new Client();

        $client->setSecret(null);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('The client has no secret.');

        $this->assertNull($client->getPassword());
    }

    /**
     * Test that getUsername returns the expected randomId value.
     */
    public function testGetUsernameReturnsExpectedValue(): void
    {
        $client = new Client();
        $randomId = 'test_random_id';

        $client->setRandomId($randomId);

        $this->assertSame($randomId, $client->getUsername());
    }

    /**
     * Test that getUsername returns null by default if randomId is not set.
     */
    public function testGetUsernameReturnsRandomStringByDefault(): void
    {
        $client = new Client();

        $this->assertNotNull($client->getUsername());
    }

    /**
     * Test that getUserIdentifier returns the expected randomId value.
     */
    public function testGetUserIdentifierReturnsExpectedValue(): void
    {
        $client = new Client();
        $randomId = 'test_random_id';

        $client->setRandomId($randomId);

        $this->assertSame($randomId, $client->getUserIdentifier());
    }

    /**
     * Test that getUserIdentifier returns null by default if randomId is not set.
     */
    public function testGetUserIdentifierReturnsRansmStringByDefault(): void
    {
        $client = new Client();

        $this->assertNotNull($client->getUserIdentifier());
    }
}