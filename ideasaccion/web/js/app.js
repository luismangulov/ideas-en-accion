$(document).ready(function(){
	$(".upload_photo").click(function(e) {
		e.preventDefault();
		$("#upload_photo").click();
	});

	$(".menu_lateral li a.sub_menu").on("click", function (e) {
		e.preventDefault();
		var _a  = $(this);
		var _li = _a.parent();

		_a.toggleClass("active");
		$("ul", _li).stop(true).slideToggle();
	});

	$(document).on('click', '.popup .close_popup', function (e) {
		e.preventDefault();
		$(this).parent().parent().hide();
	});

	$(document).on('click', '.open_popup_foros_asuntos', function (e) {
		e.preventDefault();
		$('.popup_foro_asuntos_publicos').show();
	});

	$(document).on('click', '.popup_realizar_reporte', function (e) {
		e.preventDefault();
		$('.realizar_reporte').show();
	});

	$(document).on('click', '.popup_mi_busqueda .popup_close', function (e) {
		e.preventDefault();
		$(this).parent().parent().hide();
		$('.md').modal('hide');
	});

	$(document).on('click', '.box_content_option .btn_votation_item', function (e) {
	    e.preventDefault();
	    var obj = $(this);
	    var div = obj.parent();
	    if(!obj.hasClass("active")){
		var apply = false;

		$(".col_right_options .box_votation_small").each(function(){
		    var _div = $(this);
		    if(apply == false){
			if(_div.attr("data-option") == ""){
			    apply = true;
			    _div.addClass("active");
			    _div.attr("data-option", div.data("id"));
			    
			    $(".box_votacion_content", _div).html(div.data("title"));
			    
			    $("#input_votation_"+ _div.data("id")).val(div.data("id"));
			    
			    $.ajax({
				url:  'votacioninterna',
				type: 'GET',
				async: true,
				data: {id:div.data("id")},
				success: function(data){
				    
				}
			    });
			}
		    }
		});

		if(apply){
		    obj.addClass("active");
		}else{
		    alert("Solo se pueden agregar 3 opciones.");
		}
	    }
	});

	$(document).on('click', '.col_right_options .box_votation_small .icon_delete_box', function (e) {
		e.preventDefault();
		var obj = $(this);
		var div = obj.parent();
		
		if(div.hasClass("active")){
			div.removeClass("active");
			
			$(".col_left_options .box_content_option").each(function(){
				var _div = $(this);

				if(_div.attr("data-id") == div.attr("data-option")){
					var id=div.attr("data-option");// console.log(div.attr("data-option"));
					div.attr("data-option", "");
					$(".btn_votation_item", _div).removeClass("active");

					$("#input_votation_"+ div.attr("data-id")).val("");
					
					$.ajax({
					    url:  'votacioninternaeliminar',
					    type: 'GET',
					    async: true,
					    data: {id:id},
					    success: function(data){
						
					    }
					});
				}
			});
		}
	});

	
});
