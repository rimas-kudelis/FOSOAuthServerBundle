<?php

namespace Security\Authenticator\Passport\Badge;

use FOS\OAuthServerBundle\Model\AccessToken;
use FOS\OAuthServerBundle\Security\Authenticator\Passport\Badge\AccessTokenBadge;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[Small]
class AccessTokenBadgeTest extends TestCase
{
    public function testIsResolvedReturnsTrueWhenRolesAreNotEmpty(): void
    {
        $accessToken = $this->createStub(AccessToken::class);
        $roles = ['ROLE_USER'];

        $badge = new AccessTokenBadge($accessToken, $roles);

        $this->assertTrue($badge->isResolved());
    }

    public function testIsResolvedReturnsFalseWhenRolesAreEmpty(): void
    {
        $accessToken = $this->createStub(AccessToken::class);
        $roles = [];

        $badge = new AccessTokenBadge($accessToken, $roles);

        $this->assertFalse($badge->isResolved());
    }

    public function testGetAccessToken(): void
    {
        $accessToken = $this->createStub(AccessToken::class);
        $roles = [];

        $badge = new AccessTokenBadge($accessToken, $roles);

        $this->assertSame($accessToken, $badge->getAccessToken());
    }
}