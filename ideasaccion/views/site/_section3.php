<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use app\models\Asunto;
use app\models\Resultados;
$asuntos=Asunto::find()->all();
$mensajecorto=[];
foreach($asuntos as $asunto)
{
    $mensajecorto[]=[$asunto->id=>htmlentities($asunto->descripcion_corta,ENT_QUOTES)];
}
$resultados=Resultados::find()->all();
?>

<!--
Large devices
Desktops (≥1200px)

-->
<h1>¿Qué es un Asunto Público?</h1>
<p class="text-justify visible-lg-block visible-md-block visible-sm-block">An easy and beautiful way to navigate throw the sections, An easy and beautiful way to navigate throw the sections , An easy and beautiful way to navigate throw the sections
An easy and beautiful way to navigate throw the sections An easy and beautiful way to navigate throw the sections
An easy and beautiful way to navigate throw the sections An easy and beautiful way to navigate throw the sections</p>

<div class="col-lg-4 visible-lg-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos A</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasAlg=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>1])->all();
		foreach($categoriasAlg as $categoriaAlg)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaAlg->id.'" id="proyecto'.$categoriaAlg->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaAlg->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="col-lg-4 visible-lg-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos B</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasBlg=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>2])->all();
		foreach($categoriasBlg as $categoriaBlg)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaBlg->id.'" id="proyecto'.$categoriaBlg->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaBlg->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="col-lg-4 visible-lg-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos C</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasClg=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>3])->all();
		foreach($categoriasClg as $categoriaClg)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaClg->id.'" id="proyecto'.$categoriaClg->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaClg->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="clearfix"></div>




<div class="col-md-4 visible-md-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos A</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasAmd=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>1])->all();
		foreach($categoriasAmd as $categoriaAmd)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaAmd->id.'" id="proyecto'.$categoriaAmd->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaAmd->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="col-md-4 visible-md-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos B</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasBmd=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>2])->all();
		foreach($categoriasBmd as $categoriaBmd)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaBmd->id.'" id="proyecto'.$categoriaBmd->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaBmd->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="col-md-4 visible-md-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos C</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasCmd=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>3])->all();
		foreach($categoriasCmd as $categoriaCmd)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaCmd->id.'" id="proyecto'.$categoriaCmd->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaCmd->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="clearfix"></div>



<div class="col-sm-4 visible-sm-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos A</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasAsm=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>1])->all();
		foreach($categoriasAsm as $categoriaAsm)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaAsm->id.'" id="proyecto'.$categoriaAsm->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaAsm->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="col-sm-4 visible-sm-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos B</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasBsm=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>2])->all();
		foreach($categoriasBsm as $categoriaBsm)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaBsm->id.'" id="proyecto'.$categoriaBsm->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaBsm->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="col-sm-4 visible-sm-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos C</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasCsm=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>3])->all();
		foreach($categoriasCsm as $categoriaCsm)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaCsm->id.'" id="proyecto'.$categoriaCsm->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaCsm->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="clearfix"></div>



<p class="text-justify visible-xs-block">An easy and beautiful way to navigate throw the sections, An easy and beautiful way to navigate throw the sections ,</p>

<div class="col-xs-12 visible-xs-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos A</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasAxs=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>1])->all();
		foreach($categoriasAxs as $categoriaAxs)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaAxs->id.'"  id="proyecto'.$categoriaAxs->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaAxs->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="col-xs-12 visible-xs-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos B</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasBxs=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>2])->all();
		foreach($categoriasBxs as $categoriaBxs)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaAxs->id.'" id="proyecto'.$categoriaBxs->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaBxs->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="col-xs-12 visible-xs-block">
    <div class="panel panel-default ">
	<div class="panel-heading">Asuntos C</div>
	<div class="panel-body text-justify">
	    <?php
		$categoriasCxs=Asunto::find()->where('padre_id=:padre_id',[':padre_id'=>3])->all();
		foreach($categoriasCxs as $categoriaCxs)
		{
		    echo '<span data-toggle="modal" data-target="#myModalAsunto'.$categoriaAxs->id.'" id="proyecto'.$categoriaCxs->id.'" class="badge" style="cursor: pointer" >'.htmlentities($categoriaCxs->descripcion_cabecera,ENT_QUOTES).'</span>';
		}
	    ?>
	</div>
    </div>
</div>
<div class="clearfix"></div>
<?php if(!$resultados){ ?>
<div>
    <button id="votar" type="button" class="btn btn-small btn-primary" >votar</button>
</div>

<?php } ?>

  
<?php /*
    $this->registerJs(
    "$('document').ready(function(){
	//var numberArray = [];
	$.each(".json_encode($mensajecorto).", function() {
	    $.each(this, function(name, value) {
	      $('#proyectolg'+name).hovercard({
		detailsHTML: value +' <a data-toggle=\"modal\" data-target=\"#myModalCompleto'+name+'\" style=\"cursor: pointer\">mas</a>',
		width: 400,
	    });
	    });
	});
	
    })");*/
?>
<!--proyecto 1-->
