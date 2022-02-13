$(function(){

	var html5Slider = document.getElementById('sell-range');
	if (html5Slider){
		var startPrice = parseInt($('input#sell-min-price').data('min'));
		var maxPrice = parseInt($('input#sell-max-price').data('max'));
		var minCurPrice = parseInt($('input#sell-min-price').val());
		var maxCurPrice = parseInt($('input#sell-max-price').val());


		noUiSlider.create(html5Slider, {
			start: [ minCurPrice, maxCurPrice ],
			connect: true,
			range: {
				'min': [startPrice],
				'max': [maxPrice]
			}
		});

		$('#del_filter').click(function(e){
			e.preventDefault();
			html5Slider.noUiSlider.set([startPrice, maxPrice]);
			$(this).unbind('click').click();
		});

		html5Slider.noUiSlider.on('update', function ( values, handle ) {
			$('.sell-price-range .sell-info-price > .sell-min-price > span').html(parseInt(values[0]));
			$('.sell-price-range .sell-info-price > .sell-max-price > span').html(parseInt(values[1]));
			$('input#sell-min-price').val(parseInt(values[0]));
			$('input#sell-max-price').val(parseInt(values[1]));
		});
	}
});