<?php

class VendasDocument extends TPage
{
    private static $database = 'estoque';
    private static $activeRecord = 'Vendas';
    private static $primaryKey = 'id';
    private static $htmlFile = 'app/documents/VendasDocumentTemplate.html';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {

    }

    public static function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $class = self::$activeRecord;
            $object = new $class($param['key']);

            $html = new AdiantiHTMLDocumentParser(self::$htmlFile);
            $html->setMaster($object);

            $criteria_ItensVendas_vendas_id = new TCriteria();
            $criteria_ItensVendas_vendas_id->add(new TFilter('vendas_id', '=', $param['key']));

            $objectsItensVendas_vendas_id = ItensVendas::getObjects($criteria_ItensVendas_vendas_id);
            $html->setDetail('ItensVendas.vendas_id', $objectsItensVendas_vendas_id);

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

            $html->process();

            $html->saveAsPDF($document, $pageSize, 'portrait');

            TTransaction::close();

            if(empty($param['returnFile']))
            {
                parent::openFile($document);

                new TMessage('info', _t('Document successfully generated'));    
            }
            else
            {
                return $document;
            }
        } 
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }

}

