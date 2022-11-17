<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\Store\Sso;

use LightSaml\State\Sso\SsoState;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SsoStateSessionStore implements SsoStateStoreInterface
{
    /** @var RequestStack */
    protected $requestStack;

    /** @var string */
    protected $key;

    /**
     * @param string $key
     */
    public function __construct(RequestStack $requestStack, $key)
    {
        $this->requestStack = $requestStack;
        $this->key = $key;
    }

    /**
     * @return SsoState
     */
    public function get()
    {
        $result = $this->requestStack->getSession()->get($this->key);
        if (null == $result) {
            $result = new SsoState();
            $this->set($result);
        }

        return $result;
    }

    /**
     * @return void
     */
    public function set(SsoState $ssoState)
    {
        $ssoState->setLocalSessionId($this->requestStack->getId());
        $this->requestStack->getSession()->set($this->key, $ssoState);
    }
}
