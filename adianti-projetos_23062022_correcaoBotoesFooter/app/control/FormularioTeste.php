<?php
class FormularioTeste extends TPage
{

    private $form;
    
    public function __construct()
    {
        parent::__construct();


        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Formulário');
        $this->form->setClientValidation(true); //Ligando a validação antes de carregar os dados no navegador (Validação do navegador)

        //Criando os objetos dos campos
        $codigo = new TEntry('codigo');
        $nome = new TEntry('nome');
        $rg_cnh = new TEntry('rg_cnh');
        $cpf = new TEntry('cpf');
        $contato = new TEntry('Contato');
        $email = new TEntry('email');
        $codigo->setEditable(false); //Desabilitando a edição do campo

        //$nome->setValue('Teste'); // Usar quando quiser deixar campo que informações permanentes (Defauld)

        //Adicionando os campos na tela
        // $this->form->addFields([Tlabel], [Input]); 
        //$this->form->addFields([NOME], [CAMPO]);
        $this->form->addFields([new TLabel('Código')], [$codigo]);
        $this->form->addFields([new TLabel('Nome')], [$nome]);
        $this->form->addFields([new TLabel('RG/CNH')], [$rg_cnh]);
        $this->form->addFields([new TLabel('CPF')], [$cpf]);
        $this->form->addFields([new TLabel('Contato')], [$contato]);
        $this->form->addFields([new TLabel('E-mail')], [$email]);

        //Validações  
        $nome->addValidation('Nome', new TRequiredValidator); //Campo obrigatório
        $rg_cnh->addValidation('RG/CNH', new TRequiredValidator); //Campo obrigatório
        $cpf->addValidation('CPF', new TRequiredValidator); //Campo obrigatório

        //Criando o botão Forma 2
        $this->form->addAction('Salvar', new TAction([$this, 'onSave']), 'fa:save green'); // Validar o formulário
        $this->form->addActionLink('Editar', new TAction([$this, 'onEdit']), 'fa:edit blue');
        $this->form->addActionLink('Limpar', new TAction([$this, 'onClear']), 'fa:eraser red'); // não validar o formulário


        //Adicionando o Formulario na tela
        parent::add($this->form); 
    }   



    //Método do Botão Salvar
    public function onSave($param)
    {

        try
        {
            TTransaction::open('adianti_cadastro');

                //Habilitando o método de validação do formulário
                $this->form->validate(); 

                //Pegando os dados do formulário
                $data = $this->form->getData(); 

                //Criando Objeto Novo
                $cliente = new Cliente;
                $cliente->fromArray((array) $data);
                $cliente->store();

                $this->form->setData( $cliente ); //deixar os dados na tela

                new TMessage('info', 'Registro Salvo com Sucesso');


            TTransaction::close();


        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
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
                $this->form->setData($cliente);

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