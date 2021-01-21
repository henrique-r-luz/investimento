<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use app\lib\CajuiHelper;
use app\models\financas\Ativo;
use app\models\financas\Operacao;
use Yii;

/**
 * Description of CotacoesAcao
 *
 * @author henrique
 */
class CotacoesAcao extends OperacoesAbstract{
    
    
    private $csv;
    private $erros;
    
    
    //put your code here
    public function atualiza() {
        
        foreach ($this->csv as $acoes) {
            $contErro = 0;
            $ativo = Ativo::findOne($acoes['id']);
            $valor = str_replace('.', '', $acoes['valor']);
            $valor = str_replace(',', '.', $valor);
            $valor = Ativo::valorCambio($ativo, $valor);

            $lucro = ($valor * $ativo->quantidade);
            $ativo->valor_bruto = $lucro;
            $ativo->valor_liquido = $lucro;
            $valorCompra = Ativo::valorCambio($ativo, Operacao::valorDeCompra($acoes['id']));
            $ativo->valor_compra = $valorCompra;

            if (!$ativo->save()) {
                $this->erros .= CajuiHelper::processaErros($ativo->getErrors()) . '</br>';
                $contErro++;
            }
        }
        if ($contErro == 0) {
            return [true, 'sucesso'];
        } else {
            return [false, 'erro:</br>' . $this->erros];
        }
        
    }

    public function getDados() {

        //$cotacaoCambio = new CotacaoCambio();
        $cambio = SincronizaFactory::sincroniza('cambio')->atualiza();

        $file = Yii::$app->params['bot'] . '/preco_acao.csv';
        if (!file_exists($file)) {
            return [true, 'sucesso'];
        }
        $this->csv = array_map('str_getcsv', file($file));
        $newkeys = array('id', 'valor');
        foreach ($this->csv as $id => $linha) {
            $this->csv[$id] = array_combine($newkeys, $linha); //recursive_change_key($linha, array('0' => 'cnpj', '1' => 'codigo','2'=>'nome','3'=>'setor'));
        }
        unset($this->csv[0]);
    }

}
