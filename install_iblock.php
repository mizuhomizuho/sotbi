<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__;
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

class Test {
    
    private string $idIblockType = 'sotbitest';
    private string $codeIblock = 'sotbitest';
    private string $apiCodeIblock = 'sotbitest';
    private array $props = [];
            
    private function addIblockPropertys(int $iblockId): void {
        
        $props = [
            [
                'name' => 'Название объекта',
                'code' => 'sotbi_name',
            ],
            [
                'name' => 'Телефон',
                'code' => 'sotbi_phone',
            ],
            [
                'name' => 'Email',
                'code' => 'sotbi_email',
            ],
            [
                'name' => 'Координаты',
                'code' => 'sotbi_coordinates',
            ],
            [
                'name' => 'Город',
                'code' => 'sotbi_city',
            ],
        ];
        
        foreach ($props as $propsKey => $propsValue) {
        
            $iblockProperty = new CIBlockProperty;
            $arFields = [
                'NAME' => $propsValue['name'],
                'ACTIVE' => 'Y',
                'CODE' => $propsValue['code'],
                'PROPERTY_TYPE' => 'S',
                'IBLOCK_ID' => $iblockId,
            ];
            
            $propertyId = $iblockProperty->Add($arFields);
            
            $props[$propsKey]['id'] = $propertyId;
        }
        
        $this->props = $props;
    }
            
    private function addIblock(): bool|int {
        
        $ib = new CIBlock;
        
        $arFields = [
            'ACTIVE' => 'Y',
            'NAME' => 'Тест',
            'CODE' => $this->codeIblock,
            'API_CODE' => $this->apiCodeIblock,
            'IBLOCK_TYPE_ID' => $this->idIblockType,
            'SITE_ID' => 's1',
            'GROUP_ID' => [
                '2' => 'R'
            ],
        ];
        
        $iblockId = $ib->Add($arFields);
        
        if (is_numeric($iblockId)) {
            return (int) $iblockId;
        }
        
        return false;
    }
            
    private function addIblockItems(int $iblockId): void {
        
        $items = [
            [
                'name' => 'Координаты 1',
                'props' => [
                    [
                        'value' => 'Название объекта 1',
                        'code' => 'sotbi_name',
                    ],
                    [
                        'value' => 'Телефон 1',
                        'code' => 'sotbi_phone',
                    ],
                    [
                        'value' => 'Email 1',
                        'code' => 'sotbi_email',
                    ],
                    [
                        'value' => '55.76, 37.64',
                        'code' => 'sotbi_coordinates',
                    ],
                    [
                        'value' => 'Город 1',
                        'code' => 'sotbi_city',
                    ],
                ],
            ],
            [
                'name' => 'Координаты 2',
                'props' => [
                    [
                        'value' => 'Название объекта 2',
                        'code' => 'sotbi_name',
                    ],
                    [
                        'value' => 'Телефон 2',
                        'code' => 'sotbi_phone',
                    ],
                    [
                        'value' => 'Email 2',
                        'code' => 'sotbi_email',
                    ],
                    [
                        'value' => '55.77, 37.65',
                        'code' => 'sotbi_coordinates',
                    ],
                    [
                        'value' => 'Город 2',
                        'code' => 'sotbi_city',
                    ],
                ],
            ],
        ];
        
        $propParams = [];
        
        foreach ($this->props as $propParamsValue) {
            $propParams[$propParamsValue['code']] = $propParamsValue;
        }
        
        foreach ($items as $itemsValue) {
            
            $el = new CIBlockElement;
            
            $prop = [];
            
            foreach ($itemsValue['props'] as $itemsPropsValue) {
                
                $prop[$propParams[$itemsPropsValue['code']]['id']] = $itemsPropsValue['value'];
            }
            
            $arFields = [
                'IBLOCK_ID' => $iblockId,
                'PROPERTY_VALUES' => $prop,
                'NAME' => $itemsValue['name'],
                'ACTIVE' => 'Y',            // активен
            ];
            
            if ($productId = $el->Add($arFields)) {
                echo "\n" . 'New item ID: ' . $productId;
            }
            else {
                echo "\n" . 'Error: ' . $el->LAST_ERROR;
            }
        }
        
        echo "\n" . 'ID инфоблока: ' . $iblockId . "\n";
    }
            
    private function addIblockType(): bool {
        
        global $DB;
        
        $lang = \Bitrix\Main\Application::getInstance()->getContext()->getLanguage();

        $arFields = [
            'ID'=> $this->idIblockType,
            'SECTIONS'=>'Y',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>[
                $lang =>[
                    'NAME'=>'Тестовое задание',
                ],
            ],
        ];
        
        $obBlocktype = new CIBlockType;
        
        $DB->StartTransaction();
        
        $res = $obBlocktype->Add($arFields);
        
        if (!$res) {
            $DB->Rollback();
            echo "\n" . 'Error: '.$obBlocktype->LAST_ERROR . "\n";
        }
        else {
            $DB->Commit();
            return true;
        }
        
        return false;
    }
    
    function init(): void {
        
        \Bitrix\Main\Loader::includeModule('iblock');
        
        if ($this->addIblockType()) {
            if ($iblockId = $this->addIblock()) {
                $this->addIblockPropertys($iblockId);
                $this->addIblockItems($iblockId);
            }
        }
    }
}

(new Test())->init();
