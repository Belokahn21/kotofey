<?php
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 12:59
 */

namespace app\widgets;


use yii\helpers\Html;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $options = ['class' => 'breadcrumbs', "itemscope itemtype" => "http://schema.org/BreadcrumbList"];
    public $itemTemplate = "<li class='breadcrumb__item' itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\">{link}</li>";
    public $activeItemTemplate = "<li itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\" class=\"breadcrumb__item active\">{link}</span></li>";
    public $encodeLabels = false;

    private $position = 0;

    protected function renderItem($link, $template)
    {

        if (!array_key_exists('label', $link)) {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        $this->position++;

        $link['label'] = Html::tag('span', $link['label'] . Html::tag('span', "", ['itemprop' => 'position', 'content' => $this->position]), ['itemprop' => "name"]);
        $link['itemprop'] = 'item';

        return parent::renderItem($link, $template);
    }
}