<?php
$registrados_detalles = $model->getRegistradosDetalles($model->region_id, $model->estado, $sort->orders);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;

$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($registrados_detalles['pages']->pageSize * $_GET['page']) - $registrados_detalles['pages']->pageSize;
?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Reporte de Participantes detalles 
</div>
<div class="box_content contenido_seccion_crear_equipo">

    <?php
    $form = ActiveForm::begin([
                'action' => ['registrados-detalles'],
                'method' => 'get',
    ]);
    ?>
    <div class="col-md-6">
        <div class="form-group label-floating field-voto-region required">
            <select id="estudiante-region_id" class="form-control" name="Estudiante[region_id]" onchange="Region(event)">
                <option value>Selecciona tu región</option>
                <?php foreach (Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento) { ?>
                    <option value="<?= $departamento->department_id ?>" <?= ($model->region_id == $departamento->department_id) ? 'selected' : '' ?>  ><?= $departamento->department ?></option>
<?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group label-floating field-voto-estado required">
            <select id="estudiante-estado" class="form-control" name="Estudiante[estado]" onchange="Estado(event)">
                <option value>Selecciona tu estado</option>
                <option value=1 <?= ($model->estado == 1) ? 'selected' : '' ?>>Finalizaron equipos</option>
                <option value=2 <?= ($model->estado == 2) ? 'selected' : '' ?>>Falta finalizar equipo</option>
                <option value=3 <?= ($model->estado == 3) ? 'selected' : '' ?>>Invitaciones pendientes</option>
                <option value=4 <?= ($model->estado == 4) ? 'selected' : '' ?>>Sin equipo</option>
            </select>
        </div>
    </div>
<?php ActiveForm::end(); ?>


    <table class="table">
        <thead style="background: #D9D9D9">
        <th class="text-center"><b>Colegio </b></th>
        <th class="text-center"><b>Nombres Completos </b></th>
        <th class="text-center"><b>Correo</b></th>
        <th class="text-center"><b>Celular</b></th>
        <th class="text-center"><b>Rol</b></th>
        </thead>
        <tbody>
            <?php
            foreach ($registrados_detalles['registrados'] as $registrado_detalle):
                $rol = "Estudiante";
                if ($registrado_detalle["grado"] == 6) {
                    $rol = "Docente";
                }
                $floor_number = $floor++; //?????
                ?>
                <tr>
                    <td><?= $registrado_detalle['denominacion'] ?></td>
                    <td><?= $registrado_detalle['nombres'] . " " . $registrado_detalle['apellido_paterno'] . " " . $registrado_detalle['apellido_materno'] ?></td>
                    <td><?= $registrado_detalle['email'] ?></td>
                    <td><?= $registrado_detalle['celular'] ?></td>
                    <td><?= $rol ?></td>
                </tr>
<?php endforeach; ?>
        </tbody>
    </table>    
    <?=
    LinkPager::widget([
        'pagination' => $registrados_detalles['pages'],
        'lastPageLabel' => true,
        'firstPageLabel' => true
    ]);
    ?>

    <div class='clearfix'></div>
    <div class='clearfix'></div>
    <div class="form-group pull-rigth col-md-4" >
<?php /* = Html::a('Descargar',['reporte/registrados-detalles_descargar','region'=>$model->region_id,'estado'=>$model->estado],['class'=>' btn btn-default']); */ ?>
    </div>
    <div class='clearfix'></div>


</div>
<script>
    function Region(event) {
        event.preventDefault();
        $("#w0").submit();
    }
    function Estado(event) {
        event.preventDefault();
        $("#w0").submit();
    }

</script>

<script type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_reporteinscripcion").addClass("active");
        $("#lnk_reporteinscripcion").parent().find("ul").show();
        $("#lnk_reporteestudiantedet").addClass("active");


    });



</script>