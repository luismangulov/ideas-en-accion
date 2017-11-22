<?php
namespace app\widgets\foro;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Usuario;
use app\models\LoginForm;
use app\models\Resultados;
use app\models\ForoComentario;
use app\models\Proyecto;
use app\models\Equipo;
use app\models\Foro;

class ForoWidget extends Widget
{
    public $proyecto_id;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        
        $newComentario = new ForoComentario();
        $proyecto=Proyecto::findOne($this->proyecto_id);
        $equipo=Equipo::find()->where('id=:id',[':id'=>$proyecto->equipo_id])->one();
        $model=Foro::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->one();
        
        
        return $this->render('foro', [
            'model' => $model,
            'newComentario'=>$newComentario
        ]);
    }
}