<?php

return [
    'cityFolder' => [
        'file' => 'cityfolder',
        'description' => 'cityFolder snippet to list cities',
        'properties' => [
            'tpl' => [
                'type' => 'textfield',
                'value' => 'tpl.cityFolder.city',
            ],
            'sortby' => [
                'type' => 'textfield',
                'value' => 'id',
            ],
            'sortdir' => [
                'type' => 'list',
                'options' => [
                    ['text' => 'ASC', 'value' => 'ASC'],
                    ['text' => 'DESC', 'value' => 'DESC'],
                ],
                'value' => 'ASC',
            ],
            'limit' => [
                'type' => 'numberfield',
                'value' => 10,
            ],
            'outputSeparator' => [
                'type' => 'textfield',
                'value' => "\n",
            ],
            'toPlaceholder' => [
                'type' => 'combo-boolean',
                'value' => false,
            ],
        ],
    ],
];