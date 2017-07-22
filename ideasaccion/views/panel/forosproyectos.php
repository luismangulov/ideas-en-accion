<?php
use yii\helpers\Html;
use app\models\Ubigeo ;

$this->title="Ideas en acción";
?>


<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">Foro
</div>
<div class="box_content contenido_seccion_equipo" >
    
    <div class="col-md-4">
        <div class="form-group label-floating field-registrar-departamento required" style="margin-top: 15px">
            <label class="control-label" for="registrar-departamento">Departamento</label>
            <select  class="form-control"  onchange='ResultadosProyectos($(this).val())'>
            <option value=""></option>
            <?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
            <option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
            <?php } ?>
            </select>
        </div>
    </div>
    
    <div class="clearfix"></div>
    <div id="resultados_proyectos" style="display: none">
        
        
    </div>
    
</div>



<?php
    $ResultadosProyectos= Yii::$app->getUrlManager()->createUrl('panel/resultadosproyectos');
    $link= Yii::$app->getUrlManager()->createUrl('foro/viewadmin?id');
?>
<script>
function ResultadosProyectos(valor) {
    $.ajax({
        url: '<?= $ResultadosProyectos ?>',
        type: 'GET',
        dataType: "json",
        async: true,
        data: {region:valor},
        success: function(data){
            $("#resultados_proyectos").html("");
           
            if (data) {
                 $("#resultados_proyectos").append("<div class='col-md-6'>Asunto</div>"+
                                            "<div class='col-md-2'>Total de comentarios</div>"+
                                            "<div class='col-md-2'>Comentarios valorados</div>"+
                                            "<div class='col-md-2'>Falta valorar</div>"+
                                            "<div class='clearfix'></div>"+
                                            "<hr>");
                $.each( data, function( index, value ){
                    //var falta_valorar=value["falta_valorar"];
                    //var foro=value["foro"];
                    //var link='<?= Html::a("'+falta_valorar+'",["foro/viewadmin?id='+foro+'"]) ?>';
                    $("#resultados_proyectos").show();
                    $("#resultados_proyectos").append("<div class='col-md-6'>"+value["titulo"]+"</div>"+
                                                      "<div class='col-md-2'>"+value["total_comentario"]+"</div>"+
                                                      "<div class='col-md-2'>"+value["valorado"]+"</div>"+
                                                      "<div class='col-md-2'><a href='../foro/viewadmin?id="+value["foro"]+"'>"+value["falta_valorar"]+"</a></div>"+
                                                      "<div class='clearfix'></div>");
                    
                }); 
            }
            
             
        }
    });
}
</script>