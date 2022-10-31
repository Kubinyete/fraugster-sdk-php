<?php

namespace Kubinyete\Fraugster\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use JsonSerializable;
use Kubinyete\Fraugster\Exception\BadRequestException;
use Kubinyete\Fraugster\Exception\ParseException;
use Kubinyete\Fraugster\Exception\RateLimitedException;
use Kubinyete\Fraugster\Exception\UnauthorizedException;
use Kubinyete\Fraugster\Util\ArrayUtil;
use RuntimeException;
use Throwable;

class Request implements JsonSerializable
{
    private const USER_AGENT = 'FraugsterSDK for PHP';
    private const CONTENT_TYPE = 'application/json';

    private const STATUS_CODE_EXCEPTION_MAP = [
        400 => BadRequestException::class,
        401 => UnauthorizedException::class,
        429 => RateLimitedException::class,
    ];

    private static ?Client $client = null;

    protected string $url;
    protected array $query;
    protected array $body;
    protected array $header;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->query = [];
        $this->body = [];
        $this->header = [];
    }

    //

    private static function initializeClient(): Client
    {
        return self::$client ?? (self::$client = new Client([
            'allow_redirects' => false,
            'timeout' => 30.00,
            'connect_timeout' => 5.00,
            'http_errors' => true,
            'headers' => [
                'User-Agent' => self::USER_AGENT,
                'Content-Type' => self::CONTENT_TYPE,
                'Accept' => self::CONTENT_TYPE,
            ],
        ]));
    }

    //

    private function tryTranslateCodeToException(int $code): void
    {
        $className = self::STATUS_CODE_EXCEPTION_MAP[$code] ?? null;

        if ($className) {
            throw new $className;
        }
    }

    private function send(string $method): Response
    {
        $client = self::initializeClient();

        try {
            $response = $client->request($method, $this->url, [
                'headers' => $this->headers,
                'json' => $this->body,
                'query' => $this->query,
            ]);
        } catch (ServerException $e) {
            $response = $e->getResponse();

            $code = $response->getStatusCode();
            $reason = $response->getReasonPhrase();

            $this->tryTranslateCodeToException($code);

            throw new RuntimeException("Request failed with status code $code '$reason'.");
        } catch (GuzzleException $e) {
            throw new RuntimeException("An error ocurred while trying to send a request.");
        }

        $content = $response->getBody()->getContents();
        return new Response($content);
    }

    public function query(array $query): self
    {
        $this->query = array_merge($this->query, $query);
        return $this;
    }

    public function body(array $body): self
    {
        $this->body = array_merge($this->body, $body);
        return $this;
    }

    public function headers(array $headers): self
    {
        $this->headers = array_merge($this->header, $headers);
        return $this;
    }

    public function header(string $key, string $value): self
    {
        return $this->headers([$key => $value]);
    }

    //

    public function get(): Response
    {
        return $this->send(strtoupper(__FUNCTION__));
    }

    public function post(): Response
    {
        return $this->send(strtoupper(__FUNCTION__));
    }

    public function put(): Response
    {
        return $this->send(strtoupper(__FUNCTION__));
    }

    public function patch(): Response
    {
        return $this->send(strtoupper(__FUNCTION__));
    }

    public function delete(): Response
    {
        return $this->send(strtoupper(__FUNCTION__));
    }

    //

    public function jsonSerialize(): mixed
    {
        return $this->body;
    }
}
