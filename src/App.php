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
use ZhihuCrawler\Extractors\QuestionAnswerExtractor;
use ZhihuCrawler\Extractors\QuestionExtractor;
use ZhihuCrawler\Model\QuestionAnswer;
use ZhihuCrawler\Model\Collection;
use ZhihuCrawler\Model\MonthlyHot;
use ZhihuCrawler\Model\Question;

/**
 * @property \ZhihuCrawler\Model\Collection $collection
 * @property \ZhihuCrawler\Model\MonthlyHot $monthlyHot
 * @property \ZhihuCrawler\Model\Question $question
 * @property \ZhihuCrawler\Model\QuestionAnswer $questionAnswer
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
        'questionAnswerExtractor' => QuestionAnswerExtractor::class,
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
        $this->registerCollection();
        $this->registerMonthlyHot();
        $this->registerQuestion();
        $this->registerQuestionAnswer();
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
            ->addArgument(new Reference('crawler'));

        foreach ($this->extractorsServices as $id => $class) {
            $this->containerBuilder->register($id, $class)
                ->setArguments([new Reference('crawler'), new Reference('answerExtractor')]);
        }
    }

    /**
     * @return void
     */
    protected function registerCollection()
    {
        $this->containerBuilder->register('collection', Collection::class)
            ->setArguments([new Reference('client'), new Reference('collectionExtractor')]);
    }

    /**
     * @return void
     */
    protected function registerMonthlyHot()
    {
        $this->containerBuilder->register('monthlyHot', MonthlyHot::class)
            ->setArguments([new Reference('client'), new Reference('monthlyHotExtractor')]);
    }

    /**
     * @return void
     */
    protected function registerQuestion()
    {
        $this->containerBuilder->register('question', Question::class)
            ->setArguments([new Reference('client'), new Reference('questionExtractor')]);
    }

    /**
     * @return void
     */
    protected function registerQuestionAnswer()
    {
        $this->containerBuilder->register('guzzleClient', GuzzleClient::class);

        $this->containerBuilder->register('questionAnswer', QuestionAnswer::class)
            ->setArguments([new Reference('guzzleClient'), new Reference('crawler'), new Reference('questionAnswerExtractor')]);
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
