<?php
/**
 * ImageHandler.php.
 *
 * @author  wangbing <pithyone@vip.qq.com>
 * @date    2017/8/19
 */

namespace pithyone\zhihu\crawler\Handler;

/**
 * Class ImageHandler.
 */
class ImageHandler extends AbstractHandler
{
    /**
     * @var string
     */
    protected $html;

    /**
     * ImageHandler constructor.
     *
     * @param string $html
     */
    public function __construct($html)
    {
        $this->html ?: $this->html = $html;
    }

    /**
     * {@inheritdoc}
     */
    protected function page()
    {
        return $this->html;
    }

    /**
     * {@inheritdoc}
     */
    protected function rules()
    {
        return [
            'image' => ['img', 'data-actualsrc'],
        ];
    }
}
