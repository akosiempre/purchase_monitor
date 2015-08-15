//$(function(){
  //$('#autocomplete').autocomplete({
//  $(document).on('change', '.biginput :text', function () {
//$(document).ready(function(){
	
/*$('#autocomplete').keydown(function(){
     $('#autocomplete').autocomplete({
		//source: data,
		//source: eval($('#find').val()),
		source: currencies,
    onSelect: function (suggestion) {
      var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> \
	                 <strong>Symbol:</strong> ' + suggestion.data;
      $('#outputcontent').html(thehtml);
    }
  });

});
*/
$(document).ready(function(){
	$( "input#autocomplete" ).keydown(function() {
		var target = $('input#find').val();
		var list = eval(target);
		$('#autocomplete').autocomplete({
			source: list
		})	
    });
  });

$(function(){
  $('#find').autocomplete({
	source: listing,
    onSelect: function (suggestion) {
      var thehtml = '<strong>Currency Name:</strong> ' + suggestion.val + ' <br> \
	                 <strong>Symbol:</strong> ' + suggestion.data;
      $('#outputcontent').html(thehtml);
    }
  });

});
