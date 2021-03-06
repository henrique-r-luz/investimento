<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

/**
 * Description of Sincronizafactory
 *
 * @author henrique
 */
class SincronizaFactory {

    //put your code here
    public static function sincroniza($tipo) {

        switch ($tipo) {
            case 'cambio':
                return self::getCambio();
            case 'cambioApi':
                return self::getCambioApi();
            case 'acao':
                return self::getAcao();
             case 'acaoApi':
                return self::getAcaoApi();
            case 'easy':
                return self::getEasy();
            case 'empresa':
                return self::getEmpresa();
            case 'operacaoClear':
                return self::getOperacaoClear();
            case 'banco_inter':
                return self::getBancoInter();
        }
    }

    private function getAcao() {
        return new CotacoesAcao();
    }
    
    private function getAcaoApi() {
        return new CotacoesAcaoApi();
    }

    private function getCambio() {
        return new CotacaoCambio();
    }
    
    private function getCambioApi() {
        return new CotacaoCambioApi();
    }


    private function getEasy() {
        return new CotacaoEasy();
    }

    private function getEmpresa() {
        return new InseriEmpresasBolsa();
    }

    private function getOperacaoClear() {
        return new OperacaoClear();
    }

    private function getBancoInter() {
        return new BancoInter();
    }

}
