<div class="container">

<h2>Scheme Discounts for franchises</h2>

<form id="pnh_bulkschdisc_frm" method="post">
<table cellpadding=5>
<tr><td>Menu :</td><td><select name="menu" data-placeholder="Select Menu" id="choose_menu" style="min-width: 180px;">
<option value=""></option>
<?php foreach($this->db->query("select id,name from pnh_menu where status = 1 order by name asc")->result_array() as $menu){?>
<option value="<?php echo $menu['id']?>"><?php echo $menu['name']?></option>
<?php }?>
</select></td></tr>
<!--  <tr><td>Franchises : </td><td>
<div id="id="fran_list"></div>
<div style="padding:3px;max-height:300px;overflow:auto;display:block-inline;border:1px solid #eabafa;">
<?php foreach($this->db->query("select franchise_id as id,concat(franchise_name,', ',locality,', ',city) as name from pnh_m_franchise_info where is_suspended=0 order by name asc")->result_array() as $f){?>
<!--  <div style="padding:2px;"><label style="display:block-inline;padding:3px;background:#eee;"><input class="fids" type="checkbox" name="fids[]" value="<?=$f['id']?>"><?=$f['name']?></label></div>-->
<?php }?>
<!--  </div>select:<input type="button" value="all" style="padding:0px;" onclick='$(".fids").attr("checked",true)'> <input type="button" value="none" style="padding:0px;" onclick='$(".fids").attr("checked",false)'>
</td></tr>-->

<tr><td width="100" valign="center">Franchises :</td>
<td>
<div style="float:left;padding:5px;border:1px solid #dfdfdf;min-width: 180px;">
<div id="fran_list"></div>
<?php foreach($this->db->query("select id,name from pnh_menu order by name asc")->result_array() as $menu){?>
 <!--  <div  onclick='$("input",$(this)).toggleCheck()' style="white-space:nowrap;margin-bottom:3px;margin-right:3px;float:left;padding:3px;background:#eee;cursor:pointer;"><input type="checkbox" name="fids[]" value="<?=$f['franchise_id']?>" checked> <?=$f['franchise_name']?>, <?=$f['town']?>, <?=$f['city']?>, <?=$f['territory_name']?></div>-->
<?php }?>
<div class="clear"></div>
<div style="padding-top:5px;">select : <input onclick='$("input",$(this).parent().parent()).attr("checked",true)' type="button" value="All"> <input onclick='$("input",$(this).parent().parent()).attr("checked",false)' type="button" value="None"></div>
</div>
<div class="clear"></div>
</td>
</tr>
<tr><td>Scheme Type:</td>
<td><select name="bulk_schtype" id="bulk_schtype">
<option value="1">Scheme Discount</option>
<option value="2">Super Scheme</option>
<option value="3">Member Scheme</option>
</select></td></tr>
<tr id="msch_type"><td>Credit Cash</td><td><input type="text" name="mscheme_val" class="inp" size=6> in <label><input type="radio" name="mscheme_type" value=1 checked="checked">%</label> <label><input type="radio" name="mscheme_type" value=0>Rs</label></td></tr>
<tr id="credit_value"><td>Credit Value</td><td><input type="text" name="credit_value"></td></tr>
<tr class="super_scheme"><td>Target Value</td><td><input type="text" name="target_value"></td></tr>
<tr class="super_scheme"><td>Credit Percent:</td><td><input type="text" name="credit_prc"></td></tr>
<tr><td>
<tr id="sch_disc"><Td>
Scheme Discount : </td><td>
	<input type="text" name="discount" value="1" size="4">%
