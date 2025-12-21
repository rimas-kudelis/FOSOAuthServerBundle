<?php

namespace Security\EntryPoint;

use FOS\OAuthServerBundle\Security\EntryPoint\OAuthEntryPoint;
use OAuth2\OAuth2;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

#[Small]
class OAuthEntryPointTest extends TestCase
{
    public function testStartReturnsUnauthorizedResponse()
    {
        $mockOAuth2 = $this->createMock(OAuth2::class);
        $mockOAuth2->method('getVariable')
            ->with(OAuth2::CONFIG_WWW_REALM)
            ->willReturn('example-realm');

        $entryPoint = new OAuthEntryPoint($mockOAuth2);
        $request = $this->createMock(Request::class);
        $authException = $this->createMock(AuthenticationException::class);

        $response = $entryPoint->start($request, $authException);

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertTrue($response->headers->has('WWW-Authenticate'));
        $this->assertStringContainsString('Bearer realm="example-realm"', $response->headers->get('WWW-Authenticate'));
    }
}