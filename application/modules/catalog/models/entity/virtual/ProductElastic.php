<?php

namespace app\modules\catalog\models\entity\virtual;

use yii\elasticsearch\ActiveRecord;

class ProductElastic extends ActiveRecord
{
    public function attributes()
    {
        return ['name'];
    }

    public function rules()
    {
        return [
            ['name', 'string']
        ];
    }

    public static function mapping()
    {
        return [
            // Типы полей: https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html#field-datatypes
            'properties' => [
                'name' => ['type' => 'text', 'analyzer' => 'my_analyzer'],
            ]
        ];
    }

    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->createIndex(static::index(), [
            //'aliases' => [ /* ... */ ],
            'mappings' => static::mapping(),
            'settings' => [
                'analysis' => [
                    'filter' => [
                        'russian_stop' => [
                            'type' => 'stop',
                            'stopwords' => '_russian_',
                        ],
                        'russian_keywords' => [
                            'type' => 'keyword_marker',
                            'keywords' => ['пример'],
                        ],
                        'russian_stemmer' => [
                            'type' => 'stemmer',
                            'language' => 'russian',
                        ],
                    ],
                    'analyzer' => [
                        'my_analyzer' => [
                            "type" => "custom",
                            "tokenizer" => "standard",
                            'filter' => [
                                'lowercase',
                                'russian_stop',
                                'russian_keywords',
                                'russian_stemmer',
                            ]
                        ]
                    ]
                ]
            ],
        ]);
    }

    public static function deleteIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->deleteIndex(static::index(), static::type());
    }
}