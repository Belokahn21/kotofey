<?php

namespace app\widgets;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $tag = 'div';
    public $options = ['class' => 'breadcrumb', "itemscope itemtype" => "http://schema.org/BreadcrumbList"];
    public $itemTemplate = "<div class='breadcrumb__step' itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\">{link}</div>";
    public $activeItemTemplate = "<div itemprop=\"itemListElement\" itemscope itemtype=\"http://schema.org/ListItem\" class=\"breadcrumb__step breadcrumb__step--active\">{link}</div>";
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