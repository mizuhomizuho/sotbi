<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Page\Asset;

Asset::getInstance()->addString('<script src="https://api-maps.yandex.ru/2.1/?apikey=' . $arParams['API_KEY'] . '&lang=ru_RU" type="text/javascript"></script>');
