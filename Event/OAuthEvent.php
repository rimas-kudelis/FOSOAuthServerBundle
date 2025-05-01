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

namespace FOS\OAuthServerBundle\Event;

use FOS\OAuthServerBundle\Model\ClientInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

class OAuthEvent extends Event
{
    public const PRE_AUTHORIZATION_PROCESS = 'fos_oauth_server.pre_authorization_process';

    public const POST_AUTHORIZATION_PROCESS = 'fos_oauth_server.post_authorization_process';

    public function __construct(
        private UserInterface $user,
        private ClientInterface $client,
        private bool $isAuthorizedClient = false)
    {
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }


    public function setAuthorizedClient(bool $isAuthorizedClient): void
    {
        $this->isAuthorizedClient = $isAuthorizedClient;
    }

    public function isAuthorizedClient(): bool
    {
        return $this->isAuthorizedClient;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }
}
