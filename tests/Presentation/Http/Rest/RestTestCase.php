<?php

namespace Test\Presentation\Http\Rest;

use function json_decode;
use function json_encode;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class RestTestCase extends WebTestCase
{
    protected KernelBrowser $browser;

    protected function setUp(): void
    {
        $this->browser = static::createClient();
    }

    protected function headers(): array
    {
        return [
            'CONTENT_TYPE' => 'application/json',
        ];
    }

    protected function post(string $url, array $params): void
    {
        $this->browser->request(
            'POST',
            $url,
            [],
            [],
            $this->headers(),
            (string) json_encode($params)
        );
    }

    protected function put(string $url, array $params): void
    {
        $this->browser->request(
            'PUT',
            $url,
            [],
            [],
            $this->headers(),
            (string) json_encode($params)
        );
    }

    protected function get(string $uri, array $params = []): void
    {
        $this->browser->request(
            'GET',
            $uri,
            $params,
            [],
            $this->headers()
        );
    }

    protected function responseData()
    {
        return json_decode($this->response()->getContent(), true);
    }

    protected function response(): Response
    {
        return $this->browser->getResponse();
    }
}
