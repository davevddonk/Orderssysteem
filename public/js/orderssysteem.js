+function ($) {

	$('#chauffeurSearch').on('change', function(e){
	    var select = $(this), form = select.closest('form');
	    form.attr('action', '/Chauffeurs/Search/' + select.val());
	    form.submit();
	});

	$('#vehicleSearch').on('change', function(e){
	    var select = $(this), form = select.closest('form');
	    form.attr('action', '/Wagens/Search/' + select.val());
	    form.submit();
	});

	$('#dateSearch').on('change', function(e){
	    var select = $(this), form = select.closest('form');
	    form.attr('action', '/Overzicht/Search/' + select.val());
	    form.submit();
	});

	$('#orderSearch').on('change', function(e){
	    var select = $(this), form = select.closest('form');
	    form.attr('action', '/Orders/Search/' + select.val());
	    form.submit();
	});

}(jQuery);