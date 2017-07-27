<?php

namespace pithyone\zhihu\crawler;


use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use QL\QueryList;

/**
 * Class Application
 *
 * @property \pithyone\zhihu\crawler\Answer     $answer
 * @property \pithyone\zhihu\crawler\Collection $collection
 * @property \pithyone\zhihu\crawler\MonthlyHot $monthlyHot
 * @property \pithyone\zhihu\crawler\Question   $question
 *
 * @package pithyone\shouqu
 */
class Application
{
    /**
     * @var array
     */
    protected $classes = [
        'answer'     => Answer::class,
        'collection' => Collection::class,
        'monthlyHot' => MonthlyHot::class,
        'question'   => Question::class,
    ];

    /**
     * @var array
     */
    protected $config = [
        'debug' => true
    ];

    /**
     * Application constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);

        $this->initializeLogger();
    }

    /**
     * Initialize logger.
     */
    private function initializeLogger()
    {
        $logger = new Logger('ZhihuCrawler');

        if (!$this->config['debug']) {
            $handler = new NullHandler();
        } elseif ($logFile = $this->config['log']['file']) {
            $handler = new StreamHandler($logFile);
        } else {
            $handler = new NullHandler();
        }

        $logger->pushHandler($handler);

        Log::setLogger($logger);

        QueryList::setLog($handler);
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws RuntimeException
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function __get($name)
    {
        if (isset($this->classes[$name])) {
            $class = $this->classes[$name];

            return new $class(new Query(), new Http());
        } else {
            throw new RuntimeException("Identifier '{$name}' is not defined.");
        }
    }
}