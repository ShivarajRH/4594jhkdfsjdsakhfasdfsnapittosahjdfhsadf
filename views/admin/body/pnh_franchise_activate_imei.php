<link rel="stylesheet" href="<?php echo base_url().'/css/buttons.css'?>" type="text/css">
<div class="page_wrap container">
	<div class="clearboth">
		<div class="fl_left" >
			<h2 class="page_title">Franchise IMEINO Activation</h2>
		</div>
	</div>
	<div class="page_content">
		<table width="100%" cellpadding="0">
			<tr>
				<td width="30%">
					<div class="form" style="background: #fafafa;margin-right:20px;padding:10px;">
						<form action="<?php echo site_url('admin/pnh_process_franchise_imei_activation');?>" id="frm_franimeiactv" method="post">
							<table cellpadding="10" cellspacing="0" border="0" style="border-collapse: collapse">
								<tr style="background: #f1f1f1">
									<td><b>MemberID or Mobileno</b> <span class="red_star">*</span></div></td>	
									<td><input type="text" maxlength="10" style="width: 200px;" value="<?php echo set_value('srch_no');?>" name="srch_no" >
										<?php echo form_error('srch_no','<span class="error_msg">','</span>');?>
									</td>
								</tr>
								<tr>
									<td width="150"><b>Member Type</b> <span class="red_star">*</span></td>	
									<td>
										<select name="mem_type">
											<?php
												$mem_type = $this->input->post('mem_type');
												if(!$mem_type)
													echo '<option value="0" '.(set_select('mem_type',0)).' >New Member</option>';			
												else
													echo '<option value="1" '.(set_select('mem_type',1)).' >Already Registered</option>';
											?>
										</select>
										<?php echo form_error('mem_type','<span class="error_msg">','</span>');?>
									</td>
								</tr>
								<tr>
									<td><b>Franchise</b> <span class="red_star">*</span> </td>
									<td>
										<select name="franid" style="width: 210px;">
											<option value="">Choose</option>
											<?php
												if($fran_list->num_rows())
												{
													foreach($fran_list->result_array() as $fran)
													{
														echo '<option '.set_select('franid',$fran['franchise_id']).' value="'.$fran['franchise_id'].'">'.$fran['franchise_name'].'</option>';
													}
												}
											?>
										</select>
										<?php
											echo form_error('franid','<span class="error_msg">','</span>');
										?>
									</td>
								</tr>
								<tr class="new_mem" >
									<td width="150"><b>MemberID</b> <span class="red_star">*</span></td>	
									<td>
										<input type="text" style="width: 200px;" maxlength="8" value="<?php echo set_value('mem_id');?>" name="mem_id" >
										<?php echo form_error('mem_id','<span class="error_msg">','</span>');?>
									</td>
								</tr>
								<tr>
									<td><b>Mobileno</b> <span class="red_star">*</span></td>	
									<td>
										<input maxlength="10" type="text" style="width: 200px;" value="<?php echo set_value('mobno');?>" name="mobno" >
										<?php echo form_error('mobno','<span class="error_msg">','</span>');?>
									</td>
								</tr>
								<tr class="new_mem">
									<td><b>Member Name</b> <span class="red_star">*</span></td>	
									<td>
										<input type="text" style="width: 200px;" value="<?php echo set_value('name');?>" name="name" >
										<?php echo form_error('name','<span class="error_msg">','</span>');?>
									</td>
								</tr>
								<tr>
									<td><b>IMEINO</b><span class="red_star">*</span>
										<p style="font-size: 10px;color: #cd0000;margin:3px;">( Max 2 IMEI Activations per Member )</p>
									</td>	
									<td>
										<ol style="padding-left: 20px;margin:0px;">
											<li>
												<input type="text" style="width: 180px;" value="<?php echo set_value('imeino_1');?>" name="imeino_1" >
												<?php echo form_error('imeino_1','<span class="error_msg">','</span>');?>	
											</li>
											<li>
												<input type="text" style="width: 180px;" value="<?php echo set_value('imeino_2');?>" name="imeino_2" >
												<?php echo form_error('imeino_2','<span class="error_msg">','</span>');?>	
											</li>
										</ol>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="left">
										<input type="submit" class="button button-flat-royal button-small button-rounded" value="Activate IMEI/Serialno" > 
									</td>
								</tr>
							</table>
						</form>
					</div>
				</td>
				<td valign="top" width="70%" align="left">
					<div class="">
						<?php
							$imei_actv_list = $this->db->query("select e.username as activated_byname,imei_activated_on,activated_by,franchise_name,imei_no,imei_reimbursement_value_perunit as imei_credit_amt from t_imei_no a join king_orders b on a.order_id = b.id join king_transactions c on c.transid = b.transid join pnh_m_franchise_info d on d.franchise_id = c.franchise_id left join king_admin e on e.id = a.activated_by where a.is_imei_activated = 1 order by imei_activated_on desc limit 10");
						?>
						<h3 style="margin:5px 0px">Latest IMEI/Serialno Activations</h3>
						<table class="datagrid" width="100%">
							<thead>
								<th width="20" style="text-align: left">Slno</th>
								<th width="130"  style="text-align: left">Activated On</th>
								<th width="70"  style="text-align: left">Activated By</th>
								<th  style="text-align: left">Franchise</th>
								<th  style="text-align: left" width="200">Imeino</th>
								<th  style="text-align: left" width="30">Credit</th>
							</thead>
							<tbody>
								<?php
									$i=0;
									foreach($imei_actv_list->result_array() as $imei_det)
									{
								?>
										<tr>
											<td><?php echo ++$i ?></td>
											<td><?php echo format_datetime($imei_det['imei_activated_on']) ?></td>
											<td><?php echo ($imei_det['activated_byname']?$imei_det['activated_byname']:'SMS') ?></td>
											<td><?php echo $imei_det['franchise_name'] ?></td>
											<td><?php echo $imei_det['imei_no'] ?></td>
											<td><?php echo $imei_det['imei_credit_amt'] ?></td>
										</tr>
								<?php				
									}
								?>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</table>
		
	</div>
