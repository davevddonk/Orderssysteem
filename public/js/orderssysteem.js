+function ($) {
	var i = 1;
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

	$('#dateSearch2').on('change', function(e){
	    var select = $(this), form = select.closest('form');
	    form.attr('action', '/Chauffeurs/'+ $("#hid").val() +'/Search/' + select.val());
	    form.submit();
	});

	$('#orderSearch').on('change', function(e){
	    var select = $(this), form = select.closest('form');
	    form.attr('action', '/Orders/Search/' + select.val());
	    form.submit();
	});

	$('#addArticle').on('click', function(e){
		i++;

		$('#extraArticles').append('<div class="form-group col-md-8"><label class="control-label" for="articlename">Artikel:</label><input id="articlename" class="form-control" name="articlename[]" type="text"></div><div class="form-group col-md-4"><label class="control-label" for="ammount">Aantal :</label><input id="ammount" class="form-control" name="ammount[]" type="text"></div>');

	});

	$('#datetimepicker1').datetimepicker({
		useCurrent: "year",
		useCurrent: "month",
		useCurrent: "day",
		useCurrent: "hour",
		useCurrent: "minute",
		format : "hh:mm DD-MM-YYYY"
	});
	$('#datetimepicker2').datetimepicker({
		useCurrent: "year",
		useCurrent: "month",
		useCurrent: "day",
		useCurrent: "hour",
		useCurrent: "minute",
		format : "hh:mm DD-MM-YYYY"
	});
	$('#datepicker').datetimepicker({
		useCurrent: "year",
		useCurrent: "month",
		useCurrent: "day",
		format : "DD-MM-YYYY"
	});

	$('#backbutton').on('click', function(e){
		parent.history.back();
	});

}(jQuery);