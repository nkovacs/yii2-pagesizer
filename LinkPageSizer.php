<?php

namespace nkovacs\pagesizer;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\base\Widget;
use yii\data\Pagination;

/**
 * LinkPageSizer displays a list of hyperlinks that lead to different page sizes of a target.
 *
 * LinkPageSizer works with a [[Pagination]] object which specifies the total number
 * of pages and the current page number.
 *
 * Note that LinkPageSizer only generates the necessary HTML markups. In order for it
 * to look like a real pager, you should provide some CSS styles for it.
 * With the default configuration, LinkPageSizer should look good using Twitter Bootstrap CSS framework.
 */
class LinkPageSizer extends Widget
{
    /**
     * @var Pagination the pagination object that this pager is associated with.
     * You must set this property in order to make LinkPageSizer work.
     */
    public $pagination;

    /**
     * @var array available page sizes. Array keys are sizes, values are labels.
     */
    public $availableSizes = [10 => '10', 20 => '20', 50 => '50'];
    /**
     * @var array HTML attributes for the pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'pagination'];
    /**
     * @var array HTML attributes for the link in a pager container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $linkOptions = [];
    /**
     * @var string the CSS class for the active (currently selected) page size button.
     */
    public $activePageSizeCssClass = 'active';

    /**
     * Initializes the pager.
     */
    public function init()
    {
        if ($this->pagination === null) {
            throw new InvalidConfigException('The "pagination" property must be set.');
        }
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page size buttons.
     */
    public function run()
    {
        echo $this->renderPageSizeButtons();
    }

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageSizeButtons()
    {
        if (count($this->availableSizes) === 0) {
            return '';
        }

        $buttons = [];
        $currentPageSize = $this->pagination->getPageSize();

        foreach ($this->availableSizes as $size => $label) {
            $buttons[]=$this->renderPageSizeButton($label, $size, null, $size==$currentPageSize);
        }

        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }

    /**
     * Renders a page size button.
     * You may override this method to customize the generation of page size buttons.
     * @param string $label the text label for the button
     * @param integer $pageSize the page size
     * @param string $class the CSS class for the page button.
     * @param boolean $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderPageSizeButton($label, $pageSize, $class, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageSizeCssClass);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page-size'] = $pageSize;

        return Html::tag('li', Html::a($label, PageSize::createSizeUrl($this->pagination, $pageSize), $linkOptions), $options);
    }
}
