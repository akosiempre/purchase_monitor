	//Scripts for New Request
	//Add New Row Function
	$(document).ready(function () {
		$("#addButton").click(function () {
			//for row limitation
			/*
			if( ($('.row-group').length + 1) > 10) {
				alert("Only 10 rows allowed");
				return false;
			}
			*/
			var id = ($('.row-group').length + 1).toString();
			$('.form-inline').append('<div class="control-group row-group" id="control-group' + id + '"> \
									<div class="spacer" style="height:15px;"></div>\
									  <div class="form-group detail-itemname">\
										<label class="sr-only" for="ItemName">Item</label>\
									  <input type="text" name="itemname[]" class="form-control"   placeholder="Name" autofocus> \
									  </div>\
	                                  <div class="form-group detail-more"">\
		                                 <a id="ItemMore' + id + '" name="dtl-notes' + id +'" href="#ItemNotes' + id + '" role="button" class="btn btn-default" data-toggle="submodal"><span class="glyphicon glyphicon-tag"></span></a>\
									  </div>\
									  <div class="form-group detail-itemqty" >\
										<label class="sr-only" for="ItemQty">Quantity</label>\
										<input type="text" name="itemqty[]" class="form-control"  placeholder="Pieces">\
									  </div>\
									  <div class="form-group detail-itemprice" >\
										<label class="sr-only" for="ItemPrice" >Unit Price</label>\
										<input type="text" name="itemprice[]" class="form-control"  placeholder="Amount">\
									  </div>  \
									  <div class="form-group detail-itemtot" >\
										<label class="sr-only" for="TotalAmt" >Total</label>\
										<input type="text" name="itemtotamt[]" class="form-control"  placeholder="Total Amount">\
										</div> \
										<div class="form-group detail-delete">\
										<button type="button" class="btn btn-sm btn-danger" id="removeButton' + id + '" onclick=\"ConfirmDelete(\'' + id + '\')\"name="removeButton" ><span class="glyphicon glyphicon-trash"></button>\
										</div>\
									  </div> \
									  <div class="modal sub-modal fade" id="ItemNotes' + id + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
										<div class="modal-dialog" style="width:430px;">\
											<div class="modal-content">\
											<div class="modal-body">\
												<div class="control-group">\
													<label class="control-label" for="itemnotes" >Notes: </label>\
													<hr class="itemnotes" />\
												<div class="controls">\
													<textarea id="dtl-notes' + id + '" name="itemnotes[]" class="form-control dtl-notes" rows="4" ></textarea>\
												</div>\
												</div>\
								</div>\
								<div class="modal-footer modal-foot-notes">\
									<button class="btn btn-primary" data-dismiss="submodal" aria-hidden="true">OK</button>\
								</div>\
								</div>\
								</div>\
							</div>');
		$('#control-group' + id).find('input[name=itemname\\[\\]]').focus();
		});
	});
	//any time the amount changes on Row Details
	$(document).ready(function() {
		autoCompute();
	});
	//autocompute for new lines
	$(document).ready(function() {
		$("#addButton").click(function () {
			autoCompute();
		});
	});	
	function autoCompute () {
		$('input[name=itemqty\\[\\]],input[name=itemprice\\[\\]]').change(function(e) {
			var total = 0;
			var $row = $(this).parent().parent();
			var qty = $row.find('input[name=itemqty\\[\\]]').val();
			var price = $row.find('input[name=itemprice\\[\\]]').val();
			total = parseFloat(qty * price);
			total = (Math.round(total * 100)/100);
			//update the row total
			$row.find('input[name=itemtotamt\\[\\]]').val(total);
			var total_amount = 0;
			$('input[name=itemtotamt\\[\\]]').each(function() {
				//Get the value
				var amt = $(this).val();
				console.log(amt);
		
				//if it's a number add it to the total
				if (IsNumeric(amt)) {
					total_amount += parseFloat(amt);
					total_amount = (Math.round(total_amount * 100)/100);
					//total_amount = (total_amount).toFixed(2);
					//total_amount = console.log(total_amount.toPrecision(4));
				}
			});
			$("div.content_holder").find('input[name=GrandTotal]').val(total_amount);	
		});		
	}

	//isNumeric function Stolen from: 
	//http://stackoverflow.com/questions/18082/validate-numbers-in-javascript-isnumeric

	function IsNumeric(input) {
		return (input - 0) == input && input.length > 0;
	}	

	//Deleting Rows Confirmation
	function ConfirmDelete(rownum) {
			var totlines = ($('.row-group').length).toString();
			var $row = $("body").find(("#control-group" + rownum));
			var $notes = $("body").find(("#ItemNotes" + rownum));
			var value = $row.find('input[name=itemname\\[\\]]').val();
			var amount = $row.find('input[name=itemtotamt\\[\\]]').val();
			if (value != "") {
				var del = confirm("Are you sure you want to remove "+ value +"?");
				if (del) {
					$row.remove();
					$notes.remove();
					updateRows(rownum,totlines,amount);	
				} else {
					return false;
				}
			} else  {
				$row.remove();
				$notes.remove();
				updateRows(rownum,totlines,amount);
			};
	};
	//Update Row ID's for proper page rendering
	function updateRows (rownum,totlines,amount) {
			var linenum = parseFloat(rownum);
			var totlines = parseFloat(totlines);	
			var amt = parseFloat(amount);
			var total_amt = $("div.content_holder").find('input[name=GrandTotal]').val();
			total_amt -= parseFloat(amt);
			total_amt = (Math.round(total_amt * 100)/100);
			$("div.content_holder").find('input[name=GrandTotal]').val(total_amt);			
			if (rownum != totlines) {
				for (var i=linenum;i<totlines;i++) {
				//old values
					var groupid = ("#control-group" + (i + 1)).toString();
					var groupclickid = ("#removeButton" + (i + 1)).toString();
					var groupnoteid = ("#ItemNotes" + (i + 1)).toString();
					var groupdtlid = ("#dtl-notes" + (i + 1)).toString();
					var groupmore = ("#ItemMore" + (i + 1)).toString();

				//new values	
					var newgroupid = ("control-group" + i ).toString();			
					var newclickid = ("removeButton" + i ).toString();
					var newonclick = ("ConfirmDelete(" + i + ")").toString();
					var newnoteid = ("ItemNotes" + i ).toString();
					var newdtlid = ("dtl-notes" + i).toString(); 
					var newmoreid = ("ItemMore" + i).toString(); 

				//update values
					$(groupid).attr('id',(newgroupid));
					$(groupclickid).attr('id',(newclickid)).attr('onclick',(newonclick));
					$(groupnoteid).attr('id',(newnoteid));
					$(groupdtlid).attr('id',(newdtlid));
					$(groupmore).attr('id',(newmoreid)).attr('href',"#" + (newnoteid)).attr('name',(newdtlid));

				}
			}				
	
	};
	//autofocus for first line item
	$("#ItemList.btn").on('click', function () {
		$(".modal").on('shown.bs.modal', function(e) {
			var ctrlid = ($('.row-group').length).toString();	
			$('#control-group' + ctrlid).find('input[name=itemname\\[\\]]').focus();
		});
	});
	$("#ItemMore1.btn").on('click', function () {
		$(".modal").on('shown.bs.modal', function() {
			$(this).find("[autofocus]:first").blur();
			$("#dtl-notes1").focus();
		});		
	});

//attachments handling	
	$(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
	});
	
	$(document).ready( function() {
		$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
			var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;
			if( input.length ) {
				input.val(log);
			} else {
			if( log ) alert(log);
			}
		});
	}); 
	
//login index
	$(function ()  {
    	$("#about").popover({
			title: 'Purchase Monitor v1.0.0',
			placement:'bottom',
			container: 'body',
			delay: {show: 500, hide: 100}
		});
	});
	$('html').on('click', function (e) {
		$('[data-toggle="popover"]').each(function () {
			//the 'is' for buttons that trigger popups
			//the 'has' for icons within a button that triggers a popup
			if (!$(this).is(e.target) 
			&&   $(this).has(e.target).length === 0 
			&&   $('.popover').has(e.target).length === 0) {
				 $(this).popover('hide');
			}
		});
	});	

	$(function ()  {
    	$("#register").popover({
			//title: 'Purchase Monitor v1.0.0',
			placement:'bottom',
			container: 'body',
			delay: {show: 500, hide: 100}
		});
	});
	
	//for search item
	$("#SearchItemButton.btn").on('click', function () {
			var item = $('input#SearchItemName').val().toString();
			var searchval = 'itemsearch.php?search=' + item;
			$('form#SearchItem').attr('action',(searchval));
		});