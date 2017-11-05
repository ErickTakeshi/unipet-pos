<?php

namespace app\controllers;

use Yii;
// use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Cliente;
use yii\rest\ActiveController;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class SyncController extends ActiveController
{
    public $modelClass = 'app\models\Cliente';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'cliente' => ['POST', 'GET', 'DELETE', 'PUT'],
                ],
            ],
        ];
    }

    public function actionCliente($id = ''){
        $request = Yii::$app->request;
        if($request->isPost){
            $cliente = new Cliente();
            $cliente->nome     = $request->post('nome');
            $cliente->cpf      = $request->post('cpf');
            $cliente->email    = $request->post('email');
            $cliente->rg       = $request->post('rg');
            $cliente->datanasc = $request->post('datanasc');
            $cliente->sexo     = $request->post('sexo');
            $cliente->telefone = $request->post('telefone');

            if($cliente->save()){
                return $this->redirect('http://localhost/unipet-client/index.php/cliente/index');
            }else{
                return $cliente->getErrors();
            }
        }else if($request->isPut){
            $cliente = Cliente::findOne($request->post('id'));
            $cliente->nome     = $request->post('nome');
            $cliente->cpf      = $request->post('cpf');
            $cliente->email    = $request->post('email');
            $cliente->rg       = $request->post('rg');
            $cliente->datanasc = $request->post('datanasc');
            $cliente->sexo     = $request->post('sexo');
            $cliente->telefone = $request->post('telefone');

            if($cliente->save()){
                return $this->redirect('http://localhost/unipet-client/index.php/cliente/index');
            }else{
                return $cliente->getErrors();
            }
        }else if($request->isDelete){
            if(!$id){
                return 'Parâmetro id obrigatório.';
            }else{
                if(Cliente::findOne($id)->delete()){
                    return 'success';
                }else{
                    return 'error';
                }
            }
        }else if($request->isGet){
            if(!$id){
                $clientes = Cliente::find()->asArray()->all();
                return json_encode($clientes);
            }else{
                $cliente = Cliente::find()->where("id = $id")->asArray()->all();
                return json_encode($cliente);
            }
        }
    }
}