</div>
<style>
	.red_star{color:#cd0000}
	.error_msg{font-size: 10px;background: rgba(205, 0, 0, 0.6);color: #FFF;padding:3px;border-radius:3px;display: inline-block;}
	.leftcont {display:none;}
</style>
<script type="text/javascript">

	$('select[name="mem_type"]').change(function(){
		if($(this).val() == "1")
		{
			$('.new_mem').hide();
		}else
		{
			$('.new_mem').show();
		}
	}).trigger('change');

	function load_franchises()
	{
		$('select[name="franid"]').html("<option value=''>Loading...</option>");
		
				$.post(site_url+'/admin/jx_getfranlist_active','',function(resp){
					var optList = '<option value="">Choose</option>';
						if(resp.status == 'success')
						{
							$.each(resp.fran_list,function(i,b){
								optList += '<option value="'+b.franchise_id+'">'+b.franchise_name+'</option>';
							});
						}
						$('select[name="franid"]').html(optList);
				},'json');
	}
	
	$('#frm_franimeiactv').submit(function(){
		var franid = $('select[name="franid"]').val()*1;
		var memid = $('input[name="mem_id"]').val();
		var imeino = $('input[name="imeino"]').val();
		var	name = $('input[name="name"]').val();
		var mobno = $('input[name="mobno"]').val();
		var error_msg = new Array();
		
			if(isNaN(franid) || franid == 0)
				error_msg.push("Please Choose Franchise");
			
			if(isNaN(memid) || memid == 0)
				error_msg.push("Please Enter MemberID");
					
			if(!imeino)
				error_msg.push("Please Enter IMEINO");
		 	if(!name)
				error_msg.push("Please Enter Member Name");
			if(!mobno)
				error_msg.push("Please Enter Mobileno");
			if(error_msg.length)
			{
				//alert(error_msg.join("\n"));
				//return false;
			}
	});
	
	$('input[name="srch_no"]').change(function(){
		$('select[name="mem_type"]').html("<option value=''>Loading...</option>");
		$('select[name="franid"]').val("");
		
		
		$('input[name="mem_id"]').val('');
		$('input[name="mobno"]').val('');
		
		var srch_no = $(this).val();
			$.post(site_url+'/admin/jx_checkmemberbyidmob',{srch:srch_no},function(resp){
				if(resp.status == 'error')
				{
					alert(resp.error);
				}else
				{
					if(resp.member_id)
						$('select[name="mem_type"]').html("<option value='1'>Already Registered</option>");
					else
						$('select[name="mem_type"]').html("<option value='0'>New Member</option>");
						
					$('select[name="mem_type"]').val((resp.member_id*1)?1:0).trigger('change');
					if(resp.member_id)
						$('input[name="mem_id"]').val(resp.member_id);
						
					if(resp.franchise_id)
						$('select[name="franid"]').val(resp.franchise_id);	
					
							
					$('input[name="mobno"]').val(resp.mob_no);
					$('input[name="mem_id"]').attr('readonly',false).css('background','#FFF');
					$('input[name="mobno"]').attr('readonly',false).css('background','#FFF');
					
					
				}
			},'json');
	});
	  
</script>
