<?php

use yii\helpers\Html;
use app\models\Integrante;
use app\models\Invitacion;
use app\models\Asunto_categoria;

$this->title = "Ideas en acción";
if ($integrante) {
    $integrantes = Integrante::find()
            ->select('integrante.id,estudiante.nombres_apellidos,integrante.estudiante_id,integrante.rol,estudiante.email')
            ->innerJoin('estudiante', 'integrante.estudiante_id=estudiante.id')
            ->where('integrante.equipo_id=:equipo_id and integrante.estado=1', [':equipo_id' => $integrante->equipo_id])
            ->all();

    $connection = \Yii::$app->db;
    $command = $connection->createCommand("
                SELECT AA.tipo,AA.equipo_id,AA.id,AA.nombres_apellidos,AA.nombres,AA.apellido_paterno,AA.apellido_materno,
                AA.estudiante_id,AA.rol,AA.estado,AA.email,AA.orden,AA.avatar,AA.grado,AA.sexo
                FROM
                (
                select 1 tipo,integrante.equipo_id,integrante.id,estudiante.nombres_apellidos,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,
                integrante.estudiante_id,integrante.rol,integrante.estado,estudiante.email,1 orden,usuario.avatar,estudiante.grado,estudiante.sexo
                from integrante
                inner join estudiante on integrante.estudiante_id=estudiante.id
                inner join usuario on usuario.estudiante_id=estudiante.id
                where integrante.equipo_id=" . $integrante->equipo_id . " and integrante.estado in (1,2)
                union
                select 2 tipo,invitacion.equipo_id,invitacion.id,estudiante.nombres_apellidos,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno,
                estudiante.id,0,6,estudiante.email,2,usuario.avatar,estudiante.grado,estudiante.sexo
                from invitacion
                inner join estudiante on invitacion.estudiante_invitado_id=estudiante.id
                inner join usuario on usuario.estudiante_id=estudiante.id
                where invitacion.equipo_id=" . $integrante->equipo_id . " and invitacion.estado=1
                ) AA
                ORDER BY AA.orden ASC,AA.ROL ASC
                
               ");
    $equipoeinvitaciones = $command->queryAll();
    $integrantestotales = [];
    $integrantedocentes = [];
    foreach ($equipoeinvitaciones as $equipoinvitacion) {
        if ($equipoinvitacion['grado'] != 6) {
            array_push($integrantestotales, ['nombres' => $equipoinvitacion['nombres'] . " " . $equipoinvitacion['apellido_paterno'] . " " . $equipoinvitacion['apellido_materno'], 'sexo' => $equipoinvitacion['sexo'], 'rol' => $equipoinvitacion['rol'], 'grado' => $equipoinvitacion['grado'], 'avatar' => $equipoinvitacion['avatar']]);
        } elseif ($equipoinvitacion['grado'] == 6) {
            array_push($integrantedocentes, ['nombres' => $equipoinvitacion['nombres'] . " " . $equipoinvitacion['apellido_paterno'] . " " . $equipoinvitacion['apellido_materno'], 'sexo' => $equipoinvitacion['sexo'], 'rol' => $equipoinvitacion['rol'], 'grado' => $equipoinvitacion['grado'], 'avatar' => $equipoinvitacion['avatar']]);
        }
    }
    $primeros3elementos = array_slice($integrantestotales, 0, 3);
    $segundos3elementos = array_slice($integrantestotales, 3, 6);
}
$btninscribir = $integrante
?>
<style>
    .modal-body {
        text-align: center;
    }
</style>
<div class="box_head title_content_box">
    <img src="../img/icon_team_big.jpg" alt="">MI EQUIPO
</div>




<?php if (!$integrante) { ?>
    <?php if (!$invitaciones) { ?>
        <!--Comienza-->
        <div class="box_content contenido_seccion_equipo">
            <div class="texto_final_equipo">

                <?php if ($estudiante->grado != 6) { ?>
                    <p class="text-center"><b>No tienes invitaciones activas de otros equipos,</b></p>
                    <p class="text-center"><b>te invitamos a ser el coordinador de un equipo.</b></p>
                <?php } else { ?>
                    <p class="text-center"><b>No tienes invitaciones activas de otros equipos.</b></p>
                <?php } ?>
            </div>
            <?php if (!$integrante && $estudiante->grado != 6) { ?>
                <div class="final_seccion_equipo">
                    <div class="row">
                        <p></p>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <?= Html::a('Crea tu equipo', ['inscripcion/index'], ['class' => 'btn btn-default ']); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <br>
            <p class="text-center"><b>Estos son los compañeros de tu institución educativa que ya se han inscrito y no pertenecen a un equipo</b></p>
            <div class="row tabla_crear_equipo">
                <div class="col-md-12">
                    <table id="estudiantes" class="table table-bordered" >
                        <thead>
                            <tr class="cabecera_tabla">
                                <td>Apellidos y Nombres</td>
                                <td align="center">Grados</td>
                            </tr>
                        </thead>

                        <tbody class="buscar">
                            <?php
                            $i = 1;
                            foreach ($estudiantes as $estudiante) {
                                echo "<tr>
                                            <td style='vertical-align:middle'>$estudiante->nombres $estudiante->apellido_paterno $estudiante->apellido_materno</td>
                                            <td align='center' style='vertical-align:middle'> " . $estudiante->getGrado() . "</td>
                                    </tr>";

                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <div class="box_content contenido_seccion_equipo">
            <div class="titulo_contenido_equipo">
                <b>Has recibido invitaciones</b> para ser parte de otros equipos.<br>
                Revísalas y confirma tu participación.
            </div>

            <div class="inputs_seccion_equipo">
                <table class="table table-striped table-hover">
                    <thead>
                    <th>Equipo</th>
                    <th>Coordinador(a)</th>
                    <th></th>
                    <th></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($invitaciones as $invitacion) {
                            echo "<tr>
                            <td style='vertical-align:middle'>".htmlentities($invitacion->descripcion_equipo)."</td>
                            <td style='vertical-align:middle'><div class='row-picture'>
                            <img class='circle' src='" . \Yii::$app->request->BaseUrl . "/foto_personal/" . $invitacion->avatar . "' alt='icon' style='height: 30px;width: 30px'>
                        " . htmlentities($invitacion->nombres ). " " . htmlentities($invitacion->apellido_paterno) . " " . htmlentities($invitacion->apellido_materno) . "
                      </div> </td>
                            <td class='text-center' style='vertical-align:middle'><div style='color:green;font-size:24px;cursor:pointer'  class='fa  fa-check-circle-o fa-6' title='Aceptar invitación' onclick='unirme($invitacion->id)'></div></td>
                            <td class='text-center' style='vertical-align:middle'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' title='Rechazar invitación' onclick='rechazar($invitacion->id)'></div></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php if ($estudiante->grado != 6) { ?>
                <div class="final_seccion_equipo">
                    <div class="texto_final_equipo">
                        <b>Si no te gusta ninguno de los equipos puedes crear el tuyo</b>
                    </div>
                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            <?= Html::a('Crea tu equipo', ['inscripcion/index'], ['class' => 'btn btn-default btn-raised ']); ?>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

    <?php } ?>



<?php } ?>

<?php if ($integrante) { ?>
    <div class="box_content contenido_seccion_crear_equipo" style="max-height:820px !important">
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label for="">Nombre de mi equipo:</label>
                    <div class="rpta">
                        <?= htmlentities($equipo->descripcion_equipo) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Breve descripión de mi equipo:</label>
                    <div class="rpta">
                        <?= htmlentities($equipo->descripcion) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for=""> </label>
                    <div class="imagen_equipo" style="height: 160px !important;">
                        <?= Html::img('../foto_equipo/' . $equipo->foto, ['id' => 'img_destino', 'class' => 'img-responsive logo', 'style' => "height: 158px;width: 158px"]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Categoría de Asunto Público:</label>
                    <div class="rpta">
                        <?php
                        $resultados = Asunto_categoria::find()->where('id=:region_id', ['region_id' => $equipo->asunto->categoria_id])->one();
                        if ($equipo->asunto_id != '') {
                            ?>
                            <?= htmlentities($resultados->descripcion_categoria,ENT_QUOTES) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>        

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Asunto público sobre el que trabajará mi equipo:</label>
                    <div class="rpta">
                        <?php if ($equipo->asunto_id != '') { ?>
                            <?= htmlentities($equipo->asunto->descripcion_cabecera,ENT_QUOTES) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row lista_miembros_equipo" style="padding-bottom: 10px">
            <div class="col-md-12">
                <label for="">Los miembros de mi equipo:</label>
            </div>

            <div class="col-md-12">
                <?php if ($equipo->estado == 0) { ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <th width='38%'>Nombres y apellidos</th>
                        <th width='38%'>Correo electrónico</th>

                        <th width='20%'>Estado</th>
                        <?php if ($equipo->estado == 0) { ?>
                            <th width='4%' class='text-center'></th>
                        <?php } ?>
                        <th width='20%' class='text-center'> Reportero TEC </th>
                        </thead>
                        <tbody>

                            <?php
                            $i = 1;
                            $coordinador = "Coodinador";
                            foreach ($equipoeinvitaciones as $equipoeinvitacion) {
                                if ($equipoeinvitacion['grado'] != 6) {
                                    echo "<tr>
                                        <td align='left' class='text-left'>" . $equipoeinvitacion['nombres'] . " " . $equipoeinvitacion['apellido_paterno'] . " " . $equipoeinvitacion['apellido_materno'] . "</td>";

                                    echo "<td align='left' class='text-left'>" . $equipoeinvitacion['email'] . "</td>";

                                    if ($equipoeinvitacion['sexo'] == "F") {
                                        $coordinador = "Coodinadora";
                                    }

                                    if ($integrante->rol == 1) {
                                        if ($equipoeinvitacion['rol'] == 1) {
                                            echo "<td align='left' class='text-left'>" . $coordinador . "</td>
                                            <td align='left' class='text-left'></td>
                                             <td align='left' class='text-left'></td>
                                             ";
                                        } elseif ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estado'] == 1) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' title='Eliminar Integrante' onclick='eliminarintegrante(" . $equipoeinvitacion['estudiante_id'] . ")'></div></td>"
                                            . "<td align='center' class='text-center'><input type='radio' name='estudiante_tec' value='" . $equipoeinvitacion['estudiante_id'] . "'/></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estado'] == 2) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'></td>
                                            <td align='center' class='text-center'><input type='radio' name='estudiante_tec' value='" . $equipoeinvitacion['estudiante_id'] . "'/></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 0) {
                                            echo "<td align='left' class='text-left'>Invitado</td>
                                            <td align='left' class='text-left'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' title='Eliminar Invitado' onclick='eliminarinvitado(" . $equipoeinvitacion['estudiante_id'] . "," . $equipoeinvitacion['equipo_id'] . ")'></div></td><td align='left' class='text-left'></td>";
                                        }
                                    } elseif ($integrante->rol == 2) {
                                        if ($equipoeinvitacion['rol'] == 1) {
                                            echo "<td align='left' class='text-left'>" . $coordinador . "</td>
                                            <td align='left' class='text-left'></td>
                                            <td align='left' class='text-left'></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estudiante_id'] == $integrante->estudiante_id && $equipoeinvitacion['estado'] == 1) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' title='Dejar equipo' onclick='dejarequipo(" . $equipoeinvitacion['estudiante_id'] . ")'></div></td>"
                                            . "<td align='center' class='text-center'></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estudiante_id'] == $integrante->estudiante_id && $equipoeinvitacion['estado'] == 2) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'></td>
                                            <td align='center' class='text-center'></td><td align='left' class='text-left'></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estudiante_id'] != $integrante->estudiante_id) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'></td>
                                            <td align='center' class='text-center'></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 0) {
                                            echo "<td align='left' class='text-left'>Invitado</td>
                                            <td align='left' class='text-left'></td><td align='left' class='text-left'></td>";
                                        }
                                    }

                                    echo "</tr>";
                                    $i++;
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                <?php } elseif ($equipo->estado == 1) { ?>
                    <div class="clearfix"></div>
                    <div class="col-md-1">
                        &nbsp;
                    </div>

                    <div class="col-md-5">
                        <?php for ($i = 0; $i < count($primeros3elementos); $i++) { ?>
                            <div class="table_div">
                                <div class="row_div">
                                    <div class="cell_div div_ia_icon">
                                        <div class="imagen_perfil_miembro" style="background-image: url(../foto_personal/<?= $primeros3elementos[$i]['avatar'] ?>);"></div>
                                    </div>
                                    <div class="cell_div uppercase">
                                        <b><?= $primeros3elementos[$i]['nombres'] ?>  <?php
                                            $coordinador = "Coodinador";
                                            if ($primeros3elementos[$i]['sexo'] == "F") {
                                                $coordinador = "Coodinadora";
                                            }

                                            if ($primeros3elementos[$i]['rol'] == "1") {
                                                ?> - <?= $coordinador ?><?php } ?></b> <br>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-1">
                        &nbsp;
                    </div>

                    <div class="col-md-5">
                        <?php for ($i = 0; $i < count($segundos3elementos); $i++) { ?>
                            <div class="table_div">
                                <div class="row_div">
                                    <div class="cell_div div_ia_icon">
                                        <div class="imagen_perfil_miembro" style="background-image: url(../foto_personal/<?= $segundos3elementos[$i]['avatar'] ?>);"></div>
                                    </div>
                                    <div class="cell_div uppercase">
                                        <b><?= $segundos3elementos[$i]['nombres'] ?></b><br>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
            </div>
        </div>
        <div class="row lista_miembros_equipo">
            <div class="col-md-12">
                <label for="">El docente de mi equipo:</label>
            </div>
            <div class="col-md-12">
                <?php if ($equipo->estado == 0) { ?>
                    <table class="table table-striped table-hover ">
                        <thead>
                        <th width='38%' align="left" class="text-left">Nombres y apellidos</th>
                        <th width='38%' align="left" class="text-left">Correo electrónico</th>
                        <th width='20%' align="left" class="text-left">Estado</th>
                        <?php if ($equipo->estado == 0) { ?>
                            <th width='4%' align="left" class="text-left"></th>
                        <?php } ?>
                        </thead>
                        <tbody>

                            <?php
                            $i = 1;
                            foreach ($equipoeinvitaciones as $equipoeinvitacion) {
                                if ($equipoeinvitacion['grado'] == 6) {
                                    echo "<tr >
                                        <td align='left' class='text-left'>" . $equipoeinvitacion['nombres'] . " " . $equipoeinvitacion['apellido_paterno'] . " " . $equipoeinvitacion['apellido_materno'] . "</td>";

                                    echo "<td align='left' class='text-left'>" . $equipoeinvitacion['email'] . "</td>";

                                    if ($integrante->rol == 1) {
                                        if ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estado'] == 1 && $equipoeinvitacion['grado'] == 6) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' title='Eliminar Integrante'  onclick='eliminarintegrante(" . $equipoeinvitacion['estudiante_id'] . ")'></div></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estado'] == 2 && $equipoeinvitacion['grado'] == 6) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 0) {
                                            echo "<td align='left' class='text-left'>Invitado</td>
                                            <td align='left' class='text-left'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' title='Eliminar Invitado' onclick='eliminarinvitado(" . $equipoeinvitacion['estudiante_id'] . "," . $equipoeinvitacion['equipo_id'] . ")'></div></td>";
                                        }
                                    } elseif ($integrante->rol == 2) {
                                        if ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estudiante_id'] == $integrante->estudiante_id && $equipoeinvitacion['estado'] == 1 && $equipoeinvitacion['grado'] == 6) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'><div style='color:red;font-size:24px;cursor:pointer'  class='fa fa-times-circle-o fa-6' title='Dejar equipo' onclick='dejarequipo(" . $equipoeinvitacion['estudiante_id'] . ")'></div></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estudiante_id'] == $integrante->estudiante_id && $equipoeinvitacion['estado'] == 2 && $equipoeinvitacion['grado'] == 6) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 2 && $equipoeinvitacion['estudiante_id'] != $integrante->estudiante_id && $equipoeinvitacion['grado'] == 6) {
                                            echo "<td align='left' class='text-left'>Integrante</td>
                                            <td align='left' class='text-left'></td>";
                                        } elseif ($equipoeinvitacion['rol'] == 0) {
                                            echo "<td align='left' class='text-left'>Invitado</td>
                                            <td align='left' class='text-left'></td>";
                                        }
                                    }

                                    echo "</tr>";
                                    $i++;
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                <?php } elseif ($equipo->estado == 1) { ?>
                    <div class="clearfix"></div>
                    <div class="col-md-1">
                        &nbsp;
                    </div>

                    <div class="col-md-5">
                        <?php for ($i = 0; $i < count($integrantedocentes); $i++) { ?>
                            <div class="table_div">
                                <div class="row_div">
                                    <div class="cell_div div_ia_icon">
                                        <div class="imagen_perfil_miembro" style="background-image: url(../foto_personal/<?= $integrantedocentes[$i]['avatar'] ?>);"></div>
                                    </div>
                                    <div class="cell_div uppercase">
                                        <b><?= $integrantedocentes[$i]['nombres'] ?></b><br>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-1">
                        &nbsp;
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if ($integrante && $integrante->rol == 1 && $integrante->estado == 1) { ?>
            <div class="row">
                <div class="col-md-4">
                    <?= Html::a('Actualizar e Invitar', ['inscripcion/actualizar', 'id' => $estudiante->id], ['class' => 'btn btn-default']); ?>
                </div>
                <div class="col-md-4">
                    <button class='btn btn-default' onclick='dejarequipo(<?= $estudiante->id ?>)'>Eliminar equipo</button>
                </div>
                <div class="col-md-4">
                    <button id="finalizarEquipobtn" class='btn btn-default' onclick='finalizarequipo(<?= $integrante->equipo_id ?>)'>Finalizar registro</button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <br>
        <?php } ?>
    </div> 

    </div>
    <div class="clearfix"></div>
<?php } ?>


<?php
$unirme = Yii::$app->getUrlManager()->createUrl('equipo/unirme');
$validarunirme = Yii::$app->getUrlManager()->createUrl('equipo/validarunirme');
$rechazar = Yii::$app->getUrlManager()->createUrl('equipo/rechazar');
$dejarequipo = Yii::$app->getUrlManager()->createUrl('equipo/dejarequipo');
$eliminarinvitado = Yii::$app->getUrlManager()->createUrl('equipo/eliminarinvitado');
$eliminarintegrante = Yii::$app->getUrlManager()->createUrl('equipo/eliminarintegrante');
$validarequipo = Yii::$app->getUrlManager()->createUrl('equipo/validarequipo');
$finalizarequipo = Yii::$app->getUrlManager()->createUrl('equipo/finalizarequipo');
$finalizarequipovalidar = Yii::$app->getUrlManager()->createUrl('equipo/finalizarequipovalidar');
$validarparafinalizar = Yii::$app->getUrlManager()->createUrl('equipo/validarparafinalizar');
?>
<script>



    function unirme(id) {
        if (confirm("¿Está seguro de aceptar la invitación?")) {
            var validarunirme = 1;
            $.post("<?= $validarunirme ?>", {id: id})
                    .done(function(data) {
                        if (data == 0) {
                            $.notify({
                                // options
                                message: 'El lider del equipo te ha eliminado'
                            }, {
                                // settings
                                type: 'danger',
                                z_index: 1000000,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                            });
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1000);
                            validarunirme = 0;
                        }
                        else
                        {
                            $.post("<?= $unirme ?>", {id: id})
                                    .done(function(data) {
                                        $.notify({
                                            // options
                                            message: 'Ahora eres parte del equipo ' + xescape(data) + '. ¡Qué excelente!'
                                        }, {
                                            // settings
                                            type: 'success',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        setTimeout(function() {
                                            window.location.reload(1);
                                        }, 1000);
                                    });
                        }
                    });

        }
    }


    function rechazar(id) {
        if (confirm("¿Está seguro de rechazar la invitación?")) {

            $.post("<?= $rechazar ?>", {id: id})
                    .done(function(data) {
                        $.notify({
                            // options
                            message: 'Has rechazado la invitación del equipo ' + data + ' '
                        }, {
                            // settings
                            type: 'danger',
                            z_index: 1000000,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1000);
                    });
        }
    }

    function dejarequipo(id) {
        if (confirm("¿Está seguro de dejar el equipo?")) {

            $.post("<?= $validarequipo ?>", {id: id})
                    .done(function(data) {
                        if (data == 1) {
                            $.notify({
                                // options
                                message: 'Ya no perteneces al equipo o el lider a eliminado el equipo'
                            }, {
                                // settings
                                type: 'success',
                                z_index: 1000000,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                            });
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1);
                        }
                        else if (data == 2)
                        {
                            $.post("<?= $dejarequipo ?>", {id: id})
                                    .done(function(data) {
                                        $.notify({
                                            // options
                                            message: 'Has dejado el equipo'
                                        }, {
                                            // settings
                                            type: 'danger',
                                            z_index: 1000000,
                                            placement: {
                                                from: 'bottom',
                                                align: 'right'
                                            },
                                        });
                                        setTimeout(function() {
                                            window.location.reload(1);
                                        }, 1);
                                    });
                        }
                        else if (data == 3) {
                            $.notify({
                                // options
                                message: 'El lider ha finalizado el registro del equipo, incluyendote'
                            }, {
                                // settings
                                type: 'danger',
                                z_index: 1000000,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                            });
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1);
                        }
                    });


        }
    }


    function eliminarinvitado(id, equipo) {
        if (confirm("¿Está seguro de eliminar el invitado?")) {
            $.post("<?= $eliminarinvitado ?>", {id: id, equipo: equipo})
                    .done(function(data) {
                        $.notify({
                            // options
                            message: 'Invitación eliminada'
                        }, {
                            // settings
                            type: 'success',
                            z_index: 1000000,
                            placement: {
                                from: 'bottom',
                                align: 'right'
                            },
                        });
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1000);
                    });
        }
    }

    function eliminarintegrante(id) {
        if (confirm("¿Está seguro de eliminar el integrante?")) {
            $.post("<?= $eliminarintegrante ?>", {id: id})
                    .done(function(data) {
                        if (data == 1) {
                            $.notify({
                                // options
                                message: 'Has eliminado un miembro de tu equipo'
                            }, {
                                // settings
                                type: 'success',
                                z_index: 1000000,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                            });
                        }
                        else if (data == 2) {
                            $.notify({
                                // options
                                message: 'El integrante se ha retirado'
                            }, {
                                // settings
                                type: 'success',
                                z_index: 1000000,
                                placement: {
                                    from: 'bottom',
                                    align: 'right'
                                },
                            });
                        }

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1000);
                    });

        }

    }


    function finalizarequipo(id) {

        $("#finalizarEquipobtn").attr("disabled", "disabled");
        var texto = "";
        var error = "";


        var finalizarequipovalidar = $.ajax({
            url: '<?php echo $finalizarequipovalidar ?>',
            type: 'GET',
            data: {id: id},
            success: function(data) {
                //$("#finalizarEquipobtn").removeAttr("disabled");

                var ides = $('input[name=estudiante_tec]:checked').val();

                if (ides === undefined) {
                    error = "Seleccione el estudiante reportero";
                }

                if (data == 2) {
                    error = "No tienes la cantidad suficiente de integrantes para finalizar el equipo, deben ser 4 integrantes como mínimo";

                }
                else if (data == 3) {
                    error = "Necesitas a un docente como integrante para finalizar el equipo";

                }
                else if (data == 4) {
                    error = "Deben ser 4 integrantes como mínimo. Adicionalmente un docente debe ser el asesor de tu equipo <br>";

                }




                if (error != "") {

                    $.notify({
                        // options
                        message: error
                    }, {
                        // settings
                        type: 'danger',
                        z_index: 1000000,
                        placement: {
                            from: 'bottom',
                            align: 'right'
                        },
                    });//code

                    $("#finalizarEquipobtn").removeAttr("disabled");
                    return false;

                } else {

                    var validarparafinalizar = $.ajax({
                        url: '<?php echo $validarparafinalizar ?>',
                        type: 'GET',
                        data: {id: id},
                        success: function(data) {

                            if (data == 1) {
                                texto = "¿Estás seguro de finalizar tu equipo, aún tienes invitaciones pendientes los cuales serán eliminadas";
                            }
                            else if (data == 0) {
                                texto = "¿Estás seguro de finalizar tu equipo?";
                            }
                            bootbox.confirm({
                                message: texto,
                                buttons: {
                                    'cancel': {
                                        label: 'Cancelar',
                                    },
                                    'confirm': {
                                        label: 'Aceptar',
                                    }
                                },
                                callback: function(result) {

                                    if (result) {



                                        $.post("<?= $finalizarequipo ?>", {id: ides})
                                                .done(function(data) {
                                                    var msgerror = "";
                                                    var typemsg = 'success';
                                                    if (data == 1) {
                                                        msgerror = 'Has finalizado el registro de tu equipo';

                                                    } else if (data == 2) {
                                                        msgerror = 'La cantidad de integrantes del equipo debe ser mayor a 4';
                                                        typemsg = 'danger';
                                                    } else if (data == 3) {
                                                        msgerror = 'Debe haber 1 docente por equipo';
                                                        typemsg = 'danger';
                                                    } else if (data == 4) {
                                                        msgerror = 'La cantidad máxima de integrantes del equipo es 6';
                                                        typemsg = 'danger';
                                                    } else if (data == 5) {
                                                        msgerror = 'La cantidad máxima de docentes del equipo es 1';
                                                        typemsg = 'danger';
                                                    }



                                                    $.notify({
                                                        // options
                                                        message: msgerror
                                                    }, {
                                                        // settings
                                                        type: typemsg,
                                                        z_index: 1000000,
                                                        placement: {
                                                            from: 'bottom',
                                                            align: 'right'
                                                        },
                                                    });


                                                    if (data == 1) {
                                                        setTimeout(function() {
                                                            window.location.reload(1);
                                                        }, 1000);
                                                    }


                                                });


                                    } else {
                                        $("#finalizarEquipobtn").removeAttr("disabled");

                                    }

                                }
                            });
                        }
                    });




                }





            }
        });






        return true;




    }
</script>


<?php if (Yii::$app->session->hasFlash('equipocreado')): ?>
    <script>
        $.notify({
            // options
            message: 'Tu equipo ha sido creado ¡Listos para la acción!'
        }, {
            // settings
            type: 'success',
            z_index: 1000000,
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });

    </script>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('mensaje_success')): ?>
    <script>
        $.notify({
            // options
            message: '<?= Yii::$app->session->getFlash('mensaje_success') ?>'
        }, {
            // settings
            type: 'success',
            z_index: 1000000,
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });

    </script>
<?php endif; ?>    

<script type="text/javascript">
    $(document).ready(function() {
        $("#lnk_miequipo").attr("class", "active");
    });



</script>