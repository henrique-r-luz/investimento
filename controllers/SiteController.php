<?php

namespace app\controllers;

use app\models\dashboard\DashBoardSearch;
use app\models\dashboard\GraficoAcaoPais;
use app\models\dashboard\GraficoAcoes;
use app\models\dashboard\GraficoAtivo;
use app\models\dashboard\GraficoCategoria;
use app\models\dashboard\GraficoFiis;
use app\models\dashboard\GraficoPais;
use app\models\dashboard\GraficoTipo;
use app\models\financas\Proventos;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use const YII_ENV_TEST;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                // 'class' => ActionException::class,
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $dashBoardSearch = new DashBoardSearch();
        $dados = $dashBoardSearch->search();
        $graficoCategoria = new GraficoCategoria($dados);
        $graficoTipo = new GraficoTipo($dados);
        $graficoPais = new GraficoPais($dados);
        $graficoAtivo = new GraficoAtivo($dados);
        $graficoAcaoPais = new GraficoAcaoPais($dados);
        $graficoAcoes = new GraficoAcoes($dados);
        $graficoFii = new GraficoFiis($dados);
        $formatter = Yii::$app->formatter;
        $patrimonioBruto = 0;
        $valorCompra = 0;
        $proventos = $formatter->asCurrency(Proventos::find()->sum('valor'));
        if (!empty($dados)) {
            $patrimonioBruto = $formatter->asCurrency($dados[0]['valor_total']);
            $valorCompra = $formatter->asCurrency($dados[0]['valor_compra']);
            $lucro = $formatter->asCurrency($dados[0]['valor_total'] - $dados[0]['valor_compra']);
        }

        return $this->render('index', [
                    'dadosCategoria' => $graficoCategoria->montaGrafico(), //$indexService->getDadosCategoria(),
                    'dadosPais' => $graficoPais->montaGrafico(),
                    'dadosAtivo' => $graficoAtivo->montaGrafico(),
                    'dadosTipo' => $graficoTipo->montaGrafico(),
                    'dadosAcoes' => $graficoAcoes->montaGrafico(),
                    'patrimonioBruto' => $patrimonioBruto,
                    'valorCompra' => $valorCompra,
                    'lucro_bruto' => $lucro,
                    'proventos'=>$proventos,
                    'dadosAcoesPais' => $graficoAcaoPais->montaGrafico(),
                    'dadosFiis'=>$graficoFii->montaGrafico(),
        ]);
    }

}
