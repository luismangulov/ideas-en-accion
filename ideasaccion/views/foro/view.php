<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title="Ideas en acción";
$this->params['breadcrumbs'][] = ['label' => 'Foros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$usuario=$model->usuario;
$posts = $model->getPosts($model->id);/*
print_r($posts);

exit;*/
?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_send_big.png" alt=""> <?= ($model->id==2)?'Foro de participación estudiantil':'Foro de asunto público' ?> 
</div>
<div class="box_content contenido_seccion_crear_equipo">
    <?php if($model->id==2){ ?>
        <div style="border: 2px solid #1f2a69;padding: 10px" class="text-justify">
        Te invitamos a ser parte del foro de participación estudiantil, comentanos tu experiencia en el concurso.
        </div> 
    <?php }elseif($model->id>=3 && $model->id<=35) { ?>
    <div style="border: 2px solid #1f2a69;padding: 10px" class="text-justify">
        <h4><b><?= Html::encode($this->title) ?> </b></h4>
        <h4><?= $model->asunto->descripcion_cabecera ?></h4>
        <p class="text-justify"><?= $model->asunto->descripcion_larga ?> </p>
    </div>
    <?php }else{ ?>
        
        <h1><?= Html::encode($model->proyecto->titulo) ?> </h1>
    <?php } ?>
    
    
    <?= $this->render('_posts', [
            'proyecto'=>$model->id,
            'posts'=>$posts['posts'],
            'pageSize'=>$posts['pages']->pageSize, //分页
            'pages' => $posts['pages'], //分页
            'postCount' => $model->post_count //评论数
        ]);
    ?>
    <!-- Post Form Begin -->
        <?= $this->render('/foro-comentario/_form',[
                'model'=>$newComentario,
            ]);
        ?>
    <!-- Post Form End -->
</div>
<script type="text/javascript">
$( document ).ready(function() {
      $("#lnkForos").addClass("active");
        $("#lnkForos").parent().find("ul").show();
  // Handler for .ready() called.
  <?php if($model->id!=2){ ?>
          

  $("#lnk_foroasunto").addClass("active");

  
  <?php }else{ ?>
    $("#lnk_foropestudiantil").addClass("active");
   <?php } ?>
  
});



</script>