<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class TestmoduleTestComponent extends \CBitrixComponent
{
    public function executeComponent() {
        if ($this->StartResultCache()) {
            $this->includeComponentTemplate();
        }
    }
}