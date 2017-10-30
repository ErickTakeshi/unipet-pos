<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Cliente;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class SyncController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCliente($id = ''){
        if(!$id){
            $clientes = Cliente::find()->asArray()->all();
            return json_encode($clientes);
        }else{
            $cliente = Cliente::find()->where("id = $id")->asArray()->all();
            return json_encode($cliente);
        }        
    }
}
