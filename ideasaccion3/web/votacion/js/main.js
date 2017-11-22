var App = {
	'init' : function(){
		App.tooltip();
		App.lightbox();
	},
	
	'lightbox' : function(){
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true
		})
	},
	
	'tooltip' : function(){
		$('.tooltip').tooltipster({
			theme: 'tooltipster-shadow',
			position: 'bottom'
		});
	}
};

$(document).ready(function(){
	App.init();
});