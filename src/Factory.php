<?php

namespace Outl1ne\NovaOpenAI;

class Factory
{
    /**
     * The API key for the requests.
     */
    protected ?string $apiKey = null;

    /**
     * The organization for the requests.
     */
    protected ?string $organization = null;

    /**
     * The base URL for the requests.
     */
    protected ?string $baseUrl = null;

    /**
     * The HTTP headers for the requests.
     *
     * @var array<string, string>
     */
    protected array $headers = [];

    /**
     * The timeout for the outgoing requests
     */
    protected int $timeout = 30;

    /**
     * The pricing configuration to calculate the cost of requests.
     */
    protected ?object $pricing = null;

    /**
     * Sets the API key for the requests.
     */
    public function withApiKey(string $apiKey): self
    {
        $this->apiKey = trim($apiKey);

        return $this;
    }

    /**
     * Sets the organization for the requests.
     */
    public function withOrganization(?string $organization): self
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Sets the base URL for the requests.
     * If no URL is provided the factory will use the default OpenAI API URL.
     */
    public function withBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Adds a custom HTTP header to the requests.
     */
    public function withHttpHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Adds a custom HTTP headers to the requests.
     */
    public function withHttpHeaders(?array $headers): self
    {
        if (!$headers) return $this;

        $this->headers = [
            ...$this->headers,
            ...$headers,
        ];

        return $this;
    }

    public function withTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Adds a pricing configuration.
     */
    public function withPricing(object $pricing): self
    {
        $this->pricing = $pricing;

        return $this;
    }

    /**
     * Creates a new Open AI Client.
     */
    public function make(): OpenAI
    {
        $headers = $this->headers;

        if ($this->apiKey !== null) {
            $headers['Authorization'] = "Bearer {$this->apiKey}";
        }

        if ($this->organization !== null) {
            $headers['OpenAI-Organization'] = $this->organization;
        }

        $baseUrl = rtrim($this->baseUrl ?: 'https://api.openai.com/v1', '/') . '/';

        return new OpenAI($baseUrl, $headers, $this->timeout, $this->pricing);
    }
}
