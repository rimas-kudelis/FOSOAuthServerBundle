<?php

namespace Controller;

use FOS\OAuthServerBundle\Controller\TokenController;
use OAuth2\OAuth2;
use OAuth2\OAuth2ServerException;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[Small]
class TokenControllerTest extends TestCase
{
    private $serverMock;
    private $tokenController;

    protected function setUp(): void
    {
        $this->serverMock = $this->createMock(OAuth2::class);
        $this->tokenController = new TokenController($this->serverMock);
    }

    public function testTokenActionReturnsAccessTokenResponse(): void
    {
        $request = $this->createStub(Request::class);
        $response = $this->createStub(Response::class);

        $this->serverMock
            ->expects($this->once())
            ->method('grantAccessToken')
            ->with($request)
            ->willReturn($response);

        $result = $this->tokenController->tokenAction($request);

        $this->assertSame($response, $result);
    }

    public function testTokenActionHandlesOAuth2ServerException(): void
    {
        $request = $this->createStub(Request::class);
        $exceptionResponse = $this->createStub(Response::class);
        $exception = $this->createMock(OAuth2ServerException::class);

        $exception
            ->expects($this->once())
            ->method('getHttpResponse')
            ->willReturn($exceptionResponse);

        $this->serverMock
            ->expects($this->once())
            ->method('grantAccessToken')
            ->with($request)
            ->willThrowException($exception);

        $result = $this->tokenController->tokenAction($request);

        $this->assertSame($exceptionResponse, $result);
    }
}