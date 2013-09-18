//Funciones generales		
function iniciarLinkTabs(){
	var links=$('[tablink="true"]');
	$.each(links, function(index, element) {
		var link=$(element);
		if ( !link.attr )  return false;
		var destino=link.attr('href');
		link.attr('href','#');
		
		link.attr('tablink',false);
		link.addClass('link');
		
		var titulo=link.attr('titulo');
		link.click(function(){
			TabManager.add(destino,titulo,1);
		});
	});
}

function ajustarTab(){
	var h=$(window).height();			
	var position=$('#tabs').position();			
	var newH = (h-position.top);			
	$('#tabs').css('min-height',newH);			
}

// "$" +subtotal.formatMoney(2,',','.')

Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
    var n = this,
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSeparator = decSeparator == undefined ? "." : decSeparator,
    thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
    sign = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
    return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};

function getMonthName(date) {

    var monthNames = [
    "Ene", "Fec", "Mar",
    "Abr", "May", "Jun",
    "Jul", "Ago", "Sep",
    "Oct", "Nov", "Dic"
    ];

    return monthNames[date.getMonth()];

};