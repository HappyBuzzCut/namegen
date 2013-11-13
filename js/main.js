$(document).ready(function () {

	$( document ).ajaxStart(function() {
		$( "#modal" ).show();
	});
	$( document ).ajaxStop(function() {
		$( "#modal" ).hide();
	});
    $("#generate").click(function () {
        $.get("include/ngen.php", {
            namegen: $('input[name=quantity]').val(),
			sex: $('input[name=sex]:checked').val()
			
        })
            .done(function (data) {
                $("#names").html(data);
            });
    });

});