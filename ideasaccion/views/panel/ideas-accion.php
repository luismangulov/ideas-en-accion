<?php
$this->title = 'Ideas en acción';
?>


<div class="popup" id="msg">
    <div class="popup_content">
        <a href="#" class="close_popup"><img src="<?= \Yii::$app->request->BaseUrl ?>/images/vote_popup_close.png" alt=""></a>
        <form action="#" method="get">
            <div class="form-group text-center" style="font-size: 16px"><br>
<?= $msg ?>
            </div>
        </form>
    </div>
</div>
<?php if (Yii::$app->session->hasFlash('lightbox')): ?>
    <script>
        $('#msg').show();

        $(".popup .close_popup,.popup .btn_close_popup").on('click', function(e) {
            e.preventDefault();
            var _popup = $(this).parents('.popup');
            _popup.hide();

        });

    </script>
<?php endif; ?>

<div class="box_head title_content_box">
    <img src="<?= \Yii::$app->request->BaseUrl ?>/img/icon_ideas_big.png" alt=""> Ideas en acción
</div>
<div ng-app="ideasaccion" class="box_content">
    <div class="mapa_infografiax">
        <!--<img src="<?= \Yii::$app->request->BaseUrl ?>/img/person_1_infografia.png" class="person_1">
        <img src="<?= \Yii::$app->request->BaseUrl ?>/img/person_2_infografia.png" class="person_2">
         <div class="cuadros paso_1" ng-controller="PrimeroController">
                <div class="titulo_cuadro">¡Sumérgete en la información!</div>
                <div class="contenido_cuadro">
                                <label style="padding-left: 0px;">
                                    <span class="fa fa-fw fa-check-square"></span> Video
                                </label><br>
                                <label style="padding-left: 0px;">
                                    <span class="fa fa-fw fa-check-square"></span> Base
                                </label><br>
                                <label style="padding-left: 0px;">
                                    <span class="fa fa-fw fa-check-square"></span> Asuntos Públicos
                                </label>
                </div>
        </div>
        
        
        <div class="cuadros paso_2" ng-controller="SegundoController" ng-show="segundo">
                <div class="titulo_cuadro">¡Vota ya!</div>
                <div class="contenido_cuadro">
                        <a class=' popover1' data-type='html' style="cursor: pointer"  data-title="Los asuntos públicos seleccionados" data-content="{{asuntos}}" data-placement="top">Los asuntos públicos seleccionados</a>
                </div>
        </div>
        
        <div class="cuadros paso_3" ng-controller="TerceroController" >
                <div class="titulo_cuadro">{{titulo3}}</div>
                <div class="contenido_cuadro" ng-show="tercero">
                        <div class="iai_icon" ng-if="icono3 == 1 || icono3 == ''">
                            <img src='<?= \Yii::$app->request->BaseUrl ?>/img/icon_alerta_infografia.png' alt=''><br>
                            
                        </div>
                        <div class="iai_icon" ng-if="icono3 == 2">
                            <img src='<?= \Yii::$app->request->BaseUrl ?>/img/icon_like_infografia.png' alt=''>
                        </div>
                        {{texto3}}
                </div>
        </div>
        
    
        <div class="cuadros paso_4" ng-controller="CuartoController" >
                <div class="titulo_cuadro">{{titulo4}}</div>
                <div class="contenido_cuadro" ng-show="cuarto">
                        <b>{{texto4}}</b><br>
                        <a style="cursor: pointer"  data-toggle="modal" data-target="#tutorial4">{{tutorial4}}<div class="ripple-container"></div></a></br>
                        <a style="cursor: pointer"  data-toggle="modal" data-target="#orientacion4">{{orientacion4}}<div class="ripple-container"></div></a>
                </div>
        </div>
        <div class="cuadros paso_5" ng-controller="QuintoController" >
                <div class="titulo_cuadro">{{titulo5}}</div>
                <div class="contenido_cuadro" ng-show="quinto">
                        <section>
                            <div>
                                <i class="{{checkforoasunto5}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Foro de asuntos públicos" data-content="{{txtforo_asunto}}" data-placement="horizontal">{{txtcheckforoasunto5}}<div class="ripple-container"></div></a>  <br>
                                <i class="{{checkforoabierto5}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Foro Abierto" data-content="{{txtforo_abierto}}" data-placement="horizontal">{{txtcheckforoabierto5}}<div class="ripple-container"></div></a>
                                
                            </div>
                        </section>
                </div>
        </div>
        
        <div class="cuadros paso_6" ng-controller="SextoController" >
                <div class="titulo_cuadro">{{titulo6}}</div>
                <div class="contenido_cuadro" ng-show="sexto">
                        <section>
                            <div>
                                <i class="{{checkproyectoregistrado6}}"></i> {{txtproyectoregistrado6}} <br>
                                <i class="{{checkreflexion6}}"></i> {{txtreflexiones6}}  <br>
                                <i class="{{checkvideo6}}"></i> {{txtvideo6}} <br>
                            </div>
                        </section>
                </div>
        </div>
        
        <div class="cuadros paso_7" ng-controller="SeptimoController" >
                <div class="titulo_cuadro">{{titulo7}}</div>
                <div class="contenido_cuadro" ng-show="septimo">
                        <section>
                            <div>
                                <i class="{{checkaporte7}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Aporte de los integrantes" data-content="{{txtaportesusuarios7}}" data-placement="horizontal">{{txtaportes7}}<div class="ripple-container"></div></a>  <br>
                            </div>
                        </section>
                </div>
        </div>
        <div class="cuadros paso_8" ng-controller="OctavoController" >
                <div class="titulo_cuadro">{{titulo8}}</div>
                <div class="contenido_cuadro" ng-show="octavo">
                        <section>
                            <div>
                                <i class="{{checkvideo8}}"></i> {{txtvideo8}} <br>
                                <i class="{{checkevaluacion8}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Evaluación de los integrantes" data-content="{{txtevaluacionesusuarios8}}" data-placement="horizontal">{{txtevaluaciones8}}<div class="ripple-container"></div></a>  <br>
                            </div>
                        </section>
                </div>
        </div>
        <div class="cuadros paso_9" ng-controller="NovenoController">
                <div class="titulo_cuadro" >{{titulo9}}</div>
                <div class="contenido_cuadro" ng-show="noveno">
                        <div class="checkbox">
                                <label>
                                        <input type="checkbox" value="">
                                        Votación<br>
                                        regional
                                </label>
                        </div>
                </div>
        </div>
        <div class="cuadros paso_10" ng-controller="DecimoController">
                <div class="titulo_cuadro">{{titulo10}}</div>
                <div class="contenido_cuadro" ng-show="decimo">
                        <a href="#" class="btn btn-default">
                                VOTAR >
                        </a>
                </div>
        </div>-->
        <img width="100%" src="<?= \Yii::$app->request->BaseUrl ?>/img/mapa_infografia.png" alt="">
    </div>


    <!--
    <div ng-controller="PrimeroController">
        <h3>¡Comenzamos, nos informamos!</h3>
        <section >
            !Comenzamos, nos informamos¡
            <p>Video</p>
            <p>Bases</p>
            <p>Asuntos Públicos</p>
        </section>
    </div>
    <div ng-controller="SegundoController" ng-show="segundo">
        <h3>¡Arranca la votación!</h3>
        <section>
            Los asuntos públicos seleccionados de tu región son:
            <div ng-repeat="asunto in asuntos">
                <label>{{asunto.descripcion_cabecera}}</label>
            </div>
        </section>
    </div>
    <div ng-controller="TerceroController" ng-show="tercero">
        <h3>{{titulo3}}</h3>
        <section>
            <i class="{{icono3}}"></i> {{texto3}}
        </section>
    </div>
    <div ng-controller="CuartoController" ng-show="cuarto">
        <h3>{{titulo4}}</h3>
        <section>
            <div>
                <p>{{texto4}}</p>
                <a style="cursor: pointer"  data-toggle="modal" data-target="#tutorial4">{{tutorial4}}<div class="ripple-container"></div></a></br>
                <a style="cursor: pointer"  data-toggle="modal" data-target="#orientacion4">{{orientacion4}}<div class="ripple-container"></div></a>
            </div>
        </section>
    </div>
    <div ng-controller="QuintoController" ng-show="quinto">
        <h3>{{titulo5}}</h3>
        <section>
            <div>
                <i class="{{checkforoasunto5}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Foro de asuntos públicos" data-content="{{txtforo_asunto}}" data-placement="horizontal">{{txtcheckforoasunto5}}<div class="ripple-container"></div></a>  <br>
                <i class="{{checkforoabierto5}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Foro Abierto" data-content="{{txtforo_abierto}}" data-placement="horizontal">{{txtcheckforoabierto5}}<div class="ripple-container"></div></a>  
            </div>
        </section>
    </div>
    <div ng-controller="SextoController" ng-show="sexto">
        <h3>{{titulo6}}</h3>
        <section>
            <div>
                <i class="{{checkproyectoregistrado6}}"></i> {{txtproyectoregistrado6}} <br>
                <i class="{{checkreflexion6}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Reflexiones" data-content="{{txtreflexionesusuarios6}}" data-placement="horizontal">{{txtreflexiones6}}<div class="ripple-container"></div></a>  <br>
                <i class="{{checkvideo6}}"></i> {{txtvideo6}} <br>
            </div>
        </section>
    </div>
    <div ng-controller="SeptimoController" ng-show="septimo">
        <h3>{{titulo7}}</h3>
        <section>
            <div>
                <i class="{{checkaporte7}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Aporte de los integrantes" data-content="{{txtaportesusuarios7}}" data-placement="horizontal">{{txtaportes7}}<div class="ripple-container"></div></a>  <br>
            </div>
        </section>
    </div>
    <div ng-controller="OctavoController" ng-show="octavo">
        <h3>{{titulo8}}</h3>
        <section>
            <div>
                <i class="{{checkvideo8}}"></i> {{txtvideo8}} <br>
                <i class="{{checkevaluacion8}}"></i> <a class=' popover1 show-pop' data-type='html' style="cursor: pointer"  data-title="Evaluación de los integrantes" data-content="{{txtevaluacionesusuarios8}}" data-placement="horizontal">{{txtevaluaciones8}}<div class="ripple-container"></div></a>  <br>
            </div>
        </section>
    </div>
    -->

