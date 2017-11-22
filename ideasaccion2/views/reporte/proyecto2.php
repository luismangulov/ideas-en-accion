<?php
$proyectos = $model->getProyectoRegional($sort->orders);

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use app\models\Ubigeo;

$a = 0;
$b = 0;
$c = 0;
$d = 0;
$e = 0;
$floor = 1;
if (isset($_GET['page']) >= 2)
    $floor += ($votos['pages']->pageSize * $_GET['page']) - $votos['pages']->pageSize;
?>
<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_team_big.jpg" alt=""> Reporte de proyectos regionales
</div>
<div ng-app="ideasaccion" class="box_content contenido_seccion_crear_equipo">


    <table class="table">
        <thead style="background: #D9D9D9">
        <th class="text-left"><b><?= $sort->link('department') ?></b></th>
        <th align="center"><b><?= $sort->link('province') ?></b></th>
        <th align="center"><b><?= $sort->link('district') ?></b></th>
        <th align="center"><b><?= $sort->link('province_id') ?></b></th>
        <th align="center"><b><?= $sort->link('district_id') ?></b></th>
        </thead>
        <tbody>
            <?php
            $a = 0;
            ?>
            <?php
            foreach ($proyectos['proyectos'] as $proyecto):
                $floor_number = $floor++; //?????
                ?>
                <tr>
                    <td class="text-left"><?= $proyecto['department'] ?></td>
                    <td class="text-right"><?= $proyecto['province'] ?></td>
                    <td class="text-right"><?= $proyecto['district'] ?></td>
                    <td class="text-right"><?= $proyecto['province_id'] ?></td>
                    <td class="text-right"><?= $proyecto['district_id'] ?></td>
                </tr>
                <?php
                $a = $a + $proyecto['province'];
                $b = $b + $proyecto['district'];
                $c = $c + $proyecto['province_id'];
                $d = $d + $proyecto['district_id'];
                ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td><b>Total</b></td>
                <td class="text-right"><b><?= $a ?></b></td>
                <td class="text-right"><b><?= $b ?></b></td>
                <td class="text-right"><b><?= $c ?></b></td>
                <td class="text-right"><b><?= $d ?></b></td>

            </tr>
        </tfoot>        
    </table>    


    <div class='clearfix'></div>
    <div class="form-group pull-rigth col-md-4" >
        <?php /* = Html::a('Descargar',['reporte/proyecto2-descargar'],['class'=>' btn btn-default']); */ ?>
    </div>
    <div class='clearfix'></div>



</div>
<script nonce="<?= getnonceideas() ?>" >
    function Region(event) {
        event.preventDefault();
        $("#w0").submit();
    }
</script>
<script nonce="<?= getnonceideas() ?>"  type="text/javascript">
    $(document).ready(function() {
// Handler for .ready() called.

        $("#lnk_reporteprimera").addClass("active");
        $("#lnk_reporteprimera").parent().find("ul").show();
        $("#lnk_reporteproyectosxregion").addClass("active");


    });



</script>