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
    public function withbaseUrl(string $baseUrl): self
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

    /**
     * Creates a new Open AI Client.
     */
    public function make(): Client
    {
        $headers = $this->headers;

        if ($this->apiKey !== null) {
            $headers['Authorization'] = "Bearer {$this->apiKey}";
        }

        if ($this->organization !== null) {
            $headers['OpenAI-Organization'] = $this->organization;
        }

        $baseUrl = rtrim($this->baseUrl ?: 'https://api.openai.com/v1', '/') . '/';

        $http = new Http($baseUrl, $headers);

        return new Client($http);
    }
}
