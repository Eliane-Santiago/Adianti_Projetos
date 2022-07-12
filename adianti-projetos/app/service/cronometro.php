<?php
class Cronometro extends TElement
{
    public function __contruct(){

        parent:: __contruct();

        $html->enableSection('main');
    }
}

    TStyle::importFromFile('vendor/adianti/plugins/src/Accordion/accordion.css');
    TScript::importFromFile('vendor/adianti/plugins/src/Accordion/accordion.js');