</div>




<div id="tutorial4" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="492" height="277" src="https://www.youtube.com/embed/qjS7HMqyfcg" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="orientacion4" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>
<?php
$primero = Yii::$app->getUrlManager()->createUrl('ruta/primero');
$segundo = Yii::$app->getUrlManager()->createUrl('ruta/segundo');
$tercero = Yii::$app->getUrlManager()->createUrl('ruta/tercero');
$cuarto = Yii::$app->getUrlManager()->createUrl('ruta/cuarto');
$quinto = Yii::$app->getUrlManager()->createUrl('ruta/quinto');
$sexto = Yii::$app->getUrlManager()->createUrl('ruta/sexto');
$septimo = Yii::$app->getUrlManager()->createUrl('ruta/septimo');
$octavo = Yii::$app->getUrlManager()->createUrl('ruta/octavo');
?>

<script>
    //$('a').webuiPopover();

    $('.popover1').webuiPopover();
    var app = angular.module('ideasaccion', []);

    app.controller('PrimeroController', function($scope, $http) {
        $scope.PrimeraEtapa = function()
        {

        }

    });

    app.controller('SegundoController', function($scope, $http) {
        $scope.segundo = false;
        $scope.asuntos = "";
        $scope.SegundaEtapa = function() {
            $http.get('<?= $segundo ?>?usuario=' +<?= \Yii::$app->user->id ?>).success(function(data) {
                //$scope.asuntos = data;
                angular.forEach(data, function(value, key) {

                    $scope.asuntos = $scope.asuntos + xescape(value["descripcion_cabecera"]) + "<br>";

                });

                $scope.segundo = true;
            });
        }
        $scope.SegundaEtapa();
    });


    app.controller('TerceroController', function($scope, $http) {
        $scope.tercero = true;
        $scope.titulo3 = "¡Nos inscribimos!";
        $scope.texto3 = "No has finalizado el registro de tu equipo.";
        $scope.icono3 = "";
        $scope.TerceroEtapa = function() {
            $http.get('<?= $tercero ?>?usuario=' +<?= \Yii::$app->user->id ?>).success(function(data) {
                if (data) {
                    $scope.titulo3 = "¡Nos inscribimos!";
                    if (data[0].estado == '1') {
                        $scope.icono3 = "1";
                        $scope.texto3 = " No has finalizado el registro de tu equipo.";
                    }
                    else if (data[0].estado == '2') {
                        $scope.icono3 = "2";
                        $scope.texto3 = "Tu equipo ya está registrado";
                    }
                    $scope.tercero = true;
                }
            });
        }
        $scope.TerceroEtapa();
    });

    app.controller('CuartoController', function($scope, $http) {
        $scope.cuarto = false;
        $scope.titulo4 = "Dominamos los materiales";
        $scope.texto4 = "";
        $scope.tutorial4 = "";
        $scope.orientacion4 = "";
        $scope.CuartoEtapa = function() {
            $http.get('<?= $cuarto ?>?usuario=' +<?= \Yii::$app->user->id ?>).success(function(data) {

                if (data) {
                    $scope.titulo4 = "Dominamos los materiales";
                    $scope.tutorial4 = "Tutoriales";
                    $scope.orientacion4 = "Orientación";
                    $scope.cuarto = true;
                }
            });
        }
        $scope.CuartoEtapa();
    });


    app.controller('QuintoController', function($scope, $http) {
        $scope.quinto = false;
        $scope.titulo5 = "Empieza la participación";
        $scope.texto5 = "";
        $scope.checkforoasunto5 = "";
        $scope.txtcheckforoasunto5 = "";
        $scope.checkforoabierto5 = "";
        $scope.txtcheckforoabierto5 = "";
        $scope.txtforo_abierto = "";
        $scope.txtforo_asunto = "";

        $scope.QuintoEtapa = function() {
            $http.get('<?= $quinto ?>?usuario=' +<?= \Yii::$app->user->id ?>).success(function(data) {
                if (data) {
                    $scope.titulo5 = "Empieza la participación";
                    $scope.txtcheckforoasunto5 = "Foro de asuntos";
                    $scope.txtcheckforoabierto5 = "Foro abierto";
                    $scope.forosasuntos = data[0]["foro_asunto"];
                    $scope.forosabiertos = data[1]["foro_abierto"];
                    angular.forEach($scope.forosasuntos, function(value, key) {
                        if (value["entradas_asunto"] == 0) {
                            $scope.txtforo_asunto = $scope.txtforo_asunto + "<i class='fa fa-fw fa-exclamation-triangle'></i>" + value["nombres_apellidos_asunto"] + "(" + value["entradas_asunto"] + " comentarios)<br>";
                        }
                        else
                        {
                            $scope.txtforo_asunto = $scope.txtforo_asunto + "<i class='fa fa-fw fa-check-square'></i>" + value["nombres_apellidos_asunto"] + "(" + value["entradas_asunto"] + " comentarios)<br>";
                        }
                    });

                    angular.forEach($scope.forosabiertos, function(value, key) {
                        if (value["entradas_abierto"] == 0) {
                            $scope.txtforo_abierto = $scope.txtforo_abierto + "<i class='fa fa-fw fa-exclamation-triangle'></i>" + value["nombres_apellidos_abierto"] + "(" + value["entradas_abierto"] + " comentarios)<br>";
                        }
                        else
                        {
                            $scope.txtforo_abierto = $scope.txtforo_abierto + "<i class='fa fa-fw fa-check-square'></i>" + value["nombres_apellidos_abierto"] + "(" + value["entradas_abierto"] + " comentarios)<br>";
                        }
                    });

                    if (data[2]["checkasunto"] == 0) {
                        $scope.checkforoasunto5 = "fa fa-fw fa-exclamation-triangle";
                    } else {
                        $scope.checkforoasunto5 = "fa fa-fw fa-check-square";
                    }

                    if (data[2]["checkabierto"] == 0) {
                        $scope.checkforoabierto5 = "fa fa-fw fa-exclamation-triangle";
                    } else {
                        $scope.checkforoabierto5 = "fa fa-fw fa-check-square";
                    }
                    $scope.quinto = true;
                }
            });
        }
        $scope.QuintoEtapa();
    });


    app.controller('SextoController', function($scope, $http) {
        $scope.sexto = false;
        $scope.titulo6 = "¡Sale la primera entrega!";
        $scope.checkproyectoregistrado6 = "";
        $scope.txtproyectoregistrado6 = "";
        $scope.checkreflexion6 = "";
        $scope.txtreflexion6 = "Reflexión del equipo";
        $scope.txtreflexionesusuarios6 = "";
        $scope.checkvideo6 = "";
        $scope.txtvideo6 = "";
        $scope.SextoEtapa = function() {
            $http.get('<?= $sexto ?>?usuario=' +<?= \Yii::$app->user->id ?>).success(function(data) {
                if (data) {
                    $scope.titulo6 = "¡Sale la primera entrega!";
                    $scope.txtreflexiones6 = "Reflexión del equipo";
                    $scope.txtvideo6 = "Publicación del video";
                    $scope.txtproyectoregistrado6 = "Registro del proyecto";
                    if (data[0]["proyecto_registrado"] == 0) {
                        $scope.checkproyectoregistrado6 = "fa fa-fw fa-exclamation-triangle";
                    }
                    else
                    {
                        $scope.checkproyectoregistrado6 = "fa fa-fw fa-check-square";
                    }

                    if (data[0]["checkvideo"] == 0) {
                        $scope.checkvideo6 = "fa fa-fw fa-exclamation-triangle";
                    }
                    else
                    {
                        $scope.checkvideo6 = "fa fa-fw fa-check-square";
                    }

                    if (data[0]["checkreflexion"] == 0) {
                        $scope.checkreflexion6 = "fa fa-fw fa-exclamation-triangle";
                    }
                    else
                    {
                        $scope.checkreflexion6 = "fa fa-fw fa-check-square";
                    }
                    /*$scope.reflexiones=data[0]["reflexiones"];
                     angular.forEach( $scope.reflexiones, function(value, key) {
                     if (value["entradas"]==0) {
                     $scope.txtreflexionesusuarios6=$scope.txtreflexionesusuarios6+"<i class='fa fa-fw fa-exclamation-triangle'></i>"+value["nombres_apellidos"]+" <br>";
                     }
                     else
                     {
                     $scope.txtreflexionesusuarios6=$scope.txtreflexionesusuarios6+"<i class='fa fa-fw fa-check-square'></i>"+value["nombres_apellidos"]+" <br>";
                     }
                     });*/
                    $scope.sexto = true;
                }
            });
        }
        $scope.SextoEtapa();
    });






    app.controller('SeptimoController', function($scope, $http) {
        $scope.septimo = false;
        $scope.titulo7 = "Aportamos para crecer";
        $scope.checkaporte7 = "";
        $scope.txtaportes7 = "";
        $scope.txtaportesusuarios7 = "";
        $scope.SeptimoEtapa = function() {
            $http.get('<?= $septimo ?>?usuario=' +<?= \Yii::$app->user->id ?>).success(function(data) {
                if (data) {
                    $scope.titulo7 = "Aportamos para crecer";
                    $scope.txtaportes7 = "Aportes";
                    if (data[1]["checkaporte"] == 0) {
                        $scope.checkaporte7 = "fa fa-fw fa-exclamation-triangle";
                    }
                    else
                    {
                        $scope.checkaporte7 = "fa fa-fw fa-check-square";
                    }
                    $scope.aportes = data[0]["aportes"];
                    angular.forEach($scope.aportes, function(value, key) {
                        if (value["entradas"] == 0) {
                            $scope.txtaportesusuarios7 = $scope.txtaportesusuarios7 + "<i class='fa fa-fw fa-exclamation-triangle'></i>" + value["nombres_apellidos"] + "(" + value["entradas"] + " entradas)<br>";
                        }
                        else
                        {
                            $scope.txtaportesusuarios7 = $scope.txtaportesusuarios7 + "<i class='fa fa-fw fa-check-square'></i>" + value["nombres_apellidos"] + "(" + value["entradas"] + " entradas)<br>";
                        }
                    });
                    $scope.septimo = true;
                }


            });
        }
        $scope.SeptimoEtapa();
    });


    app.controller('OctavoController', function($scope, $http) {
        $scope.octavo = false;
        $scope.titulo8 = "¡Lista la segunda entrega!";
        $scope.checkvideo8 = "";
        $scope.txtvideo8 = "";
        $scope.checkevaluacion8 = "";
        $scope.txtevaluacionesusuarios8 = "";
        $scope.txtevaluaciones8 = "";
        $scope.OctavaEtapa = function() {
            $http.get('<?= $octavo ?>?usuario=' +<?= \Yii::$app->user->id ?>).success(function(data) {
                if (data) {
                    console.log(data);
                    $scope.titulo8 = "¡Lista la segunda entrega!";
                    $scope.txtvideo8 = "Publicación del video";
                    if (data[1]["checkvideo"] == 0) {
                        $scope.checkvideo8 = "fa fa-fw fa-exclamation-triangle";
                    }
                    else
                    {
                        $scope.checkvideo8 = "fa fa-fw fa-check-square";
                    }
                    if (data[1]["checkevaluacion"] == 0) {
                        $scope.checkevaluacion8 = "fa fa-fw fa-exclamation-triangle";
                    }
                    else
                    {
                        $scope.checkevaluacion8 = "fa fa-fw fa-check-square";
                    }

                    $scope.txtevaluaciones8 = "Evaluaciones";
                    $scope.evaluaciones = data[0]["evaluaciones"];
                    angular.forEach($scope.evaluaciones, function(value, key) {
                        if (value["entradas"] == 0) {
                            $scope.txtevaluacionesusuarios8 = $scope.txtevaluacionesusuarios8 + "<i class='fa fa-fw fa-exclamation-triangle'></i>" + value["nombres_apellidos"] + " <br>";
                        }
                        else
                        {
                            $scope.txtevaluacionesusuarios8 = $scope.txtevaluacionesusuarios8 + "<i class='fa fa-fw fa-check-square'></i>" + value["nombres_apellidos"] + " <br>";
                        }
                    });
                    $scope.octavo = true;

                }
            });
        }
        $scope.OctavaEtapa();
    });

    app.controller('NovenoController', function($scope, $http) {
        $scope.noveno = false;
        $scope.titulo9 = "Reconocemos a los 3 mejores";

    });

    app.controller('DecimoController', function($scope, $http) {
        $scope.decimo = false;
        $scope.titulo10 = "Elegimos a los mejores";

    });
</script>
<script type="text/javascript">
$( document ).ready(function() {
  // Handler for .ready() called.
  
  $("#lnk_ideasaccion").attr("class","active");
});



</script>