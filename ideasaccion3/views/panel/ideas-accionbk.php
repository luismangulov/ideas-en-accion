<?php
use app\models\ForoComentario;
use app\models\Proyecto;
use app\models\Cronograma;
use app\models\PlanPresupuestal;
use app\models\Video;
use app\models\Reflexion;
use app\models\Evaluacion;
use app\models\Integrante;
use app\models\VotacionInterna;

?>
<h1>Ideas en acción</h1>
<div class="col-md-12">
    <h2>I. Equipo</h2>
    <hr>
    <?php
        if($equipo->estado==1){
            echo "<span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span> Tu equipo ya se encuentra inscrito";
        }
        elseif($equipo->estado==0)
        {
            echo "<span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span> Tu equipo no se encuentra inscrito";
        }
    ?>
</div>
<div class="clearfix"></div>
<?php if($equipo->estado==1){ ?>
<div class="col-md-12">
    <h2>II. Participación en Foro</h2>
    <hr>
    <p>Tu equipo tiene la siguiente participación</p>
    <table class="table">
        <thead>
            <th></th>
            <th>Integrante</th>
            <th>Asuntos Públicos</th>
            <th>Asuntos Privados</th>
        </thead>
        <tbody>
            <?php foreach($integrantes as $integrante){ ?>
            <?php
                $foropublico=ForoComentario::find()
                            ->innerJoin('foro','foro.id=foro_comentario.foro_id')
                            ->where('foro_comentario.user_id=:user_id  and
                                    foro.asunto_id=:asunto_id',[':user_id'=>$integrante->user_id,
                                                                ':asunto_id'=>$equipo->asunto_id])
                            ->count();
                $foroprivado=ForoComentario::find()->where('user_id=:user_id and foro_id=2',[':user_id'=>$integrante->user_id])->count();
            ?>
            <tr>
                <td>
                <?php if ($foropublico==0 || $foroprivado==0){ ?>
                    <span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'></span>
                <?php } else { ?>
                    <span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'></span>
                <?php }?>
                </td>
                <td><?= $integrante->nombres." ".$integrante->apellido_paterno." ".$integrante->apellido_materno?></td>
                <td><?= $foropublico ?></td>
                <td><?= $foroprivado ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php $proyecto=Proyecto::find()->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])->one(); ?>
