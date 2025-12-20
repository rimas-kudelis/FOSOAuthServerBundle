<?php

declare(strict_types=1);

/*
 * This file is part of the FOSOAuthServerBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\OAuthServerBundle\Tests\Routing;

use FOS\OAuthServerBundle\Routing\DeprecatedXmlFileLoader;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;

/**
 * Tests for the DeprecatedXmlFileLoader.
 */
class DeprecatedXmlFileLoaderTest extends TestCase
{
    private FileLocator $fileLocator;
    private array $triggeredDeprecations = [];

    protected function setUp(): void
    {
        $this->fileLocator = new FileLocator(__DIR__.'/../../Resources/config/routing');
        $this->triggeredDeprecations = [];
    }

    /**
     * Sets up a custom error handler to capture deprecation notices.
     */
    private function captureDeprecations(callable $callback): void
    {
        set_error_handler(function ($type, $message) {
            if (E_USER_DEPRECATED === $type) {
                $this->triggeredDeprecations[] = $message;

                return true;
            }

            return false;
        });

        try {
            $callback();
        } finally {
            restore_error_handler();
        }
    }

    #[Group('legacy')]
    public function testLoadingAuthorizeXmlTriggersDeprecation(): void
    {
        $expectedMessage = 'Since klapaudius/oauth-server-bundle 5.1: Loading OAuth routing from XML file "authorize.xml" is deprecated. Use the YAML file "@FOSOAuthServerBundle/Resources/config/routing/authorize.yaml" instead.';

        $this->captureDeprecations(function () {
            $loader = new DeprecatedXmlFileLoader($this->fileLocator);
            $routes = $loader->load('authorize.xml');

            $this->assertNotNull($routes);
            $this->assertNotNull($routes->get('fos_oauth_server_authorize'));
        });

        $this->assertCount(1, $this->triggeredDeprecations, 'Expected exactly one deprecation to be triggered');
        $this->assertSame($expectedMessage, $this->triggeredDeprecations[0]);
    }

    #[Group('legacy')]
    public function testLoadingTokenXmlTriggersDeprecation(): void
    {
        $expectedMessage = 'Since klapaudius/oauth-server-bundle 5.1: Loading OAuth routing from XML file "token.xml" is deprecated. Use the YAML file "@FOSOAuthServerBundle/Resources/config/routing/token.yaml" instead.';

        $this->captureDeprecations(function () {
            $loader = new DeprecatedXmlFileLoader($this->fileLocator);
            $routes = $loader->load('token.xml');

            $this->assertNotNull($routes);
            $this->assertNotNull($routes->get('fos_oauth_server_token'));
        });

        $this->assertCount(1, $this->triggeredDeprecations, 'Expected exactly one deprecation to be triggered');
        $this->assertSame($expectedMessage, $this->triggeredDeprecations[0]);
    }

    public function testSupportsAuthorizeXml(): void
    {
        $loader = new DeprecatedXmlFileLoader($this->fileLocator);

        $this->assertTrue($loader->supports('authorize.xml', 'xml'));
    }

    public function testSupportsTokenXml(): void
    {
        $loader = new DeprecatedXmlFileLoader($this->fileLocator);

        $this->assertTrue($loader->supports('token.xml', 'xml'));
    }

    public function testSupportsBundleRoutingPath(): void
    {
        $loader = new DeprecatedXmlFileLoader($this->fileLocator);

        $this->assertTrue($loader->supports('FOSOAuthServerBundle/Resources/config/routing/authorize.xml', 'xml'));
        $this->assertTrue($loader->supports('FOSOAuthServerBundle/Resources/config/routing/token.xml', 'xml'));
    }
}
