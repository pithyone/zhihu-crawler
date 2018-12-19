<?php

namespace ZhihuCrawler\Tests;

use Goutte\Client;
use Symfony\Component\BrowserKit\Response;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function createClient($status = 200)
    {
        $response = $this->createCompatibleMock(Response::class);
        $response->expects($this->once())->method('getStatus')->willReturn($status);

        $client = $this->createCompatibleMock(Client::class);
        $client->expects($this->once())->method('getInternalResponse')->willReturn($response);

        return $client;
    }

    protected function createCompatibleMock($originalClassName)
    {
        if (is_callable([$this, 'createMock'])) {
            return $this->createMock($originalClassName);
        } elseif (is_callable([$this, 'getMock'])) {
            return $this->getMock($originalClassName);
        } else {
            throw new \InvalidArgumentException();
        }
    }
}