<div class="clearfix"></div>
<div class="col-md-12">
    <h2>III. Registro del Proyecto</h2>
    <hr>
    <?php
        if($proyecto){
        $Countcronograma=Cronograma::find()
                    ->select('  cronograma.id,cronograma.fecha_inicio,cronograma.fecha_fin,
                                cronograma.duracion,cronograma.responsable_id,cronograma.estado,
                                cronograma.actividad_id,objetivo_especifico.id objetivo_especifico_id')
                    ->innerJoin('actividad','actividad.id=cronograma.actividad_id')
                    ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.objetivo_especifico_id')
                    ->where('objetivo_especifico.proyecto_id=:proyecto_id and actividad.estado=1 and cronograma.estado=1',[':proyecto_id'=>$proyecto->id])
                    ->count();
        $Countplanespresupuestal=PlanPresupuestal::find()
                    ->select('  plan_presupuestal.id,plan_presupuestal.recurso,plan_presupuestal.como_conseguirlo,
                                plan_presupuestal.precio_unitario,plan_presupuestal.cantidad,plan_presupuestal.subtotal,
                                plan_presupuestal.actividad_id,objetivo_especifico.id objetivo_especifico_id')
                    ->innerJoin('actividad','actividad.id=plan_presupuestal.actividad_id')
                    ->innerJoin('objetivo_especifico','objetivo_especifico.id=actividad.objetivo_especifico_id')
                    ->where('objetivo_especifico.proyecto_id=:proyecto_id and actividad.estado=1 and plan_presupuestal.estado=1',[':proyecto_id'=>$proyecto->id])
                    ->count();
        }
        
    ?>
    <?php if($proyecto){ ?>
        <span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span> Datos<br>
        <span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span> Objetivos<br>
    <?php }else{ ?>
        <span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span> Datos<br>
        <span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span> Objetivos<br>
    <?php } ?>
    
    <?php if($proyecto && $Countcronograma>0){?>
        <span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span> Cronograma<br>
    <?php }else{ ?>
        <span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span> Cronograma<br>
    <?php } ?>
    
    <?php if($proyecto && $Countplanespresupuestal>0){?>
        <span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span> Plan Presupuestal<br>
    <?php }else{ ?>
        <span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span> Plan Presupuestal<br>
    <?php } ?>
</div>
<?php
if($proyecto)
{
?>
<div class="col-md-12">
    <h2>IV. Mi video Primera Entrega</h2>
    <hr>
    <?php
    
        $videoPrimero=Video::find()->where('proyecto_id=:proyecto_id and etapa in(0,1)',[':proyecto_id'=>$proyecto->id])->one();
    
    ?>
    
    <?php if($proyecto && $videoPrimero){?>
        <span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span> Video
    <?php }else{ ?>
        <span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span> Video
    <?php } ?>
    
</div>
<?php } ?>
<?php
if($proyecto)
{
?>
<div class="col-md-12">
    <h2>V. Reflexión</h2>
    <hr>
    <?php
        $reflexiones=Reflexion::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->all();
    ?>
    <?php
        foreach($reflexiones as $reflexion){
            if(trim($reflexion->reflexion)!='')
            {
                echo "<span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span>".$reflexion->usuario->estudiante->nombres." ".$reflexion->usuario->estudiante->apellido_paterno." ".$reflexion->usuario->estudiante->apellido_materno." <br>";
            }
            else
            {
                echo "<span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span>".$reflexion->usuario->estudiante->nombres." ".$reflexion->usuario->estudiante->apellido_paterno." ".$reflexion->usuario->estudiante->apellido_materno." <br>";
            }
        }
    ?>
</div>
<?php } ?>
    <?php if(($equipo->etapa==1 || $equipo->etapa==2) && ($etapa->etapa==2 || $etapa->etapa==3)) {?>
    <div class="col-md-12">
        <h2>VI. Recomendación de proyectos</h2>
        <hr>
        <table class="table">
            <thead>
                <th></th>
                <th>Integrante</th>
                <th>Comentarios en los Proyectos</th>
            </thead>
            <tbody>
                <?php foreach($integrantes as $integrante){ ?>
                <?php
                    $foroproyectos=ForoComentario::find()->where('user_id=:user_id and foro_id>35',[':user_id'=>$integrante->user_id])->count();
                    
                ?>
                <tr>
                    <td>
                    <?php if ($foroproyectos==0){ ?>
                        <span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'></span>
                    <?php } else { ?>
                        <span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'></span>
                    <?php }?>
                    </td>
                    <td><?= $integrante->nombres." ".$integrante->apellido_paterno." ".$integrante->apellido_materno?></td>
                    <td><?= $foroproyectos ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }?>
    <?php
    if($proyecto && ($equipo->etapa==1 || $equipo->etapa==2) && ($etapa->etapa==2 || $etapa->etapa==3))
    {
    ?>
    <div class="col-md-12">
        <h2>VII. Mi video Segunda Entrega</h2>
        <hr>
        <?php
        
            $videoSegundo=Video::find()->where('proyecto_id=:proyecto_id and etapa in(0,2)',[':proyecto_id'=>$proyecto->id])->one();
        
        ?>
        
        <?php if($proyecto && $videoSegundo){?>
            <span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span> Video
        <?php }else{ ?>
            <span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span> Video
        <?php } ?>
        
    </div>
    <?php } ?>
    
    <?php
    if($proyecto &&  ($equipo->etapa==1 || $equipo->etapa==2) && ($etapa->etapa==2 || $etapa->etapa==3))
    {
    ?>
    <div class="col-md-12">
        <h2>VIII. Evaluación</h2>
        <hr>
        <?php
            $evaluaciones=Evaluacion::find()->where('proyecto_id=:proyecto_id',[':proyecto_id'=>$proyecto->id])->all();
        ?>
        <?php
            foreach($evaluaciones as $evaluacion){
                if(trim($evaluacion->evaluacion)!='')
                {
                    echo "<span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span>".$evaluacion->usuario->estudiante->nombres." ".$evaluacion->usuario->estudiante->apellido_paterno." ".$evaluacion->usuario->estudiante->apellido_materno." <br>";
                }
                else
                {
                    echo "<span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span>".$evaluacion->usuario->estudiante->nombres." ".$evaluacion->usuario->estudiante->apellido_paterno." ".$evaluacion->usuario->estudiante->apellido_materno." <br>";
                }
            }
        ?>
    </div>
    <?php } ?>
    
    <?php
    if($proyecto && ($equipo->etapa==2) && $etapa->etapa==3)
    {
        
    ?>
    <div class="col-md-12">
        <h2>IX. Votación Interna</h2>
        <hr>
        <?php
            $Countvotos=Integrante::find()
                            ->select('estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno')
                            ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                            ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                            ->innerJoin('votacion_interna','votacion_interna.user_id=usuario.id')
                            ->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])
                            ->count();
        ?>          
        <p>Tu equipo ha realizados <?= $Countvotos ?> votos</p>
        
        <?php
            $votacionesInternas=Integrante::find()
                            ->select('usuario.id user_id,estudiante.nombres,estudiante.apellido_paterno,estudiante.apellido_materno')
                            ->innerJoin('estudiante','estudiante.id=integrante.estudiante_id')
                            ->innerJoin('usuario','usuario.estudiante_id=estudiante.id')
                            ->where('equipo_id=:equipo_id',[':equipo_id'=>$equipo->id])
                            ->all();
                            
            foreach($votacionesInternas as $votacionInterna){
                $votacionIn=VotacionInterna::find()->where('user_id=:user_id',[':user_id'=>$votacionInterna->user_id])->one();
                if($votacionIn)
                {
                    echo "<span style='color:green;font-size:20px;cursor:pointer' class='fa fa-check-circle-o'> </span>".$votacionInterna->nombres." ".$votacionInterna->apellido_paterno." ".$votacionInterna->apellido_materno." <br>";
                }
                else
                {
                    echo "<span style='color:red;font-size:20px;cursor:pointer' class='fa fa-times-circle-o'> </span>".$votacionInterna->nombres." ".$votacionInterna->apellido_paterno." ".$votacionInterna->apellido_materno." <br>";
                }
            }
        ?>
    </div>
    <?php } ?>
<?php } ?>
<div class="clearfix"></div>