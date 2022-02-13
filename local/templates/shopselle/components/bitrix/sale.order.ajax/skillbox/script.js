function declOfNum(number, titles) {
	var cases = [2, 0, 1, 1, 1, 2];
	return titles[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];
}

function in_array(needle, haystack, strict) {
	var found = false, key, strict = !!strict;
	for (key in haystack) {
		if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) {
			found = true;
			break;
		}
	}
	return found;
}

/*
 * Упрощенный класс для работы с битриксовой корзиной
 * */
var CustomBitrixCart = function (params) {
};

CustomBitrixCart.prototype.serialize = function (selector, noContainer) {
	var preparedData = $(selector).serializeArray(), i, arRequest = [],
		notInOrderContainer = [
			'sessid',
			'SITE_ID',
		];
	for (i in preparedData) {
		if (preparedData.hasOwnProperty(i)) {
			if (in_array(preparedData[i].name, notInOrderContainer) || noContainer == true) {
				arRequest.push(
					{
						name: preparedData[i].name,
						value: preparedData[i].value,
					}
				);
			} else {
				arRequest.push(
					{
						name: 'order[' + preparedData[i].name + ']',
						value: preparedData[i].value,
					}
				);
			}
		}
	}

	arRequest.push({name: 'signedParamsString', value: sign});
	return arRequest;
};

CustomBitrixCart.prototype.updatePage = function (result) {
	//--------------------------доставки
	$('.js_delivery_block').hide();
	$('.js_delivery_block .form-group').each(function (index, value) {
		$(value).remove();
	});

	$.each(result.order.DELIVERY, function (index, value) {
		var check = '', priceStr = '', timeStr = '';
		if (value.CHECKED == 'Y') {
			check = 'checked="checked"';
		}
		if (value.PRICE == 0) {
			priceStr = 'Бесплатно';
		} else {
			priceStr = value.PRICE_FORMATED;
		}
		if (value.PERIOD_TEXT) {
			var newText = value.PERIOD_TEXT.replace('В днях:', '').trim();
			var endStr = declOfNum(newText, ['день', 'дня', 'дней']);
			timeStr = 'Срок доставки ' + newText + ' ' + endStr + ', с момента передачи заказа в транспортную компанию';
		}
		var content = '<div class="form-group white-box" id="delivery_id_' + value.ID + '"><div class="row"><div class="col-sm-10"><label class="radio"><input type="radio" name="DELIVERY_ID" value="' + value.ID + '" ' + check + '><span class="radio-indicator"></span><span class="radio-title">' + value.NAME + '</span><br>' + value.DESCRIPTION + '<span class="js_delivery_time">' + timeStr + '</span></label></div><div class="col-sm-2"><div class="order-form_price">' + priceStr + '</div></div></div></div>';
		$('.js_delivery_block').append(content);
	});
	$('.js_delivery_block').show();


	//--------------------------способы оплаты
	$('.js_paysystem_block').hide();
	$('.js_paysystem_block .form-group').each(function (index, value) {
		$(value).remove();
	});
	$.each(result.order.PAY_SYSTEM, function (index, value) {
		if (value.CHECKED == 'Y') {
			var check = 'checked="checked"';
		}
		var content = '<div class="form-group white-box" id="paysystem_id_' + value.ID + '"><div class="row"><div class="col-sm-10"><label class="radio"><input type="radio" name="PAY_SYSTEM_ID" value="' + value.ID + '" ' + check + '><span class="radio-indicator"></span><span class="radio-title">' + value.NAME + '</span><br>' + value.DESCRIPTION + '</label></div>        <div class="col-sm-2"><div class="order-form_price"></div></div></div></div>';
		$('.js_paysystem_block').append(content);
	});
	$('.js_paysystem_block').show();

	//--------------------------итого
	$('.js_delivery_price').html(result.order.TOTAL.DELIVERY_PRICE_FORMATED);
	$('.js_itogo_price').html(result.order.TOTAL.ORDER_TOTAL_PRICE_FORMATED);

	//поле адреса
	var showAddress = false;
	$.each(result.order.ORDER_PROP.properties, function (index, value) {
		if (value.ID == 21) {
			showAddress = true;
		}
	});

	if (showAddress) {
		$('#addressField').show();
	} else {
		$('#addressField').hide();
	}

	$('.preloaderOn').each(
		function () {
			$(this).addClass("preAnimation").delay(1000).queue(function (next) {
				$(this).removeClass("preAnimation").removeClass('preloaderOn');
				next();
			});
		}
	);
}

CustomBitrixCart.prototype.validation = function () {
	//TODO:придумать валидацию
	return true;
}

CustomBitrixCart.prototype.updateAjaxData = function () {
	$('#mainBlockOrder').addClass('preloaderOn');
	var arRequest = this.serialize('#orderForm');
	arRequest.push({name: 'soa-action', value: 'saveOrderAjax'});
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: '/bitrix/components/bitrix/sale.order.ajax/ajax.php',
		data: arRequest,
		success: function (data) {
			cart.updatePage(data);
		}
	});
};

CustomBitrixCart.prototype.createOrder = function () {
	if (this.validation()) {
		$('#mainBlockOrder').addClass('preloaderOn');
		var arRequest = this.serialize('#orderForm', true);
		arRequest.push({name: 'action', value: 'saveOrderAjax'});
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: '/order/index.php',
			data: arRequest,
			success: function (data) {
				if (data.order.REDIRECT_URL) {
					window.location.href = data.order.REDIRECT_URL;
				} else {
					var text = '';
					$.each(data.order.ERROR.PROPERTY, function (index, value) {
						text += value + '<br>';
					});
					$('#error_text').show().html('Проверьте правильность полей!<br>' + text);
					$('.preloaderOn').each(
						function () {
							$(this).addClass("preAnimation").delay(1000).queue(function (next) {
								$(this).removeClass("preAnimation").removeClass('preloaderOn');
								next();
							});
						}
					);
				}
			}
		});
	}
}

var cart = new CustomBitrixCart();

$(function () {
	$('.js-client-order').on('click', function () {
		$(this).parent().toggleClass('open');
	});

	$(document).on('change', "input[name$='DELIVERY_ID']", function () {
		cart.updateAjaxData();
	});

	$(document).on('change', "input[name$='PAY_SYSTEM_ID']", function () {
		cart.updateAjaxData();
	});

	$(document).on('submit', '#orderForm', function (e) {
		e.preventDefault();
		cart.createOrder();
		return false;
	});

	cart.updateAjaxData();
});