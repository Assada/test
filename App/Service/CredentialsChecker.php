<?php

namespace App\Service;

/**
 * Class CredentialsChecker
 *
 * @package App\Service
 *
 * @author  Aleksey Ilyenko <oleksii@tireconnect.ca>
 * Tireconnect LLC
 */
class CredentialsChecker
{
    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $isValid = false;

    /**
     * CredentialsChecker constructor.
     *
     * @param string $login
     * @param string $password
     */
    public function __construct(string $login, string $password)
    {
        $this->login    = $login;
        $this->password = $password;
    }

    /**
     *
     * @return bool
     */
    public function execute(): bool
    {
        $this->isValid = ($this->login !== null && $this->password !== null);

        return true;
    }

    /**
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }
}
