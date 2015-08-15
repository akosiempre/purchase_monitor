<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Twitter Bootstrap Popover Example</title> 
<meta name="description" content="Creating Modal Window with Twitter Bootstrap">
<link href="../styles/css/mod.bootstrap.css" rel="stylesheet"> 
<script src="../styles/js/jquery.js"></script>
<script src="../styles/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
	$("#addButton").click(function () {
		if( ($('.form-inline').length+1) > 2) {
			alert("Only 2 control-group allowed");
			return false;
		}
		var id = ($('.form-inline .control-group').length + 1).toString();
		$('.form-inline').append('<div class="spacer" style="height:15px;"></div>\
								  <div class="form-group detail-itemname" id="control-group' + id + '">\
									<label class="sr-only" for="exampleInputEmail2' + id + '">Item' + id + '</label>\
								  <input type="text" id="email' + id + '" class="form-control" placeholder="Name"> \
								  </div>\
								  <div class="form-group detail-itemqty" id="control-group' + id + '">\
									<label class="sr-only" for="exampleInputPassword2' + id + '">Quantity</label>\
									<input type="email" class="form-control" id="exampleInputPassword2'+ id + '" placeholder="Pieces">\
								  </div>\
								  <div class="form-group detail-itemprice" id="control-group' + id + '">\
									<label class="sr-only" for="exampleInputPassword2' + id + '" >Unit Price</label>\
									<input type="email" class="form-control" id="exampleInputPassword2' + id + '" placeholder="Amount">\
								  </div>  \
								  <div class="form-group detail-itemtot" id="control-group' + id + '">\
									<label class="sr-only" for="exampleInputPassword2' + id + '" >Total</label>\
									<input type="email" class="form-control" id="exampleInputPassword2' + id + '" placeholder="Total Amount">\
								  </div> ');	
	});

	$("#removeButton").click(function () {
		if ($('.form-inline .control-group').length == 1) {
			alert("No more textbox to remove");
			return false;
		}

		$(".form-inline .control-group:last").remove();
	});
});
</script>
</head>
<body>
<div class="container">
<h2>Example of creating Modal with Twitter Bootstrap</h2>
<div class="well">
<a href="#" id="example" class="btn btn-danger" data-content="It's so simple to create a tooltop for my website!" data-original-title="Twitter Bootstrap Popover">
hover for popover
</a>
</div>
<p class="text-center">
    <a data-toggle="modal" href="#modal" class="btn btn-success btn-lg">
        <span class="glyphicon glyphicon-envelope"></span>
                    Message me
    </a>
</p>
<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:830px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Item Details</h4>
      </div>
    <div class="modal-body" >  
<div class="form_holder">
<form class="form-inline" role="form">
  <div  class="form-group detail-itemname" id="control-group">
    <label  for="exampleInputEmail2" >Item</label>
    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Name">
  </div>
  <div class="form-group detail-itemqty" id="control-group">
    <label for="exampleInputPassword2" >Quantity</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Pieces">
  </div>  
  <div class="form-group detail-itemprice" id="control-group">
    <label for="exampleInputPassword2" >Unit Price</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Amount">
  </div>  
  <div class="form-group detail-itemtot" id="control-group">
    <label for="exampleInputPassword2" >Total</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Total Amount">
  </div>  
<div class="spacer" style="height:15px;"></div>
  <div  class="form-group detail-itemname">
    <label class="sr-only" for="exampleInputEmail2" >Item</label>
    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Name">
  </div>
  <div class="form-group detail-itemqty">
    <label class="sr-only" for="exampleInputPassword2" >Quantity</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Pieces">
  </div>  
  <div class="form-group detail-itemprice">
    <label class="sr-only" for="exampleInputPassword2" >Unit Price</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Amount">
  </div>  
  <div class="form-group detail-itemtot">
    <label class="sr-only" for="exampleInputPassword2" >Total</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Total Amount">
  </div>    
<div class="spacer" style="height:15px;"></div>
  <div  class="form-group detail-itemname">
    <label class="sr-only" for="exampleInputEmail2" >Item</label>
    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Name">
  </div>
  <div class="form-group detail-itemqty">
    <label class="sr-only" for="exampleInputPassword2" >Quantity</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Pieces">
  </div>  
  <div class="form-group detail-itemprice">
    <label class="sr-only" for="exampleInputPassword2" >Unit Price</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Amount">
  </div>  
  <div class="form-group detail-itemtot">
    <label class="sr-only" for="exampleInputPassword2" >Total</label>
    <input type="email" class="form-control" id="exampleInputPassword2" placeholder="Total Amount">
  </div>      
  </form>
</div>  

  <!--<div class="spacer" style="height:15px;"></div>-->

      <div class="modal-footer">
		<button type="button" class="btn btn-danger" id='addButton' >Add New Item</button>
		<button type="button" class="btn btn-danger" id='removeButton' >Remove Item</button>
	    <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<!--<script src="/twitter-bootstrap/twitter-bootstrap-v2/js/bootstrap-tooltip.js"></script>-->
<!--<script src="/twitter-bootstrap/twitter-bootstrap-v2/js/bootstrap-popover.js"></script>-->
<script src="js/bootstrap.js"></script>
<script src="js/jquery.js"></script>
<script>
$(function ()
{ $("#example").popover({placement:'right'});
});
</script>
</body>
</html>
            