<?php

namespace ZhihuCrawler;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DomCrawler\Crawler;
use ZhihuCrawler\Extractors\AnswerExtractor;
use ZhihuCrawler\Extractors\CollectionExtractor;
use ZhihuCrawler\Extractors\MonthlyHotExtractor;
use ZhihuCrawler\Extractors\QuestionExtractor;
use ZhihuCrawler\Model\Answer;
use ZhihuCrawler\Model\Collection;
use ZhihuCrawler\Model\MonthlyHot;
use ZhihuCrawler\Model\Question;

/**
 * @property \ZhihuCrawler\Model\Answer $answer
 * @property \ZhihuCrawler\Model\Collection $collection
 * @property \ZhihuCrawler\Model\MonthlyHot $monthlyHot
 * @property \ZhihuCrawler\Model\Question $question
 */
class App
{
    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    /**
     * @var array
     */
    private $extractorsServices = [
        'collectionExtractor' => CollectionExtractor::class,
        'monthlyHotExtractor' => MonthlyHotExtractor::class,
        'questionExtractor' => QuestionExtractor::class
    ];

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->containerBuilder = new ContainerBuilder();

        $this->registerClient();
        $this->registerCrawler();
        $this->registerExtractors();
        $this->registerAnswer();
        $this->registerCollection();
        $this->registerMonthlyHot();
        $this->registerQuestion();
    }

    /**
     * @return void
     */
    protected function registerClient()
    {
        $this->containerBuilder->register('client', Client::class);
    }

    /**
     * @return void
     */
    protected function registerCrawler()
    {
        $this->containerBuilder->register('crawler', Crawler::class);
    }

    /**
     * @return void
     */
    protected function registerExtractors()
    {
        $this->containerBuilder->register('answerExtractor', AnswerExtractor::class)
            ->addMethodCall('setCrawler', [new Reference('crawler')]);

        foreach ($this->extractorsServices as $id => $class) {
            $this->containerBuilder->register($id, $class)
                ->addMethodCall('setCrawler', [new Reference('crawler')])
                ->addMethodCall('setAnswerExtractor', [new Reference('answerExtractor')]);
        }
    }

    /**
     * @return void
     */
    protected function registerAnswer()
    {
        $this->containerBuilder->register('guzzleClient', GuzzleClient::class);

        $this->containerBuilder->register('answer', Answer::class)
            ->addArgument(new Reference('questionExtractor'))
            ->addMethodCall('setClient', [new Reference('guzzleClient')])
            ->addMethodCall('setCrawler', [new Reference('crawler')]);
    }

    /**
     * @return void
     */
    protected function registerCollection()
    {
        $this->containerBuilder->register('collection', Collection::class)
            ->addArgument(new Reference('collectionExtractor'))
            ->addMethodCall('setClient', [new Reference('client')]);
    }

    /**
     * @return void
     */
    protected function registerMonthlyHot()
    {
        $this->containerBuilder->register('monthlyHot', MonthlyHot::class)
            ->addArgument(new Reference('monthlyHotExtractor'))
            ->addMethodCall('setClient', [new Reference('client')]);
    }

    /**
     * @return void
     */
    protected function registerQuestion()
    {
        $this->containerBuilder->register('question', Question::class)
            ->addArgument(new Reference('questionExtractor'))
            ->addMethodCall('setClient', [new Reference('client')]);
    }

    /**
     * @param string $name
     * @return object
     * @throws \Exception
     */
    public function __get($name)
    {
        return $this->containerBuilder->get($name);
    }
}
