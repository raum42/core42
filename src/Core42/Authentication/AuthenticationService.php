<?php
/**
 * core42 (www.raum42.at)
 *
 * @link http://www.raum42.at
 * @copyright Copyright (c) 2010-2014 raum42 OG (http://www.raum42.at)
 *
 */

namespace Core42\Authentication;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Result;
use Zend\Authentication\Storage\StorageInterface;

class AuthenticationService implements AuthenticationServiceInterface
{
    /**
     * @var StorageInterface
     */
    protected $storage = null;

    /**
     * @var Result
     */
    protected $authResult;

    /**
     * Constructor
     *
     * @param  StorageInterface $storage
     */
    public function __construct(StorageInterface $storage = null)
    {
        if (null !== $storage) {
            $this->setStorage($storage);
        }
    }

    /**
     * Returns the persistent storage handler
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Sets the persistent storage handler
     *
     * @param  StorageInterface $storage
     * @return AuthenticationService Provides a fluent interface
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * @param Result $authResult
     * @return $this
     */
    public function setAuthResult(Result $authResult)
    {
        $this->authResult = $authResult;

        return $this;
    }

    /**
     * Authenticates and provides an authentication result
     *
     * @return Result
     */
    public function authenticate()
    {
        if (empty($this->authResult)) {
            return new Result(
                Result::FAILURE_UNCATEGORIZED,
                null,
                array(
                    'no result set'
                )
            );
        }

        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }

        if ($this->authResult->isValid()) {
            $this->getStorage()->write($this->authResult->getIdentity());
        }

        $result = $this->authResult;
        $this->authResult = null;
        return $result;
    }

    /**
     * Returns true if and only if an identity is available
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return !$this->getStorage()->isEmpty();
    }

    /**
     * Returns the authenticated identity or null if no identity is available
     *
     * @return mixed|null
     */
    public function getIdentity()
    {
        $storage = $this->getStorage();

        if ($storage->isEmpty()) {
            return null;
        }

        return $storage->read();
    }

    /**
     * Clears the identity
     *
     * @return void
     */
    public function clearIdentity()
    {
        $this->getStorage()->clear();
    }
}
