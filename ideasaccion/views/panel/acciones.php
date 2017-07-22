<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
$this->title="Ideas en acción";

$disabled=false;
if($votacionpublica || $etapa->etapa!=3)
{
    $disabled=true;
}
exit;
?>
<script src="<?= \Yii::$app->request->BaseUrl ?>/js/libs/1.11.1/jquery.min.js"></script>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Acciones
</div>
<div class="box_content contenido_seccion_equipo">
    
    <div class="panel-body text-center">
        <div class="clearfix"></div>
        <?php /* <button class="btn btn-raised btn-default" id="cerrarvoto" <?= $resultados?'disabled':'' ?>>cerrar votación</button> */ ?>
        <div class="clearfix"></div><p></p>
        <button class="btn btn-raised btn-default" id="cerrar1entrega" <?= ($etapa->etapa!=1 || !$resultados)?'disabled':'' ?> >cerrar 1era entrega</button>
        <div class="clearfix"></div><p></p>
        <?php /*  <button class="btn btn-raised btn-default" id="cerrar2entrega" <?= ($etapa->etapa!=2)?'disabled':'' ?> >cerrar 2da entrega</button> */ ?>
        <div class="clearfix"></div><p></p>
        <?php  //Html::a('Votación interna',['votacioninterna'],['id'=>'btnvotacioninterna','class'=>'btn btn-raised btn-default','disabled'=>$disabled]); ?>
        <div class="clearfix"></div><p></p>
        <?php /*<button class="btn btn-raised btn-default"  id="cerrarvotacioninterna" <?= ($votacionpublica || $etapa->etapa!=3)?'disabled':'' ?> >cerrar votación interna</button> */ ?>
    </div>
</div>


<?php
    $cerrarprimeraentrega= Yii::$app->getUrlManager()->createUrl('proyecto/cerrarprimeraentrega');
    $cerrarsegundaentrega= Yii::$app->getUrlManager()->createUrl('proyecto/cerrarsegundaentrega');
    $cerrarvotacioninterna= Yii::$app->getUrlManager()->createUrl('proyecto/cerrarvotacioninterna');
?>

<script>
    $( '#cerrarvoto' ).click(function() {
        var countvoto=<?= $countVoto ?>;
        if (countvoto==0) {
            $.notify({
                // options
                message: 'Deberia registrar mínimo 3 votos' 
            },{
                // settings
                type: 'danger',
                z_index: 1000000,
                placement: {
                        from: 'bottom',
                        align: 'right'
                },
            });
            return false;
        }
        $.ajax({
            url: 'cerrar',
            //dataType: 'json',
            type: 'GET',
            async: true,
            data: {bandera:1},
            success: function(data){
                if(data==1)
                {
                    $.notify({
                        // options
                        message: 'Se ha cerrado la votación correctamente' 
                    },{
                        // settings
                        type: 'success',
                        z_index: 1000000,
                        placement: {
                                from: 'bottom',
                                align: 'right'
                        },
                    });
                }
                if(data==2)
                {
                    $.notify({
                        // options
                        message: 'Ya ha cerrado la votación, gracias' 
                    },{
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                                from: 'bottom',
                                align: 'right'
                        },
                    });
                    
                }
                setTimeout(function(){
                                window.location.reload(1);
                            }, 1000);
            }
        });
        return true;
    });
    
    $('#cerrar1entrega').click(function(events){
        var countvoto=<?= $countVoto ?>;
        if (countvoto==0) {
            $.notify({
                // options
                message: 'Deberia cerrar votación' 
            },{
                // settings
                type: 'danger',
                z_index: 1000000,
                placement: {
                        from: 'bottom',
                        align: 'right'
                },
            });
            return false;
        }
        
        var finalizar=$.ajax({
            url: '<?= $cerrarprimeraentrega ?>',
            type: 'POST',
            async: false,
            success: function(data){
                
            }
        });
        
        if(finalizar.responseText==1)
        {
            $.notify({
                message: 'Se ha cerrado el proceso de 1ra entrega' 
            },{
                type: 'success',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            setTimeout(function(){
                                window.location.reload(1);
                            }, 1000);
        }
        if(finalizar.responseText==2)
        {
            $.notify({
                message: 'Para cerrar debe tener mínimo un proyecto finalizado' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            setTimeout(function(){
                                window.location.reload(1);
                            }, 1000);
        }
        if(finalizar.responseText==3)
        {
            $.notify({
                message: 'Ya se ha cerrado el proceso de 1ra entrega' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            setTimeout(function(){
                                window.location.reload(1);
                            }, 1000);
        }
        
        return true;
    });
    
    
    $('#cerrar2entrega').click(function(events){
        var finalizar=$.ajax({
            url: '<?= $cerrarsegundaentrega ?>',
            type: 'POST',
            async: false,
            success: function(data){
                
            }
        });
        
        if(finalizar.responseText==1)
        {
            $.notify({
                message: 'Se ha cerrado el proceso de 2da entrega' 
            },{
                type: 'success',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            setTimeout(function(){
                                window.location.reload(1);
                            }, 1000);
        }
        if(finalizar.responseText==2)
        {
            $.notify({
                message: 'Ningun proyecto ha cerrado su segunda entrega' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            setTimeout(function(){
                                window.location.reload(1);
                            }, 1000);
        }
        if(finalizar.responseText==3)
        {
            $.notify({
                message: 'Ya se ha cerrado el proceso de 2da entrega' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            setTimeout(function(){
                                window.location.reload(1);
                            }, 1000);
        }
        
        
    });
    
    $('#cerrarvotacioninterna').click(function(events){
        var faltavalorporcentual=<?= $faltavalorporcentual ?>;
        var votacionesinternas=<?= $votacionesinternas ?>;
        if (faltavalorporcentual>0) {
            $.notify({
                message: 'Falta ingresa valor en algunos proyectos' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        
        if (votacionesinternas==0) {
            $.notify({
                message: 'No tiene ningun registro en votación interna' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        
        $.ajax({
            url: '<?= $cerrarvotacioninterna ?>',
            type: 'POST',
            async: true,
            success: function(data){
                setTimeout(function(){
                                window.location.reload(1);
                            }, 1000);
            }
        });
        
        
        return true;
    });
    $('#btnvotacioninterna').click(function(events){
        var votacionesinternas=<?= $votacionesinternas ?>;
        if (votacionesinternas==0) {
            $.notify({
                message: 'No tiene ningun registro en votación interna' 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        return true;
    });
    
</script>