<?php

namespace app\widgets;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $tag = 'ul';
    public $options = ['class' => 'breadcrumbs', "itemscope itemtype" => "http://schema.org/BreadcrumbList"];
    public $itemTemplate = "<li class='breadcrumbs__item' itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\">{link}</li>";
    public $activeItemTemplate = "<div itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\" class=\"breadcrumbs__item breadcrumbs__item active\">{link}</div>";
    public $encodeLabels = false;

    protected function renderItem($link, $template)
    {
        if (!array_key_exists('label', $link)) {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        $link['itemprop'] = 'item';
        return parent::renderItem($link, $template);
    }
}