</td></tr>
<tr><td>Brand :</td><td><select name="brand" style="max-width: 200px;">
<option value="0">All brands</option>
<?php foreach($this->db->query("select * from king_brands order by name asc")->result_array() as $b){?>
<option value="<?=$b['id']?>"><?=$b['name']?></option>
<?php }?>
</select>
</td></tr>
<tr><td>Category :</td><td><select name="cat" style="max-width: 200px;">
<option value="0">All categories</option>
<?php foreach($this->db->query("select * from king_categories order by name asc")->result_array() as $b){?>
<option value="<?=$b['id']?>"><?=$b['name']?></option>
<?php }?>
</select>
</td></tr>
<tr><td>
Scheme Validity </td><td> From: <input type="text" class="inp" size="10" name="start" id="d_start"> To : <input type="text" class="inp" size="10" name="end" id="d_end"></td></tr>
<tr id="msch_applyfrm"><td>Apply From</td><td><input type="text" class="inp" size="10" name="msch_applyfrm" id="m_applyfrm"></td></tr>
<tr><td>
Reason </td><td><textarea class="inp" name="reason" style="width:300px;"></textarea></td></tr>
<tr><td></td><td><input type="submit" value="Add Scheme discount"></td></tr>
</table>
</form>

</div>
<script>
$('#choose_menu').chosen();
$(function(){
	$("#d_start,#d_end").datepicker();
	$("#m_applyfrm").datepicker();
});

$('#pnh_bulkschdisc_frm').submit(function(){
	var error_inp = new Array();
	
	if(!$('select[name="menu"]',this).val())
	{
		error_inp.push("Please Choose menu ");
		
	}
	if(!$('input[name="fids[]"]:checked',this).length)
	{
		error_inp.push("Please Choose atleast one franchise");
	}
	
	
	
	var sch_disc = $('input[name="discount"]',this).val();
		$('input[name="discount"]',this).val($.trim(sch_disc));
		sch_disc = $.trim(sch_disc)*1;
		if(isNaN(sch_disc))
		{
			error_inp.push("Invalid Discount Entered");
		}else if(sch_disc > 10)
		{
			error_inp.push("Maximum 10% discount is allowed");
		}
	var is_valid_daterange = 1;	
		if(!$('#d_start',this).val().length)
			is_valid_daterange = 0;
		if(!$('#d_end',this).val().length)
			is_valid_daterange = 0;
			
		if(!is_valid_daterange)
		{
			error_inp.push("Scheme Validity is required");
		}
		
	if(error_inp.length)
	{
		alert(error_inp.join("\n"));
		return false;
	}		
	
	if(!confirm("Are you sure want to give this scheme discount"))
	{
		return false; 
	}
});

$('#choose_menu').change(function(){
	var sel_terrid=$('#chose_terry').val();
	var sel_menuid=$(this).val();
	
		$('#fran_list').html('').trigger('liszt:updated');
		$.getJSON(site_url+'/admin/get_franchisebymenu_id/'+sel_menuid+'',function(resp){
			if(resp.status=='errorr')
			{
				$('#fran_list').html(resp.message);
			}
			else
			{
				var menufranchiselist_html='';
				$.each(resp.menu_fran_list,function(i,itm){
					menufranchiselist_html+='<div style="white-space:nowrap;margin-bottom:3px;margin-right:3px;float:left;padding:3px;background:#eee;cursor:pointer;"><input type="checkbox" name="fids[]" value="'+itm.fid+'":checked >'+itm.franchise_name+'</div>';
					$('#fran_list').html(menufranchiselist_html);
				});
			}
	
			$('#fran_list').html(menufranchiselist_html).trigger('liszt:updated');
			$('#fran_list').trigger('change');
		});
});

$('#bulk_schtype').change(function(){
	var schtype=$(this).val();
	//alert($(this).val());
	if(schtype==3)
	{
		
		$('#msch_type').show();
		$('#credit_value').hide();
		$('#sch_disc').hide();
		$('#msch_applyfrm').show();
		$('.super_scheme').hide();
	}
	if(schtype==2)
	{
		$('#msch_type').hide();
		$('#sch_disc').hide();
		$('#credit_value').hide();
		$('#msch_applyfrm').hide();
		$('.super_scheme').show();
	}
	else if(schtype==1)
	{
		$('#sch_disc').show();
		$('#msch_type').hide();
		$('#credit_value').hide();
		$('#msch_applyfrm').hide();
		$('.super_scheme').hide();
	}
});

</script>
<style>
#msch_type,#credit_value,#msch_applyfrm,.super_scheme
{display: none;}
</style>
<?php
