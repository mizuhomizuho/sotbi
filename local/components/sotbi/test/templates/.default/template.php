<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

\Bitrix\Main\Loader::IncludeModule('iblock');

$ormClass = \Bitrix\Iblock\Iblock::wakeUp($arParams['IBLOCK_ID'])->getEntityDataClass();

$res = $ormClass::getList([
    'select' => [
        'sotbi_name',
        'sotbi_phone',
        'sotbi_email',
        'sotbi_coordinates',
        'sotbi_city',
    ]
]);

$items = $res->fetchAll();

if (!count($items)) {
    return;
}

?>

<div id="map" style="width: 100%; height: 400px"></div>

<script type="text/javascript">
    ymaps.ready(()=>{
        
        var myMap = new ymaps.Map("map", {
            center: [<?=$items[0]['IBLOCK_ELEMENTS_ELEMENT_SOTBITEST_sotbi_coordinates_VALUE']?>],
            zoom: 12
        });
        
        <?
            foreach ($items as $itemsValue) {
                ?>
                    var myPlacemark = new ymaps.Placemark([<?=$itemsValue['IBLOCK_ELEMENTS_ELEMENT_SOTBITEST_sotbi_coordinates_VALUE']?>], { 
                        balloonContent: '<b>Название объекта</b>: <?=htmlspecialchars($itemsValue['IBLOCK_ELEMENTS_ELEMENT_SOTBITEST_sotbi_name_VALUE'])?>'
                            + '<br><b>Телефон</b>: <?=htmlspecialchars($itemsValue['IBLOCK_ELEMENTS_ELEMENT_SOTBITEST_sotbi_phone_VALUE'])?>' 
                            + '<br><b>Email</b>: <?=htmlspecialchars($itemsValue['IBLOCK_ELEMENTS_ELEMENT_SOTBITEST_sotbi_email_VALUE'])?>' 
                            + '<br><b>Координаты</b>: <?=htmlspecialchars($itemsValue['IBLOCK_ELEMENTS_ELEMENT_SOTBITEST_sotbi_coordinates_VALUE'])?>' 
                            + '<br><b>Город</b>: <?=htmlspecialchars($itemsValue['IBLOCK_ELEMENTS_ELEMENT_SOTBITEST_sotbi_city_VALUE'])?>' 
                    }, {
                        preset: 'twirl#blueStretchyIcon'
                    });
                    myMap.geoObjects.add(myPlacemark);
                <?
            }
        ?>
        
        myMap.geoObjects.add(myPlacemark);
    });
    
</script>

<script>
    
    
//    var myMap = new ymaps.Map ('myMap', {
//        center: [55.75, 37.61],
//        zoom: 3
//    });
//    var myPlacemark = new ymaps.Placemark([55.76, 37.64], { 
//        iconContent: 'Москва', 
//        balloonContent: 'Столица России' 
//    }, {
//        preset: 'twirl#blueStretchyIcon'
//    });
//    myMap.geoObjects.add(myPlacemark);
</script>



<script src="https://api-maps.yandex.ru/2.1/?apikey=edd21fd7-f979-4717-8780-3cde4862476f&lang=ru_RU" type="text/javascript"></script>


