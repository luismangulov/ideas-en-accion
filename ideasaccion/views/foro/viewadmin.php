<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Foro */

$this->title = "Ideas en acción";
$this->params['breadcrumbs'][] = ['label' => 'Foros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$usuario = $model->usuario;
$posts = $model->getPostsAdmin($model->id);
$proyecto = $model->id;
?>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt=""> <?= ($model->id == 2) ? 'Foro de participación estudiantil' : 'Foro de asunto público' ?> 
</div>
<div class="box_content contenido_seccion_crear_equipo">
    <?php if ($model->id == 2) { ?>
        <div style="border: 2px solid #1f2a69;padding: 10px" class="text-justify">
            Te invitamos a ser parte del foro de participación estudiantil, comentanos tu experiencia en el concurso.
        </div>   
    <?php } elseif ($model->id >= 3 && $model->id <= 35) { ?>
        <div style="border: 2px solid #1f2a69;padding: 10px" class="text-justify">
            <h4><b><?=htmlentities( Html::encode($this->title), ENT_QUOTES) ?></b></h4>
            <h4><?= htmlentities($model->asunto->descripcion_cabecera , ENT_QUOTES)?></h4>
            <p class="text-justify"><?= htmlentities($model->asunto->descripcion_larga, ENT_QUOTES) ?></p>
        </div>
    <?php } else { ?>
        <h1><?= htmlentities(Html::encode($this->title), ENT_QUOTES) ?></h1>
    <?php } ?>


    <?=
    $this->render('_postsadmin', [
        'posts' => $posts['posts'],
        'proyecto' => $proyecto,
        'pageSize' => $posts['pages']->pageSize, //分页
        'pages' => $posts['pages'], //分页
        'postCount' => $model->post_count //评论数
    ]);
    ?>
    <?php if (\Yii::$app->user->can('monitor')) { ?>
        <!-- Post Form Begin -->
        <?=
        $this->render('/foro-comentario/admin_form', [
            'model' => $newComentario,
        ]);
        ?>
        <!-- Post Form End -->
<?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_forosgeneral").attr("class", "active");
    });



</script>