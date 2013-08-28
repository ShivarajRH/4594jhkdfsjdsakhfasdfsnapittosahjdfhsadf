<div class="container">
<h2>Purchase Order - Productwise</h2>

<div style="margin:5px 0px;position:fixed;right:0px;bottom:40px;background:#F7EFB9;padding:15px;border:1px solid #aaa;">Highlight product of barcode : <input type="text" id="srch_barcode"></div> 


<div style="padding:5px;">
	<div id="filter_prods" style="float: right;display: none;">
		<span>Filter by </span>
		<b>Brand &nbsp;</b><select name="fil_brand"></select>
		&nbsp;
		<span style="display: none;"><b>Category </b> <select name="fil_cat"></select></span>
	</div>	
Search &amp; Add : <input type="text" class="inp" id="po_search" style="width:400px;"> <input type="button" id="load_unavail" value="Load stock unavailable products">
<div class="srch_result_pop closeonclick" id="po_prod_list"></div>

</div>

<form method="post" id="poprodfrm" autocomplete="off">

<table class="datagrid" id="pprods">
<thead>
<tr>
<th>S.No</th>
<th>Product</th>
<th>Qty</th>
<th>MRP</th>
<th>margin</th>
<th>Scheme discount</th>
<th>Discount Type</th>
<th>Purchase price</th>
<th>FOC</th>
<th>Has Offer</th>
<th>Note</th>
<th colspan=2>Vendor</th>
</tr>
</thead>
<tbody>
</tbody>
</table>


<div style="padding:20px 0px;">
	<input type="submit" value="Place Purchase Orders">
</div>



</form>

<div style="display:none">
<table id="p_clone_template">
<tr class="barcode--barcode-- barcodereset fil_%brand_id%">
<td>%sno%</td>
<td><input type="hidden" name="product[]" value="%product_id%">
<input type="hidden" class="brand" name="brand[]" value="%brand_id%">
%product_name%
<br />
<b>(%product_brand%)</b>
</td>
<td><input type="text" class="inp" size=2 name="qty[]" value="%require_qty%"></td>
<td><input type="text" class="inp calc_pp mrp" size=4 name="mrp[]" value="%mrpvalue%"></td>
<td><input type="text" class="inp calc_pp margin" size=3 name="margin[]" value="%margin%"></td>
<td><input type="text" class="inp calc_pp discount" size=3 name="sch_discount[]" value="0"></td>
<td><select class="calc_pp type" name="sch_type[]">
<option value="1">percent</option>
<option value="2">value</option>
</select></td>
<td><input type="text" class="inp pprice" readonly="readonly" size=6 name="price[]" value="%pprice%"></td>
<td><input type="checkbox" class="inp" name="%foc%" value="1"></td>
<td><input type="checkbox" class="inp" name="%offer%" value="1"></td>
<td><input type="text" class="inp" name="note[]" value=""></td>
<td><select class="vendor" name="vendor[]">%vendorlist%</select></td>
<td><a href="javascript:void(0)" onclick='$(this).parent().parent().remove();'>remove</a></td>
</tr>
</table>
</div>


</div>

<script>

$('#poprodfrm').submit(function(){

	var block_frm_submit = 0;
	var qty_pending = 0;
	var ven_pending = 0;
		$('.datagrid tbody tr',this).each(function(){
			qty = $('input[name="qty[]"]',this).val()*1;
			ven = $('select[name="vendor[]"]',this).val()*1;

			if(!qty)
				qty_pending += 1;

			if(!ven)
				ven_pending += 1;
			
			 
		});

	if(qty_pending || ven_pending){
		alert("Unable to submit request, please choose vendor or qty is missing");
		return false;
	}
		
	
});

