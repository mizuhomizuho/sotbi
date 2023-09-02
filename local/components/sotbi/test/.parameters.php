<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
    'PARAMETERS' => [
        'IBLOCK_ID' => [
            'NAME' => 'ID инфоблока',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ],
        'API_KEY' => [
            'NAME' => 'API key',
            'PARENT' => 'BASE',
            'TYPE' => 'STRING',
            'DEFAULT' => '',
        ],
        'CACHE_TIME' => [
            'DEFAULT' => '36000000',
        ],
    ],
);
