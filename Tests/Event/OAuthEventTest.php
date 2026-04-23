<?php

namespace Event;

use FOS\OAuthServerBundle\Event\OAuthEvent;
use FOS\OAuthServerBundle\Model\ClientInterface;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\UserInterface;


#[Small]
class OAuthEventTest extends TestCase
{
    public function testGetUserReturnsCorrectUserInstance(): void
    {
        // Arrange
        $userMock = $this->createStub(UserInterface::class);
        $clientMock = $this->createStub(ClientInterface::class);
        $event = new OAuthEvent($userMock, $clientMock);

        // Act
        $result = $event->getUser();

        // Assert
        $this->assertSame($userMock, $result);
    }

    /**
     * Test that setAuthorizedClient properly updates the isAuthorizedClient property to true.
     */
    public function testSetAuthorizedClientUpdatesToTrue(): void
    {
        // Arrange
        $userMock = $this->createStub(UserInterface::class);
        $clientMock = $this->createStub(ClientInterface::class);
        $event = new OAuthEvent($userMock, $clientMock);

        // Act
        $event->setAuthorizedClient(true);

        // Assert
        $this->assertTrue($event->isAuthorizedClient());
    }

    /**
     * Test that setAuthorizedClient properly updates the isAuthorizedClient property to false.
     */
    public function testSetAuthorizedClientUpdatesToFalse(): void
    {
        // Arrange
        $userMock = $this->createStub(UserInterface::class);
        $clientMock = $this->createStub(ClientInterface::class);
        $event = new OAuthEvent($userMock, $clientMock);

        // Act
        $event->setAuthorizedClient(false);

        // Assert
        $this->assertFalse($event->isAuthorizedClient());
    }

    /**
     * Test that getClient returns the correct ClientInterface instance.
     */
    public function testGetClientReturnsCorrectClientInstance(): void
    {
        // Arrange
        $userMock = $this->createStub(UserInterface::class);
        $clientMock = $this->createStub(ClientInterface::class);
        $event = new OAuthEvent($userMock, $clientMock);

        // Act
        $result = $event->getClient();

        // Assert
        $this->assertSame($clientMock, $result);
    }
}