var p_brand_list = [];
var added_po=[];
function addproduct(id,name,mrp,require)
{
	require = (typeof require === "undefined") ? "" : require;
	$("#po_prod_list").hide();
	if($.inArray(id,added_po)!=-1)
	{
		alert("Product already added to the current Order");
		return;
	}
	$.post("<?=site_url("admin/jx_productdetails")?>",{id:id},function(data){
		o=$.parseJSON(data);
		i=added_po.length;
		template=$("#p_clone_template tbody").html();
		template=template.replace(/%sno%/g,i+1);
		template=template.replace(/%require_qty%/g,require);
		template=template.replace(/%product_id%/g,o.product_id);
		template=template.replace(/%brand_id%/g,o.brand_id);
		template=template.replace(/%product_name%/g,o.product_name);
		template=template.replace(/%product_brand%/g,o.brand_name);
		template=template.replace(/--barcode--/g,o.barcode);
		template=template.replace(/%mrpvalue%/g,o.mrp);
		template=template.replace(/%margin%/g,o.margin);
		template=template.replace(/%foc%/g,"foc"+i);
		template=template.replace(/%offer%/g,"offer"+i);
		
		mrp=parseInt(o.mrp);
		pprice=mrp-(mrp*parseInt(o.margin)/100);
		template=template.replace(/%pprice%/g,pprice);
		vendors="";
		$.each(o.vendors,function(i,v){
			vendors=vendors+'<option value="'+v.vendor_id+'">'+v.vendor+'</option>';
		});
		template=template.replace(/%vendorlist/g,vendors);
		$("#pprods tbody").append(template);
		added_po.push(id);

		if(!$('select[name="fil_brand"] option#brand_'+o.brand_id).length){
			$('select[name="fil_brand"]').append('<option id="brand_'+o.brand_id+'" value="'+o.brand_id+'">'+o.brand_name+'</option>');
		}
		
		
	});
}
var search_timer=0;
var jHR=0;
$(function(){

	$("#srch_barcode").keyup(function(e){
		if(e.which==13)
		{
			$(".barcodereset").removeClass("highlightprow");
			if($(".barcode"+$(this).val()).length==0)
			{
				alert("Product not found on rising PO");
				return;
			}
			$(".barcode"+$(this).val()).addClass("highlightprow");
			$(document).scrollTop($(".barcode"+$(this).val()).offset().top);
		}
	});

	
	$("#load_unavail").click(function(){
		$(this).attr("disabled",true);
		$.post("<?=site_url("admin/jx_load_unavail_products")?>",{hash:<?=time()?>},function(data){
			os=$.parseJSON(data);
			$('#filter_prods').hide('');
			$('select[name="fil_brand"]').html('<option value="">Choose</option>');
				$.each(os,function(i,o){
					addproduct(o.product_id, "", "",o.qty-o.available);
				});

			var brand_list = [];
				$('select[name="fil_brand"] option').each(function(){
					brand_list[$(this).text().replace(' ','_')]=$(this).val();
				});
				$('select[name="fil_brand"]').html('<option value="">Choose</option>');
				$.each(brand_list,function(a,b){
					$('select[name="fil_brand"]').append('<option id="brand_'+a+'" value="'+a+'">'+b+'</option>');
				});
			
			$('#filter_prods').show();
		});
	}).attr("disabled",false);
	
	$('select[name="fil_brand"]').change(function(){
		$(this).val();
		
		if($(this).val() == '')
		{
			$('#pprods tbody tr').show();
		}else
		{
			$('#pprods tbody tr').hide();
			$('#pprods tbody tr.fil_'+$(this).val()).show();
		}
			
	});
	
	$("#po_search").keyup(function(){
		q=$(this).val();
		if(jHR!=0)
			jHR.abort();
		clearTimeout(search_timer);
		search_timer=setTimeout(function(){
		jHR=$.post("<?=site_url("admin/jx_searchproducts")?>",{q:q},function(data){
			$("#po_prod_list").html(data).show();
		});},100);
	}).focus(function(){
		if($("#po_prod_list a").length==0)
			return;
		$("#po_prod_list").show();
	}).click(function(e){
		e.stopPropagation();
	});
	$("#pprods .calc_pp").live("change",function(){
		$r=$(this).parents("tr").get(0);
		mrp=parseInt($(".mrp",$r).val());
		margin=parseInt($(".margin",$r).val());
		discount=parseInt($(".discount",$r).val());
		mmrp=mrp-(mrp*margin/100);
		if($(".type",$r).val()==1)
			mmrp=mmrp-(mrp*discount/100);
		else
			mmrp=mmrp-discount;
		if(isNaN(mmrp))
			mmrp="-";
		$(".pprice",$r).val(mmrp);
	});
	$("#pprods .vendor").live("change",function(){
		$r=$(this).parents("tr").get(0);
		$.post("<?=site_url("admin/jx_getbrandmargin")?>",{v:$(this).val(),b:$(".brand",$r).val()},function(data){
				$(".margin",$r).val(data).change();
		});
	});
});
</script>

<style>
.highlightprow{
background:#ff9900;
}
</style>


<?php
