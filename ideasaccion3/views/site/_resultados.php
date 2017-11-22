<?php
use app\models\Ubigeo;

?>

<style>
.btn-circle {
  width: 49px;
  height: 49px;
  text-align: center;
  padding: 5px 0;
  font-size: 20px;
  line-height: 2.00;
  border-radius: 30px;
}
.hotspot
{
   width:26px;
height:26px;
border-radius:%50;
border:2px solid #fff;
box-shadow:0 0 1px #666,inset 0 0 1px #666;
opacity:.8;
position:absolute;
z-index:10; 
}


</style>
<br>

<div class="col-lg-12 col-md-12 col-sm-12 visible-lg-block visible-md-block visible-sm-block">
    <div id="14" style="width: 100px;height: 100px;background: black;color: white">
	<a href="#aboutModal" class="lima btn btn-circle btn-default">L</a>
	<div class="po-content hidden">
	    <div class="po-title">
		Región Lima
	    </div> <!-- ./po-title -->
		
	    <div class="po-body">
		
	    </div><!-- ./po-body -->
	</div>  <!-- ./po-content -->
    </div>
    <div id="01" style="width: 100px;height: 100px;background: white">
	<a href="#aboutModal" class="amazonas btn btn-circle btn-primary">A</a>
	
    </div>
</div>

<div class="col-xs-12 visible-xs-block">
    <select class="form-control" onchange="Resultados($(this).val())">
	<option value>Seleccionar</option>
	<?php foreach(Ubigeo::find()->select('department_id,department')->groupBy('department')->all() as $departamento){ ?>
	    <option value="<?= $departamento->department_id ?>"><?= $departamento->department ?></option>
	<?php } ?>
    </select>
    <div id="resultados"></div>
</div>
<?php
    $url= Yii::$app->getUrlManager()->createUrl('voto/resultados');
    $this->registerJs(
    "$('document').ready(function(){
	    
    
	    $('.lima').popoverasync({
		'container': 'body',
                'placement': 'right',
		'trigger': 'hover',
		'title': function() {
		    return $(this).parent().find('.po-title').html();
		},
		'html': true,
		'content': function (callback, extensionRef) {
		    $.ajax({
			url: '$url',
			dataType: 'html',
			type: 'GET',
			data: {region:14},
			success: function(fetchedData){
			   callback(extensionRef, fetchedData);
			}
		    });

                }
            });
    
    })");
?>

<script nonce="<?= getnonceideas() ?>" >
function Resultados(value) {
    $.ajax({
	url: '<?= $url ?>',
	type: 'GET',
	data: {region:value},
	success: function(data){
	   $('#resultados').html(data);
	}
    });
}
</script>