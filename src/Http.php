<?php

namespace pithyone\zhihu\crawler;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Psr\Http\Message\ResponseInterface;

class Http
{
    /**
     * @var string
     */
    protected $baseUri;

    /**
     * @var array
     */
    protected $middlewares = [];

    const MAX_RETRIES = 3;

    /**
     * Http constructor.
     */
    public function __construct()
    {
        array_push($this->middlewares,
            Middleware::log(Log::getLogger(), new MessageFormatter()),
            Middleware::retry($this->decider())
        );
    }

    /**
     * @param string $baseUri
     *
     * @return $this
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;

        return $this;
    }

    /**
     * @param string $url
     * @param array  $query
     *
     * @return mixed|ResponseInterface
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get($url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * @param string $url
     * @param array  $options
     *
     * @return mixed|ResponseInterface
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function post($url, array $options = [])
    {
        $key = is_array($options) ? 'form_params' : 'body';

        return $this->request($url, 'POST', [$key => $options]);
    }

    /**
     * @param string $method
     * @param array  $param_arr
     *
     * @return mixed|\Psr\Http\Message\StreamInterface
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function response($method, $param_arr = [])
    {
        $method = strtolower($method);
        $body = call_user_func_array([$this, $method], $param_arr);

        if ($body instanceof ResponseInterface) {
            $body = $body->getBody();
        }

        return $body;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function request($url, $method = 'GET', $options = [])
    {
        $client = new Client([
            'base_uri' => $this->baseUri,
            'timeout'  => 5.0,
        ]);

        $method = strtoupper($method);
        $options['handler'] = $this->getHandler();
        $response = $client->request($method, $url, $options);

        return $response;
    }

    /**
     * @return HandlerStack
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function getHandler()
    {
        $stack = HandlerStack::create();

        foreach ($this->middlewares as $middleware) {
            $stack->push($middleware);
        }

        return $stack;
    }

    /**
     * @return \Closure
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    private function decider()
    {
        return function (
            $retries,
            Psr7Request $request,
            Psr7Response $response = null,
            RequestException $exception = null
        ) {
            if ($retries >= self::MAX_RETRIES) {
                return false;
            }

            if (!($this->isServerError($response) || $this->isConnectError($exception))) {
                return false;
            }

            Log::warning(sprintf(
                'Retrying %s %s %s/%s, %s',
                $request->getMethod(),
                $request->getUri(),
                $retries + 1,
                self::MAX_RETRIES,
                $response ? 'status code: '.$response->getStatusCode() : $exception->getMessage()
            ), [$request->getHeader('Host')[0]]);

            return true;
        };
    }

    /**
     * @param Psr7Response|null $response
     *
     * @return bool
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    private function isServerError(Psr7Response $response = null)
    {
        return $response && $response->getStatusCode() >= 500;
    }

    /**
     * @param RequestException|null $exception
     *
     * @return bool
     *
     * @author wangbing <pithyone@vip.qq.com>
     */
    private function isConnectError(RequestException $exception = null)
    {
        return $exception instanceof ConnectException;
    }
}
