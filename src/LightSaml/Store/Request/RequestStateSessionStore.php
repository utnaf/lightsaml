<?php

/*
 * This file is part of the LightSAML-Core package.
 *
 * (c) Milos Tomic <tmilos@lightsaml.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace LightSaml\Store\Request;

use Symfony\Component\HttpFoundation\RequestStack;

class RequestStateSessionStore extends AbstractRequestStateArrayStore
{
    /** @var RequestStack */
    protected $requestStack;

    /** @var string */
    protected $providerId;

    /** @var string */
    protected $prefix;

    /**
     * @param string $providerId
     * @param string $prefix
     */
    public function __construct(RequestStack $requestStack, $providerId, $prefix = 'saml_request_state_')
    {
        $this->requestStack = $requestStack;
        $this->providerId = $providerId;
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    protected function getKey()
    {
        return sprintf('%s_%s', $this->providerId, $this->prefix);
    }

    /**
     * @return array
     */
    protected function getArray()
    {
        return $this->requestStack->getSession()->get($this->getKey(), []);
    }

    protected function setArray(array $arr)
    {
        $this->requestStack->getSession()->set($this->getKey(), $arr);
    }
}
