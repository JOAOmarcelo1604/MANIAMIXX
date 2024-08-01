<?php

class ItensVendasForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'estoque';
    private static $activeRecord = 'ItensVendas';
    private static $primaryKey = 'id';
    private static $formName = 'form_ItensVendasForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de itens vendas");

        $criteria_vendas_id = new TCriteria();
        $criteria_produto_id = new TCriteria();

        $id = new TEntry('id');
        $descricao = new TEntry('descricao');
        $quantidade = new TEntry('quantidade');
        $preco_unitario = new TEntry('preco_unitario');
        $preco_total = new TEntry('preco_total');
        $vendas_id = new TDBCombo('vendas_id', 'estoque', 'Vendas', 'id', '{clientes->nome}','id asc' , $criteria_vendas_id );
        $produto_id = new TDBCombo('produto_id', 'estoque', 'Produto', 'id', '{nome}','id asc' , $criteria_produto_id );

        $vendas_id->addValidation("Vendas id", new TRequiredValidator()); 

        $id->setEditable(false);
        $vendas_id->enableSearch();
        $produto_id->enableSearch();

        $id->setSize(100);
        $descricao->setSize('100%');
        $vendas_id->setSize('100%');
        $quantidade->setSize('100%');
        $produto_id->setSize('100%');
        $preco_total->setSize('100%');
        $preco_unitario->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel("Descricao:", null, '14px', null)],[$descricao]);
        $row3 = $this->form->addFields([new TLabel("Quantidade:", null, '14px', null)],[$quantidade]);
        $row4 = $this->form->addFields([new TLabel("Preco unitario:", null, '14px', null)],[$preco_unitario]);
        $row5 = $this->form->addFields([new TLabel("Preco total:", null, '14px', null)],[$preco_total]);
        $row6 = $this->form->addFields([new TLabel("Cliente:", null, '14px', null)],[$vendas_id]);
        $row7 = $this->form->addFields([new TLabel("Produto:", null, '14px', null)],[$produto_id]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ItensVendasHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new ItensVendas(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('ItensVendasHeaderList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 
        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new ItensVendas($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

