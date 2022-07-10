<?php

class Cronometro extends TPage{

           
    public function __construct(){

        parent:: __construct();
        //parent:: setTitle("Cronômetro");
        //parent:: setSize(400,200);

        $html = new THtmlRenderer('app/resources/cronometro.html');

        $replaces = [];
        $replaces['title']  = 'Título';
        $replaces['body']   = 'Corpo';
        $replaces['footer'] = 'Rodapé';  
        
        $html->enableSection('main', $replaces);

        parent::add($html);
       
    }


   

    

}






?>