<?php

namespace Kubinyete\Fraugster\Core;

use DateTimeInterface;
use Kubinyete\Fraugster\Exception\ExpiredTokenException;
use Kubinyete\Fraugster\Exception\InvalidTokenException;
use Kubinyete\Fraugster\Exception\ServerException;
use Kubinyete\Fraugster\Http\Request;
use Kubinyete\Fraugster\Http\Response;
use Kubinyete\Fraugster\Model\Recommendation\Recommendation;
use Kubinyete\Fraugster\Model\Transaction\UpdatePacket;
use Kubinyete\Fraugster\Model\Transaction;
use Kubinyete\Fraugster\Model\TransactionStatus;
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
        $payload = explode('.', $token, 3)[1] ?? null;
        $payload = base64_decode($payload);
        $payload = json_decode($payload, true);

        if (!is_array($payload)) {
            throw new InvalidTokenException();
        }

        if (ArrayUtil::get('exp', $payload, 0) < time()) {
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

    /**
     * Creates a Fraugster transaction
     *
     * @param Transaction $transaction
     * @return Recommendation|null
     */
    public function createTransaction(Transaction $transaction): ?Recommendation
    {
        $response = $this->request('transaction')->body($transaction->jsonSerialize())->post();
        return Recommendation::tryParse($response->jsonSerialize());
    }

    /**
     * Update an existing Fraugster transaction
     *
     * @param string $id
     * @param UpdatePacket $update
     * @return Response
     */
    public function updateTransaction(UpdatePacket $update): Response
    {
        return $this->request('transaction')->body($update->jsonSerialize())->patch();
    }

    /**
     * Update a batch of transactions
     *
     * @param string $id
     * @param UpdatePacket $update
     * @return Response
     */
    public function updateTransactionBatch(UpdatePacket ...$packets): Response
    {
        $packets = array_map(fn (UpdatePacket $x) => $x->jsonSerialize(), $packets);
        $packets = array_merge(...$packets);

        /**
         * @var array $packets 
         */
        return $this->request('transaction')->body($packets)->patch();
    }
}
