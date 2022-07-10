<?php
class FormularioCadastro extends TPage
{
    private $form;
    
    public function __construct()
    {
        parent::__construct();


        $this->form = new TForm('cad_form');
        
        $notebook = new TNotebook;
        $this->form->add($notebook);
        
        $table1 = new TTable;
        $table2 = new TTable;
        
        $table1->width = '100%';
        $table2->width = '100%';

        $table1->style = 'padding:10px';
        $table2->style = 'padding:10px';
        
        $notebook->appendPage('Dados Pessoais', $table1);
        $notebook->appendPage('Endereço', $table2);
        
        //Criando os Campos
        $codigo = new TEntry('codigo');
        $codigo -> setEditable(false);
        $nome = new TEntry('nome');
        $rg_cnh = new TEntry('rg_cnh');
        $cpf = new TEntry('cpf');
        $contato = new TEntry('contato');
        $email = new TEntry('email');
        $logradouro = new TEntry('logradouro');
        $numero = new TEntry('numero');
        $completo = new TEntry('complemento');
        $bairro = new TEntry('bairro');

        
        //Adicionando Mascara
        $cpf->setMask('999.999.999-99');
        $contato->setMask('(99)9999-9999');

        //Ajustando o tamanho do Campo
        $codigo -> setSize(100);
        $nome-> setSize(800);
        $rg_cnh-> setSize(200);
        $cpf-> setSize(200);
        $contato-> setSize(200);
        $email-> setSize(400);
        $logradouro-> setSize(800);
        $numero-> setSize(100);
        $completo-> setSize(200);
        $bairro-> setSize(200);

        //Criando os nomes dos Campos
        $table1->addRowSet( new TLabel('Código'), $codigo );
        $table1->addRowSet( new TLabel('Nome'), $nome );
        $table1->addRowSet( new TLabel('RG/CNH'), $rg_cnh );
        $table1->addRowSet( new TLabel('CPF'), $cpf );
        $table1->addRowSet( new TLabel('Contato'), $contato );
        $table1->addRowSet( new TLabel('E-mail'), $email );

        $table2->addRowSet( new TLabel('Logradouro'), $logradouro );
        $table2->addRowSet( new TLabel('Número'), $numero );
        $table2->addRowSet( new TLabel('Complemento'), $completo );
        $table2->addRowSet( new TLabel('Bairro'), $bairro );
        
        /*
        //Criando o botão Forma 1
        $botao = new TButton('enviar');
        $botao->setAction( new TAction( [$this, 'onSend']), 'Enviar');
        $botao->setImage('fa:save');
        */

        //Criando o botão Forma 1
        $botaoSalvar = new TButton('salvar');
        $botaoSalvar->setAction( new TAction( [$this, 'onSave']), 'Salvar'); // Validar o formulário
        $botaoSalvar->setImage('fa:save green');

        $botaoLimpar = new TButton('limpar');
        $botaoLimpar->setAction( new TAction( [$this, 'onClear']), 'Limpar'); // não validar o formulário
        $botaoLimpar->setImage('fa:eraser red');
        
        /*
        //Criando o botão Forma 2 (NÃO FUNCIONOU)
        $this->form->addAction('Salvar', new TAction([$this, 'onSave']), 'fa:save green'); // Validar o formulário
        $this->form->addActionLink('Limpar', new TAction([$this, 'onClear']), 'fa:eraser red'); // não validar o formulário
        */
        

        $this->form->setFields( [ $codigo, $nome, $rg_cnh, $cpf, $contato, $email, $logradouro, $numero, $completo, $bairro, $botaoSalvar, $botaoLimpar ] );
        
        //Validação dos campos
        $nome->addValidation('NOME', new TRequiredValidator); // informa que o campo é obrigatório
        $rg_cnh->addValidation('RG/CNH', new TRequiredValidator); // informa que o campo é obrigatório
        $cpf->addValidation('CPF', new TRequiredValidator); // informa que o campo é obrigatório
        $nome->addValidation('NOME', new TRequiredValidator); // informa que o campo é obrigatório
        $cpf ->addValidation('CPF', new TMaxLengthValidator, [14]); //Quantidade máximo de caractere de um campo
        //$codigo->addValidation('codigo', new TMinValueValidator, [2]); //o valor mínimo que um campo pode receber
        //$codigo->addValidation('codigo', new TMaxValueValidator, [20]); //o valor máxima que um campo pode receber
        //$codigo->addValidation('Codigo', new TMinLengthValidator, [3]); //quantidade mínimo de caractere de um campo

        $panel = new TPanelGroup('Cadastro');
        $panel->add($this->form);
        $panel->addFooter($botaoSalvar);
        $panel->addFooter($botaoLimpar);
        
        parent::add($panel);

    }
    
