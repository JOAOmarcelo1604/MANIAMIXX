<?php

class VendasBatchDocument extends TPage
{
    private static $database = 'estoque';
    private static $activeRecord = 'Vendas';
    private static $primaryKey = 'id';
    private static $htmlFile = 'app/documents/VendasDocumentTemplate.html';
    private static $formName = 'form_VendasBatchDocument';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct()
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("DOCUMENTO EM LOTE");

        $criteria_clientes_nome = new TCriteria();
        $criteria_produto_id = new TCriteria();

        $clientes_nome = new TDBCombo('clientes_nome', 'estoque', 'Clientes', 'id', '{nome}','id asc' , $criteria_clientes_nome );
        $data_venda = new TDateTime('data_venda');
        $produto_id = new TDBCombo('produto_id', 'estoque', 'Produto', 'id', '{id}','id asc' , $criteria_produto_id );
        $total_venda = new TEntry('total_venda');
        $forma_pagamento = new TEntry('forma_pagamento');
        $vendedor = new TEntry('vendedor');
        $lucro = new TEntry('lucro');
        $faturamento = new TEntry('faturamento');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $nome_produto = new TEntry('nome_produto');
        $quantidade = new TEntry('quantidade');

        $data_venda->setMask('dd/mm/yyyy hh:ii');
        $data_venda->setDatabaseMask('yyyy-mm-dd hh:ii');
        $forma_pagamento->setMaxLength(50);
        $produto_id->enableSearch();
        $clientes_nome->enableSearch();

        $lucro->setSize('100%');
        $valor->setSize('100%');
        $data_venda->setSize(150);
        $vendedor->setSize('100%');
        $produto_id->setSize('100%');
        $quantidade->setSize('100%');
        $total_venda->setSize('100%');
        $faturamento->setSize('100%');
        $nome_produto->setSize('100%');
        $clientes_nome->setSize('100%');
        $forma_pagamento->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Cliente:", null, '14px', null)],[$clientes_nome],[new TLabel("Data da Venda:", null, '14px', null)],[$data_venda]);
        $row2 = $this->form->addFields([new TLabel("Produto id:", null, '14px', null)],[$produto_id],[new TLabel("Total da Venda:", null, '14px', null)],[$total_venda]);
        $row3 = $this->form->addFields([new TLabel("Forma de Pagamento:", null, '14px', null)],[$forma_pagamento],[new TLabel("Nome Do Vendedor:", null, '14px', null)],[$vendedor]);
        $row4 = $this->form->addFields([new TLabel("Lucro:", null, '14px', null)],[$lucro],[new TLabel("Faturamento:", null, '14px', null)],[$faturamento]);
        $row5 = $this->form->addFields([new TLabel("Valor Do Produto:", null, '14px', null)],[$valor],[new TLabel("Nome do Produto:", null, '14px', null)],[$nome_produto]);
        $row6 = $this->form->addFields([new TLabel("Quantidade:", null, '14px', null)],[$quantidade],[],[]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongenerate = $this->form->addAction("Gerar", new TAction([$this, 'onGenerate']), 'fas:cog #ffffff');
        $this->btn_ongenerate = $btn_ongenerate;
        $btn_ongenerate->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(TBreadCrumb::create(["Estoque","DOCUMENTO EM LOTE"]));
        $container->add($this->form);

        parent::add($container);

    }

    public function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $data = $this->form->getData();
            $criteria = new TCriteria();

