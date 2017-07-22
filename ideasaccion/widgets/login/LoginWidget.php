<?php
namespace app\widgets\login;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Usuario;
use app\models\LoginForm;
use app\models\Resultados;

class LoginWidget extends Widget
{
    public $tipo;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model = new LoginForm();
        $resultados=Resultados::find()->all();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if($this->tipo==2)
            {
                echo "<script>window.location.href = 'panel/index';</script>";
            }
            else
            {
                return \Yii::$app->getResponse()->refresh();
            }
            
        }
        
        
        return $this->render('login',['tipo'=>$this->tipo,'model'=>$model,'resultados'=>$resultados]);
    }
}