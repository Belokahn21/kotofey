<?php

namespace app\modules\catalog\models\entity\virtual;

use app\modules\catalog\models\entity\Product;
use yii\elasticsearch\ActiveRecord;

class ProductElastic extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'name'];
    }

    public function rules()
    {
        return [
            ['id', 'integer'],
            ['name', 'string'],
        ];
    }

    public static function mapping()
    {
        return [
            // Типы полей: https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html#field-datatypes
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => ['type' => 'text', 'analyzer' => 'my_analyzer'],
                'feed' => ['type' => 'text', 'analyzer' => 'my_analyzer'],
//                'name' => ['type' => 'text', 'analyzer' => 'russian'],
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
                        'my_synonym_filter' => [
                            'type' => 'synonym',
                            'synonyms' => [
                                'силикагель, силикагелевый',
                                'роял, royal, рояль',
                                'canon, canin, канин',
                                'hills, хилс',
                            ],
                        ],

                    ],
                    'analyzer' => [
                        'my_analyzer' => [
                            "type" => "custom",
                            "tokenizer" => "standard",
//                            "char_filter" => [
//                                "my_mappings_char_filter"
//                            ],
                            'filter' => [
                                'lowercase',
                                'russian_stop',
                                'russian_keywords',
                                'russian_stemmer',
                                'my_synonym_filter',
                            ],
                        ]
                    ],
//                    "char_filter" => [
//                        "my_mappings_char_filter" => [
//                            "type" => "mapping",
//                            "mappings" => [
//                                "`" => "",
//                                "''" => "",
//                            ]
//                        ],
//                    ]
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

    public function fillAttributes(Product $product)
    {
        // already exist, not do rewrite
        if (!$this->_id) $this->_id = $product->id;
        if (!$this->id) $this->id = $product->id;

        $this->name = $product->name;
    }
}