            if (isset($data->clientes_nome) AND ( (is_scalar($data->clientes_nome) AND $data->clientes_nome !== '') OR (is_array($data->clientes_nome) AND (!empty($data->clientes_nome)) )) ) 
            {

                $criteria->add(new TFilter('clientes_id', '=', $data->clientes_nome));
            }
            if (isset($data->data_venda) AND ( (is_scalar($data->data_venda) AND $data->data_venda !== '') OR (is_array($data->data_venda) AND (!empty($data->data_venda)) )) ) 
            {

                $criteria->add(new TFilter('data_venda', '=', $data->data_venda));
            }
            if (isset($data->produto_id) AND ( (is_scalar($data->produto_id) AND $data->produto_id !== '') OR (is_array($data->produto_id) AND (!empty($data->produto_id)) )) ) 
            {

                $criteria->add(new TFilter('produto_id', '=', $data->produto_id));
            }
            if (isset($data->total_venda) AND ( (is_scalar($data->total_venda) AND $data->total_venda !== '') OR (is_array($data->total_venda) AND (!empty($data->total_venda)) )) ) 
            {

                $criteria->add(new TFilter('total_venda', '=', $data->total_venda));
            }
            if (isset($data->forma_pagamento) AND ( (is_scalar($data->forma_pagamento) AND $data->forma_pagamento !== '') OR (is_array($data->forma_pagamento) AND (!empty($data->forma_pagamento)) )) ) 
            {

                $criteria->add(new TFilter('forma_pagamento', '=', $data->forma_pagamento));
            }
            if (isset($data->vendedor) AND ( (is_scalar($data->vendedor) AND $data->vendedor !== '') OR (is_array($data->vendedor) AND (!empty($data->vendedor)) )) ) 
            {

                $criteria->add(new TFilter('vendedor', '=', $data->vendedor));
            }
            if (isset($data->lucro) AND ( (is_scalar($data->lucro) AND $data->lucro !== '') OR (is_array($data->lucro) AND (!empty($data->lucro)) )) ) 
            {

                $criteria->add(new TFilter('lucro', '=', $data->lucro));
            }
            if (isset($data->faturamento) AND ( (is_scalar($data->faturamento) AND $data->faturamento !== '') OR (is_array($data->faturamento) AND (!empty($data->faturamento)) )) ) 
            {

                $criteria->add(new TFilter('faturamento', '=', $data->faturamento));
            }
            if (isset($data->valor) AND ( (is_scalar($data->valor) AND $data->valor !== '') OR (is_array($data->valor) AND (!empty($data->valor)) )) ) 
            {

                $criteria->add(new TFilter('valor', '=', $data->valor));
            }
            if (isset($data->nome_produto) AND ( (is_scalar($data->nome_produto) AND $data->nome_produto !== '') OR (is_array($data->nome_produto) AND (!empty($data->nome_produto)) )) ) 
            {

                $criteria->add(new TFilter('nome_produto', 'like', "%{$data->nome_produto}%"));
            }
            if (isset($data->quantidade) AND ( (is_scalar($data->quantidade) AND $data->quantidade !== '') OR (is_array($data->quantidade) AND (!empty($data->quantidade)) )) ) 
            {

                $criteria->add(new TFilter('quantidade', '=', $data->quantidade));
            }

            $objects = Vendas::getObjects($criteria, FALSE);
            if ($objects)
            {
                $output = '';

                $count = 1;
                $count_records = count($objects);

                foreach ($objects as $object)
                {

                    $html = new AdiantiHTMLDocumentParser(self::$htmlFile);
                    $html->setMaster($object);

                    $objectsItensVendas_vendas_id = ItensVendas::where('vendas_id', '=', $object->id)->load();

                    $html->setDetail('ItensVendas.vendas_id', $objectsItensVendas_vendas_id);

                    $html->process();

                    if ($count < $count_records)
                    {
                        $html->addPageBreak();
                    }

                    $content = $html->getContents();
                    $dom = pQuery::parseStr($content);
                    $body = $dom->query('body');

                    if($body->count() > 0)
                    {
                        $output .= $body->html();    
                    }
                    else 
                    {
                        $output .= $content;    
                    }

                    $count ++;
                }

                $dom = pQuery::parseStr(file_get_contents(self::$htmlFile));
                $body = $dom->query('body');
                if($body->count() > 0)
                {
                    $body->html('<div>{$body}</div>');
                    $html = $dom->html();

                    $output = str_replace('<div>{$body}</div>', $output, $html);
                }

                $document = 'tmp/'.uniqid().'.pdf'; 
                $html = AdiantiHTMLDocumentParser::newFromString($output);
                $html->saveAsPDF($document, 'A4', 'portrait');

                parent::openFile($document);
                new TMessage('info', _t('Document successfully generated'));
            }
            else
            {
                new TMessage('info', _t('No records found'));   
            }

            TTransaction::close();

            TSession::setValue(__CLASS__.'_filter_data', $data);

            $this->form->setData($data);

        } 
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    } 

    public function onShow($param = null)
    {

    }

}

