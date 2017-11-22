<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title = htmlentities($model->titulo, ENT_QUOTES);
$usuario=$model->usuario;
$posts = $model->getPosts($model->id);
?>

<div class="box_content contenido_seccion_crear_equipo">
    <div style="border: 2px solid #1f2a69;padding: 10px" class="text-justify">
        <h4><b><?= Html::encode($this->title) ?></b></h4>
    </div>
    
    <!-- Post Form End -->
    <?= $this->render('/foro/_posts', [
            'posts'=>$posts['posts'],
            'pageSize'=>$posts['pages']->pageSize, //??
            'pages' => $posts['pages'], //??
            'postCount' => $model->post_count //???
        ]);
    ?>
    <!-- Post Form Begin -->
    <?= $this->render('/foro-comentario/_form',[
            'model'=>$newComentario,
        ]);
    ?>
    
</div>