    /*
    //Método do Botão ENVIAR
    public function onSend($param)
    {

        try
        {

        $data = $this->form->getData();
        
        //$this->form->Data( $data );

        $this->form->validate( );
        
        new TMessage('info', str_replace(',', '<br>', json_encode($data)));

        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        }
        catch(Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }

    }
    */ 

    //Método do Botão SALVAR
    public function onSave($param)
    {

        try{

            TTransaction::open('adianti_cadastro'); //Abrindo a conexão com o bd

            $conn = TTransaction::get(); // pegar dados

            $this->form->validate(); // Validação Formulário

            $data = $this->form->getData();

            //Criando um objeto novo
            $cliente = new Cliente; 

            //Alimentando Dados do Objeto criado
            $cliente->fromArray((array) $data); //Convertendo $date para Array 
            $cliente->store(); //Armazendo no BD 

            $this->form->setData($cliente);

            //TTransaction::Tump();

            /*
            //INSERINDO O CLIENTE MANUALMENTE
            $conn->query("INSERT INTO cliente (
                CODIGO, 
                NOME, 
                RG_CNH, 
                CPF, 
                CONTATO, 
                EMAIL)
                values(
                    ' ', 
                    'Eliane',
                    '4005026389554', 
                    '23699856412',
                    '85963232541', 
                    'eliane@gmail.com'
                    )"); // colocar os comandos

            $conn->query("INSERT INTO cliente (
                CODIGO, 
                NOME, 
                RG_CNH, 
                CPF, 
                CONTATO, 
                EMAIL)
                values(
                    ' ', 
                    'Rangel',
                    '6003050143692', 
                    '36896335532',
                    '85963232565', 
                    'Rangel@gmail.com'
                    )");

            $conn->query("INSERT INTO cliente (
                CODIGO, 
                NOME, 
                RG_CNH, 
                CPF, 
                CONTATO, 
                EMAIL)
                values(
                    ' ', 
                    'Aparecida',
                    '5002032252621', 
                    '06965753328',
                    '85963603941', 
                    'aparecida@gmail.com'
                    )");
            */
            
            /*  
            // INSERINDO O CLIENTE VIA OBJETO       
            $cliente = new Cliente;
            $cliente->nome = 'Rangel';
            $cliente->rg_cnh = '3004685266987';
            $cliente->cpf = '36952486698';
            $cliente->contato = '85999663328';
            $cliente->email = 'rangel@gmail.com';
            $cliente->store();
            

            $cliente = new Cliente;
            $cliente->nome = 'Amanda';
            $cliente->rg_cnh = '6003080985469';
            $cliente->cpf = '36953695587';
            $cliente->contato = '85999563658';
            $cliente->email = 'amanda@gmail.com';
            $cliente->store();
            

            $cliente = new Cliente;
            $cliente->nome = 'Eliane';
            $cliente->rg_cnh = '9005042366567';
            $cliente->cpf = '23623556657';
            $cliente->contato = '85999563670';
            $cliente->email = 'eliane@gmail.com';
            $cliente->store();
            */

            /*
            //Exibe o objeto como Array
            echo '<pre>';
            print_r ($cliente-> toArray());
            echo '</pre>';
            */
            
            /*
            $cadCliente = [];
            $cadCliente ['nome'] = 'Eliane';
            $cadCliente ['rg_cnh'] = '3698523569857';
            $cadCliente ['cpf'] = '69856987792';
            $cadCliente ['contato'] = '85969786965';
            $cadCliente ['email'] = 'eliane@mail.com';

            
            //Exibe o objeto como Array
            echo '<pre>';
            print_r ($cadCliente-> toArray());
            echo '</pre>';
            */

            /*
            $cliente = new Cliente;
            $cliente= fromArray($cadCliente);
            $cliente-> store();
            */

            //Menssagem
            new TMessage('info','Registro Salvo com Sucesso!');

            TTransaction::close(); //Fechando a conexão com o banco de dados

        } 
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback(); //Desfazendo transações no BD
        }
    }



    //Método Limpar
    public function onClear()
    {
        $this->form->clear(true); // PARAMETRO TRUE -> MANTEM UM CAMPO COM RESGITRO PERMANENTE NÃO APAGA (Defauld)
    }

    //Método Editar
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('adianti_cadastro');

              //Verificar se o codigo do registro está vendo na url
              if (isset($param['codigo'])) 
              {
                $key = $param['codigo'];
                $cliente = new Cliente($key);
                $this-form->setData($cliente);

              } 
              else
                {
                    $this->form-clear(true);
                }


            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }


}

