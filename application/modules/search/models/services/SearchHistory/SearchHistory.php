<?php


namespace app\modules\search\models\services\SearchHistory;


class SearchHistory
{
    public static function save($word)
    {
        $storage = new  SearchHistoryStorage();
        $old_queries = $storage->get();

        array_push($old_queries, $word);

        $storage->save($old_queries);
    }
}