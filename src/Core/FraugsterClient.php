<?php

namespace Kubinyete\Fraugster\Core;

use Kubinyete\Fraugster\Exception\ExpiredTokenException;
use Kubinyete\Fraugster\Exception\InvalidTokenException;
use Kubinyete\Fraugster\Exception\ServerException;
use Kubinyete\Fraugster\Http\Request;
use Kubinyete\Fraugster\Http\Response;
use Kubinyete\Fraugster\Util\ArrayUtil;

class FraugsterClient
{
    protected Environment $env;
    protected int $version;
    protected ?string $token;

    protected bool $ignoreExpiredTokens;

    public function __construct(Environment $env, bool $ignoreExpiredTokens = false, int $version = 2)
    {
        $this->env = $env;
        $this->version = $version;
        $this->token = null;

        $this->ignoreExpiredTokens = $ignoreExpiredTokens;
    }

    //

    /**
     * Changes the current environment URL.
     *
     * @param Environment $env
     * @return self
     */
    public function useEnv(Environment $env): self
    {
        $this->env = $env;
        return $this;
    }

    /**
     * Updates the current token to be used, token should have a valid format (JWT),
     * and should not be expired.
     *
     * @param string $token
     * @return self
     */
    public function useToken(string $token): self
    {
        $this->assertTokenIsUsable($token);

        $this->token = $token;
        return $this;
    }

    //

    protected function assertTokenIsUsable(string $token): void
    {
        $firstSlice = explode('.', $token, 2)[0];
        $firstSlice = base64_decode($firstSlice);
        $firstSlice = json_decode($firstSlice, true);

        if (!is_array($firstSlice)) {
            throw new InvalidTokenException();
        }

        if (ArrayUtil::get('exp', $firstSlice, 0) < time()) {
            throw new ExpiredTokenException();
        }
    }

    //

    protected function request(string $path): Request
    {
        static $directorySeparator = '/';

        $basePath = rtrim($this->env->getUrl(), $directorySeparator);
        $filePath = ltrim($path, $directorySeparator);
        $versionStr = 'v' . $this->version;

        $request = new Request(implode($directorySeparator, [$basePath, 'api', $versionStr, $filePath]));

        if ($this->token) {
            $request->header('Authorization', "SessionToken {$this->token}");
        }

        return $request;
    }

    //

    /**
     * Attempts to create a session and return it.
     *
     * @param string $username
     * @param string $password
     * @throws ServerException
     * @return Response
     */
    public function createSession(string $username, string $password): Response
    {
        $basicAuth = base64_encode(implode(':', [$username, $password]));
        return $this->request('sessions')->header('Authorization', "Basic $basicAuth")->post();
    }

    /**
     * Attempts to create a session and return a sessionToken.
     *
     * @param string $username
     * @param string $password
     * @throws ServerException
     * @return string|null
     */
    public function getSessionToken(string $username, string $password): ?string
    {
        return $this->createSession($username, $password)->get('sessionToken');
    }

    // public function createTransaction() 
}
