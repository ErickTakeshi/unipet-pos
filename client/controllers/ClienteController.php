<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
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
                ],
            ],
        ];
    }

    public function actionIndex(){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }else{
            $curl = curl_init('http://localhost/unipet-server/index.php/sync/cliente');

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            $retorno = curl_exec($curl);
            curl_close($curl);

            return $this->render('index', ['clientes' => json_decode($retorno, true)]);
        }
    }

    public function actionDelete($id){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }else{     
            $data['id'] = $id;
            $curl = curl_init('http://localhost/unipet-server/index.php/sync/cliente?id=' . $id);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); 
            curl_setopt($curl, CURLOPT_POSTFIELDS,    json_encode($data));
            $retorno = curl_exec($curl);
            curl_close($curl);

            if($retorno === 'success'){
                \Yii::$app->getSession()->setFlash('success', 'Registro excluído com sucesso');
            }else{
                \Yii::$app->getSession()->setFlash('danger', 'Falha ao excluir registro: ' . $retorno);
            }
            return $this->redirect(['cliente/index']);
        }
    }

    public function actionUpdate($id){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }else{
            $curl = curl_init('http://localhost/unipet-server/index.php/sync/cliente?id='.$id);

            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            $retorno = curl_exec($curl);
            curl_close($curl);

            return $this->render('update', ['cliente' => json_decode($retorno, true)]);
        }
    }

    public function actionIncluir(){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }else{
            return $this->render('incluir');
        }
    }
}
