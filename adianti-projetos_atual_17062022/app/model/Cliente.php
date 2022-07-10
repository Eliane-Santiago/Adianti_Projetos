<?php
/**
 * Cliente Active Record
 * @author  <your-name-here>
 */



class Cliente extends TRecord 
{
    const TABLENAME = 'cliente';
    const PRIMARYKEY= 'codigo';
    const IDPOLICY =  'max'; // {max, serial}
    
    //const CREATEDAT = 'created_at'; //Criando a data de criação do registro automaticamente
    //const UPDATEDAT = 'updated_at'; //Criando a data de atualização do registro automaticamente
    
    /**
     * Constructor method
     */
    public function __construct($codigo = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($codigo, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('rg_cnh');
        parent::addAttribute('cpf');
        parent::addAttribute('contato');
        parent::addAttribute('email');
        parent::addAttribute('genero');
    
       // parent::addAttribute('created_at'); 
        // parent::addAttribute('updated_at');
    }

    

}


