<?php

namespace ZhihuCrawler;

interface AnswerInterface
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getLink();

    /**
     * @return int
     */
    public function getVoteCount();

    /**
     * @return string
     */
    public function getAuthor();

    /**
     * @return string
     */
    public function getAuthorLink();

    /**
     * @return string
     */
    public function getAuthorBio();

    /**
     * @return string
     */
    public function getSummary();

    /**
     * @return array
     */
    public function getImageList();

    /**
     * @return int
     */
    public function getCreated();
}
