<?php

namespace App\Http\Mitre;

class DatasetRequest
{
    private string $uri;

    /**
     * Response body
     * @var mixed $content
     */
    private $body;

    public function __construct(?string $uri = null)
    {
        if (is_null($uri)) {
            /** @var string $uri */
            $uri = config('mitre.dataset_uri');
        }

        $this->uri = $uri;
    }

    public function get(): self
    {
        try {
            $fileContents = \file_get_contents($this->uri);
        } catch (\Throwable $e) {
            throw new GetDatasetFromUriException($e->getMessage());
        }

        if (false === $fileContents) {
            throw new GetDatasetFromUriException(sprintf('Unable to get dataset from uri %s', $this->uri));
        }

        $this->body = $fileContents;

        return $this;
    }

    public function asArray(): array
    {
        return \json_decode($this->body, true);
    }

    public function getBody()
    {
        return $this->body;
    }
}
