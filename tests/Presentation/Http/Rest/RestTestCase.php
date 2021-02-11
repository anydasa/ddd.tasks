<?php

namespace Test\Presentation\Http\Rest;

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

    protected function post($url, $params): void
    {
        $this->browser->request(
            'POST',
            $url,
            [],
            [],
            $this->headers(),
            (string) \json_encode($params)
        );
    }

    protected function responseData()
    {
        return \json_decode($this->response()->getContent(), true);
    }

    protected function response(): Response
    {
        return $this->browser->getResponse();
    }
}
