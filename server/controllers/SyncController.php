<?php

namespace app\controllers;

use Yii;
// use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Cliente;
use app\models\Servico;
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

    public function actionServico($id = ''){
        $request = Yii::$app->request;
        if($request->isPost){
            $servico = new Servico();
            $servico->descricao  = $request->post('descricao');
            $servico->observacao = $request->post('observacao');
            $servico->ativo      = $request->post('ativo');

            if($servico->save()){
                return $this->redirect('http://localhost/unipet-client/index.php/servico/index');
            }else{
                return $servico->getErrors();
            }
        }else if($request->isPut){
            $servico = Servico::findOne($request->post('id'));
            $servico->descricao  = $request->post('descricao');
            $servico->observacao = $request->post('observacao');
            $servico->ativo      = $request->post('ativo');

            if($servico->save()){
                return $this->redirect('http://localhost/unipet-client/index.php/servico/index');
            }else{
                return $servico->getErrors();
            }
        }else if($request->isDelete){
            if(!$id){
                return 'Parâmetro id obrigatório.';
            }else{
                if(Servico::findOne($id)->delete()){
                    return 'success';
                }else{
                    return 'error';
                }
            }
        }else if($request->isGet){
            if(!$id){
                $servicos = Servico::find()->asArray()->all();
                return json_encode($servicos);
            }else{
                $servico = Servico::find()->where("id = $id")->asArray()->all();
                return json_encode($servico);
            }
        }
    }
}
