<?php

use yii\helpers\Html;
use app\models\Integrante;
use app\models\Invitacion;

if($integrante)
{
    $integrantes=Integrante::find()
                ->select('integrante.id,estudiante.nombres_apellidos,integrante.estudiante_id,integrante.rol')
                ->innerJoin('estudiante','integrante.estudiante_id=estudiante.id')
                ->where('integrante.equipo_id=:equipo_id and integrante.estado=1',[':equipo_id'=>$integrante->equipo_id])
                ->all();
                
    $connection = \Yii::$app->db;
    $command=$connection->createCommand("
                select 1 tipo,integrante.id,estudiante.nombres_apellidos,integrante.estudiante_id,integrante.rol from integrante
                inner join estudiante on integrante.estudiante_id=estudiante.id
                where integrante.equipo_id=".$integrante->equipo_id." and integrante.estado=1
                union
                select 2 tipo,invitacion.id,estudiante.nombres_apellidos,estudiante.id,0 from invitacion
                inner join estudiante on invitacion.estudiante_invitado_id=estudiante.id
                where invitacion.estudiante_id=".$lider->estudiante_id." and invitacion.estado=1
               ");
    $equipoeinvitaciones = $command->queryAll();
}
/*
if($lider)
{
    
}*/
$btninscribir=$integrante
?>




<?php if(!$lider && !$integrante) { ?>
    
    <h1>Mis invitaciones</h1>
    <table class="table">
        <thead>
            <th>Nombre del equipo</th>
            <th>Lider del equipo</th>
            <th>Nombre de escuela</th>
            <th></th>
            <th></th>
        </thead>
        <tbody>
    <?php
        foreach($invitaciones as $invitacion)
        {
            echo "<tr>
                    <td>$invitacion->descripcion_equipo</td>
                    <td>$invitacion->nombres_apellidos</td>
                    <td>$invitacion->denominacion</td>
                    <td><button class='btn' onclick='unirme($invitacion->id)'>aceptar invitación</button></td>
                    <td><button class='btn' onclick='rechazar($invitacion->id)'>cancelar invitación</button></td>
                    </tr>";
        }
    ?>
        </tbody>
    </table>
<?php } ?>

<?php if($lider){ ?>
<h1>Mi equipo</h1>
<table class="table ">
    <thead>
        <th>N°</th>
        <th>apellidos y nombres</th>
        <th>estado</th>
        <th>eliminar</th>
    </thead>
    <tbody>
<?php
    $i=1;
    if($integrante)
    {
        foreach($equipoeinvitaciones as $equipoeinvitacion)
        {
            echo    "<tr>
                        <td>$i</td>
                        <td>".$equipoeinvitacion['nombres_apellidos']."</td>";
            if($equipoeinvitacion['rol']==1)
            {
                echo    "<td>Lider</td>
                        <td></td>";
            }
            elseif($equipoeinvitacion['rol']==2)
            {
                echo    "<td>Integrante</td>
                        <td><button class='btn' onclick='eliminarintegrante(".$equipoeinvitacion['estudiante_id'].")'>retirar integrante</button></td>";
            }
            elseif($equipoeinvitacion['rol']==0)
            {
                echo    "<td>invitado</td>
                        <td><button class='btn' onclick='eliminarinvitado(".$equipoeinvitacion['id'].")'>cancelar invitación</button></td>";
            }
            echo    "</tr>";
            $i++;
        }
        /*echo "aqui la linea";
        foreach($integrantes as $integ)
        {
            echo    "<tr>
                        <td>$i</td>
                        <td>".$integ->nombres_apellidos."</td>";
            if($integ->rol==1)
            {
                echo    "<td><button class='btn' onclick='dejarequipo($integ->estudiante_id)'>Eliminar equipo</button></td>";
            }
            else
            {
                echo    "<td><button class='btn' onclick='eliminarintegrante($integ->estudiante_id)'>eliminar</button></td>";
            }
            echo    "</tr>";
            $i++;
        }*/
    }
?>
    </tbody>
</table>

<button class='btn' onclick='finalizarequipo(<?= $lider->estudiante_id ?>)'>Finalizar equipo</button>

<?php } ?>



<?php if($integrante && !$lider){ ?>
    <h1>Equipo</h1>
    <table class="table ">
        <thead>
            <th>N°</th>
            <th>apellidos y nombres</th>
            <!--<th>Retirarme</th>-->
        </thead>
        <tbody>
    <?php
        $i=1;
        if($integrante)
        {
            foreach($integrantes as $integ)
            {
                echo    "<tr>
                            <td>$i</td>
                            <td>".$integ->nombres_apellidos."</td>";
                /*if($integ->estudiante_id==$integrante->estudiante_id)
                {
                    echo    "<td><button class='btn' onclick='dejarequipo($integ->estudiante_id)'>retirarme</button></td>";
                }
                else
                {
                    echo    "<td></td>";
                }*/
                echo    "</tr>";
                $i++;
            }
        }
    ?>
        </tbody>
    </table>
    
    <button class='btn' onclick='dejarequipo(<?= $integrante->estudiante_id ?>)'>Retirarme del equipo</button>
<?php } ?>
<?php /*
    <h1>Invitaciones</h1>
    <table class="table">
        <thead>
            <th>Nombre del invitado</th>
            <th>Eliminar invitacion</th>
        </thead>
        <tbody>
    <?php
        $invitados=Invitacion::find()
                            ->select('invitacion.id,estudiante.nombres_apellidos')
                            ->innerJoin('estudiante','invitacion.estudiante_invitado_id=estudiante.id')
                            ->where('invitacion.estudiante_id=:lider and invitacion.estado=1',
                                    [':lider'=>$lider->estudiante_id])
                            ->all();
                            
        foreach($invitados as $invitado)
        {
            echo "<tr>
                    <td>$invitado->nombres_apellidos</td>
                    <td><button class='btn' onclick='eliminarinvitado($invitado->id)'>eliminar</button></td>
                    </tr>";
        }
    ?>
        </tbody>
    </table>
<?php }  */ ?>







<?php /*
<h1>Equipo</h1>
<table class="table ">
    <thead>
        <th>N°</th>
        <th>apellidos y nombres</th>
    </thead>
    <tbody>
<?php
    $i=1;
    if($integrante)
    {
        foreach($integrantes as $integ)
        {
            echo    "<tr>
                        <td>$i</td>
                        <td>".$integ->estudiante->nombres_apellidos."</td>";
            
            echo    "</tr>";
            $i++;
        }
    }
?>
    </tbody>
</table>



<?php }  */ ?>

<?php //= Html::a('Dejar equipo',['#'],['class'=>'btn btn-primary','onclick'=>'dejarequipo('.$estudiante->id.')']);?>





 
<p></p>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Inscribir a mi equipo</h3>
    </div>
    <div class="panel-body">
        asdasd asd adas dasdasd adad asdas dasd ad asds
    </div>
</div>


<?php
if(!$lider && !$integrante)
{
echo Html::a('Crear equipo',['inscripcion/index'],['class'=>'btn btn-primary']);
}
if($lider)
{
echo Html::a('Actualizar equipo',['inscripcion/actualizar','id'=>$estudiante->id],['class'=>'btn btn-primary']);
echo " <button class='btn' onclick='dejarequipo(".$estudiante->id.")'>Eliminar equipo</button>";
}
?>





<?php
    $unirme= Yii::$app->getUrlManager()->createUrl('equipo/unirme');
    $validarunirme=Yii::$app->getUrlManager()->createUrl('equipo/validarunirme');
    $rechazar= Yii::$app->getUrlManager()->createUrl('equipo/rechazar');
    $dejarequipo= Yii::$app->getUrlManager()->createUrl('equipo/dejarequipo');
    $eliminarinvitado= Yii::$app->getUrlManager()->createUrl('equipo/eliminarinvitado');
    $eliminarintegrante= Yii::$app->getUrlManager()->createUrl('equipo/eliminarintegrante');
    $validarequipo= Yii::$app->getUrlManager()->createUrl('equipo/validarequipo');
    $finalizarequipo= Yii::$app->getUrlManager()->createUrl('equipo/finalizarequipo');
    
?>
<script nonce="<?= getnonceideas() ?>" >
function unirme(id) {
    var validarunirme=1;
    $.ajax({
        url: '<?php echo $validarunirme ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            if (data==0) {
                $.notify({
                    // options
                    message: 'Oe ya ps, no te meches con el lider, ya te elimino XD! :v' 
                },{
                    // settings
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
                validarunirme=0;
                console.log(validarunirme);
            }
            else
            {
                $.ajax({
                    url: '<?php echo $unirme ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id},
                    success: function(data){
                        $.notify({
                            // options
                            message: 'Gracias se ha unido al equipo lalal :v :3 -.-!! o.O :D ' 
                        },{
                            // settings
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
                });
            }
            
        }
    });
    
    
}


function rechazar(id) {
    $.ajax({
        url: '<?php echo $rechazar ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            $.notify({
                // options
                message: 'Ha rechazado la invitacion porque ahhh , dime pues ps porq Grr -.-!! o.O :D , no se baya joven :v' 
            },{
                // settings
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
}

function dejarequipo(id) {
    
    $.ajax({
        url: '<?php echo $validarequipo ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            if (data==1) {
                $.notify({
                    // options
                    message: 'Ya no pertenecs al equipo o el lider a eliminado el equipo' 
                },{
                    // settings
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
            else
            {
                $.ajax({
                    url: '<?php echo $dejarequipo ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id},
                    success: function(data){
                        $.notify({
                            // options
                            message: 'Porque nos dejas :( , somos un equipo recuerdanos :\'(' 
                        },{
                            // settings
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
            }
            
        }
    });
    
    
}


function eliminarinvitado(id) {
    $.ajax({
        url: '<?php echo $eliminarinvitado ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            $.notify({
                // options
                message: 'Que malo, lo ilusionas con una invitacion ahora lo eliminas, mal amigo :v :3' 
            },{
                // settings
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
    });
}

function eliminarintegrante(id) {
    $.ajax({
        url: '<?php echo $eliminarintegrante ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            $.notify({
                // options
                message: 'Porque me scas si soy parte del equipo, malooooo :v :v :3' 
            },{
                // settings
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
    });
}


function finalizarequipo(id) {
    $.ajax({
        url: '<?php echo $finalizarequipo ?>',
        type: 'GET',
        async: true,
        data: {id:id},
        success: function(data){
            $.notify({
                // options
                message: 'Team listo, para hacer rush' 
            },{
                // settings
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
    });
}
</script>