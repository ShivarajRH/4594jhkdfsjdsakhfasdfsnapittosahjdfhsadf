<style>
.leftcont{display: none}.fran_suspendlink{
border-radius:5px;
background:#f77;
display:inline-block;
padding:3px 7px;
color:#fff;
cursor: pointer;
}
.fran_suspendlink:hover{
background:#f00;
text-decoration:none;
}
li.required{color: #cd0000;list-style: none}
</style>
<?php 
$f=$fran; 
$menus=array();
$menu_list=$this->db->query("select id,name from pnh_menu")->result_array();
foreach($menu_list as $menu_li)
{
	$menus[$menu_li['id']]=$menu_li['name'];
}

?>
<style>
	.dash_bar_right{font-size: 11px;min-width: 100px !important;text-align: center;padding:3px 6px;}
	.dash_bar_right span{display: block;font-size: 16px;}
	h4{margin:5px 0px;}
</style>

<div class="container page_wrap" style="padding-top:7px;margin-top: 10px;">
<?php
	$acc_statement = $this->erpm->get_franchise_account_stat_byid($f['franchise_id']);	
	$net_payable_amt = $acc_statement['net_payable_amt'];
	$credit_note_amt = $acc_statement['credit_note_amt'];
	$shipped_tilldate = $acc_statement['shipped_tilldate'];
	$paid_tilldate = $acc_statement['paid_tilldate'];
	$uncleared_payment = $acc_statement['uncleared_payment'];		
	$cancelled_tilldate = $acc_statement['cancelled_tilldate'];
	$ordered_tilldate = $acc_statement['ordered_tilldate'];
	$not_shipped_amount = $acc_statement['not_shipped_amount'];
	$acc_adjustments_val = $acc_statement['acc_adjustments_val'];
	
	$pending_payment = $acc_statement['pending_payment'];
	
	$fr_reg_diff = ceil((time()-$f['created_on'])/(24*60*60));
	 
	if($fr_reg_diff <= 30)
	{
		$fr_reg_level_color = '#cd0000';
		$fr_reg_level = 'Newbie';
	}
	else if($fr_reg_diff > 30 && $fr_reg_diff <= 60)
	{
		$fr_reg_level_color = 'orange';
		$fr_reg_level = 'Mid Level';
	}else if($fr_reg_diff > 60)
	{
		$fr_reg_level_color = 'green';
		$fr_reg_level = 'Experienced';
	}
	if($fran_status != 0)
	{
		$fr_status_color='red';
	}
	else
	{				
		$fr_status_color='green';
	}
?>
<div class="page_topbar_left fl_left">
	<h2 style="margin-top: 5px !important;font-size: 25px;color: red;font-weight: normal;color:purple;font-family: Helvetica !important"><?php echo $f['franchise_name']?><a style="margin-left: 10px; font-size: 12px;"href="<?php echo site_url('admin/pnh_edit_fran'.'/'.$f['franchise_id'])?>">(edit)</a></h2>	
</div>
<div class="fl_left" style="padding:15px;margin-left: 20px;	">
		Registered On: <b><?php echo format_date(date('Y-m-d H:i:s',$f['created_on']))?></b> 
		Level :
		<b style="font-size: 11px;background-color:<?php echo $fr_reg_level_color;?>;color:#fff;padding:2px 3px;border-radius:3px;">
			 <?php echo $fr_reg_level;?>
		</b>&nbsp;&nbsp;
		<?php 
		$fran_status_arr=array();
		$fran_status_arr[0]="Live";
		$fran_status_arr[1]="Permanent Suspension";
		$fran_status_arr[2]="Payment Suspension";
		$fran_status_arr[3]="Temporary Suspension";
		?>
		Status:<b style="font-size: 11px;background-color:<?php echo $fr_status_color?>;color:#fff;padding:2px 3px;border-radius:3px;">
			<?php echo $fran_status_arr[$fran_status];?>
				</b>
</div>
<?php if($is_prepaid){?>
<span style="background-color: #BF0A99;color:white;height:25px;width:123px;display:block;text-align:center;float:left;white-space:nowrap;margin-left:60px;"><?php echo "<b>Prepaid Franchise</b>"?></span>
<?php }?>
<div class="page_topbar_right fl_right">
			
<a style="white-space:nowrap" href="<?=site_url("admin/pnh_sms_log/{$f['franchise_id']}")?>" class="myButton_pnhfranpg">SMS Log</a> 

<a style="white-space:nowrap" href="<?=site_url("admin/pnh_quotes/{$f['franchise_id']}")?>" class="myButton_pnhfranpg" >Franchise Requests</a>
<?php if($f['is_suspended']==0){?> 
<a style="padding:5px 10px;"  class="fran_suspendlink" onclick="reson_forsuspenfran(<?=$f['franchise_id']?>)">Suspend Account</a>
<?php }else{?>

<a style="padding:5px 10px;"  class="fran_suspendlink" onclick="reson_forunsuspension(<?=$f['franchise_id']?>)">Unsuspend Account</a>
<?php }?>
</div>

<div style="margin-bottom: 0px;clear: both;overflow: hidden">
	
<div class="dash_bar_right" style="background: tomato">
Pending Payment : <span>Rs <?=formatInIndianStyle($shipped_tilldate-($paid_tilldate+$acc_adjustments_val+$credit_note_amt),2)?></span>
</div>
<div class="dash_bar_right">
UnCleared Payments : <span>Rs <?=formatInIndianStyle($uncleared_payment,2)?></span>
</div>

<div class="dash_bar_right">
	Adjustments : <span>Rs <?=formatInIndianStyle($acc_adjustments_val,2)?></span>
</div>

<div class="dash_bar_right">
Paid till Date : <span>Rs <?=formatInIndianStyle($paid_tilldate,2)?></span>
</div>

<div class="dash_bar_right">
Credit Notes Raised : <span>Rs <?=formatInIndianStyle($credit_note_amt,2)?></span>
</div>
<div class="dash_bar_right">
Bounced/Cancelled : <span>Rs <?=formatInIndianStyle($cancelled_tilldate,2)?></span>
</div>
<div class="dash_bar_right">
Unshipped : <span>Rs <?=formatInIndianStyle($not_shipped_amount,2)?></span>
</div>
<div class="dash_bar_right">
Shipped : <span>Rs <?=formatInIndianStyle($shipped_tilldate,2)?></span>
</div>
<div class="dash_bar_right">
Ordered : <span>Rs <?=formatInIndianStyle($ordered_tilldate,2)?></span>
</div>

<div class="dash_bar_right">
Credit Limit : <span>Rs <?=formatInIndianStyle($f['credit_limit'])?></span>
</div>
</div>
<div style="clear: both">&nbsp;</div>

<div class="container_div" style="margin-top: 0px;">


<div class="tab_view">
	<ul class="fran_tabs">
	<li><a href="#name">Basic Details</a></li>
	<?php if($this->erpm->auth(PNH_EXECUTIVE_ROLE,true)){?>
	<li><a href="#actions">Credits and MIDs</a></li>
	<?php }?>
	<li><a href="#statement">Account Statement &amp; Topup</a></li>
	<li><a href="#orders" >Orders</a></li>
	<li><a href="#return_products" onclick="load_all_return_prods(0)" >Returns</a></li>
	<li><a href="#credit_notes" onclick="load_credit_notes(0)" >Invoice Credit Notes</a></li>
	<?php if($is_prepaid){?>
	<li>
		<a href="#voucher_activity" onclick="load_voucher_activity(0)">Voucher</a>
	
	</li>
	<?php }?>
	<?php if($is_membrsch_applicable){?>
	<li><a href="#shipped_imeimobslno" onclick="load_allshipped_imei(0)">IMEINO Activations</a></li>
	<?php }?>
	<li><a href="#status_log">Status Log</a></li>
	</ul>
	
	<div id="credit_notes">
		<div class="module_cont">
			<h3 class="module_cont_title">Credit Notes Raised</h3>
			<div class="module_cont_block">
				
				<div class="module_cont_block_grid_total fl_left">
					<span class="stat total">Total : <b>10</b></span> 
					
				</div>
				<div class="module_cont_block_filters fl_right">
					&nbsp;
				</div>
				
				<div class="module_cont_block_grid">
					<table class="datagrid" width="100%">
						<thead>
							<th width="20">#</th>
							<th width="30">CreditNote ID</th>
							<th width="30">Invoice no</th>
							<th width="30">Order no</th>
							<th width="30">Amount (Rs)</th>
							<th width="100">Created On</th>
						</thead>
						<tbody></tbody>
					</table>	
				</div>
				<div class="module_cont_grid_block_pagi">
					
				</div>
			</div>
		</div>	
	</div>
	<!-- franchise status log START -->
			<div id="status_log">
				<div class="tab_view">
					<ul class="fran_tabs">
						  <li><a href="#permant_suspn">Permanent Suspension</a></li>
						<li><a href="#payment_suspn">Payment Suspension</a></li>
						<li><a href="#temp_suspn">Temporary Suspension</a></li>
						<li><a href="#live_suspn">Unsuspended Log</a></li>
					</ul>
					<?php $log_res=$this->db->query("SELECT l.*,a.name FROM franchise_suspension_log l JOIN king_admin a ON a.id=suspended_by WHERE franchise_id=? AND suspension_type IN(0,1,2,3)",$f['franchise_id'])?>
					
					<?php if($log_res->num_rows()){?>
					
					<div id="permant_suspn">
					
					<table class="datagrid">
					<thead><th>Suspended Type</th><th>Reason</th><th>Suspended On</th><th>Suspended By</th></thead>
					<?php 
					foreach($log_res->result_array() as $l){
					if( $l['suspension_type']==1){?>
					<tr>
					<td><?php echo $fran_status_arr[$l['suspension_type']]?></td>
					<td><?php echo $l['reason']?></td>
					<td><?php echo format_datetime_ts($l['suspended_on'])?></td>
					<td><?php echo $l['name']?></td>
					</tr>
					<?php }?>
					
					<?php } ?>
					
					
					</table>
					</div>
					
					<div id="payment_suspn">
					<table class="datagrid">
					<thead><th>Suspended Type</th><th>Reason</th><th>Suspended On</th><th>Suspended By</th></thead>
					<?php 
					foreach($log_res->result_array() as $l){
					if( $l['suspension_type']==2){?>
					<tr>
					<td><?php echo $fran_status_arr[$l['suspension_type']]?></td>
					<td><?php echo $l['reason']?></td>
					<td><?php echo format_datetime_ts($l['suspended_on'])?></td>
					<td><?php echo $l['name']?></td>
					<?php } ?>
					</tr>
					<?php }?>
					</table>
					</div>
					
					<div id="live_suspn">
					<table class="datagrid">
					<thead><th>Reason</th><th>Unsuspended On</th><th>Suspended By</th></thead>
					<?php 
					foreach($log_res->result_array() as $l){
					if( $l['suspension_type']==0){?>
					<tr>
					<td><?php echo $l['reason']?></td>
					<td><?php echo format_datetime_ts($l['suspended_on'])?></td>
					<td><?php echo $l['name']?></td>
					<?php } ?>
					</tr>
					<?php }?>
					</table>
					</div>
					
					<div id="temp_suspn">
					<table class="datagrid">
					<thead><th>Suspended Type</th><th>Reason</th><th>Suspended On</th><th>Suspended By</th></thead>
					<?php 
					foreach($log_res->result_array() as $l){
					if( $l['suspension_type']==3){?>
					<tr>
					<td><?php echo $fran_status_arr[$l['suspension_type']]?></td>
					<td><?php echo $l['reason']?></td>
					<td><?php echo format_datetime_ts($l['suspended_on'])?></td>
					<td><?php echo $l['name']?></td>
					<?php }?>
					</tr>
					<?php }?>
					</table>
					</div>
					<?php }?>
				</div>
				
			</div>
	<!-- franchise status log END -->
	
	<!-- List Franchise Returns Start -->
	<div id="return_products">
		
		<div class="module_cont">
			<h3 class="module_cont_title">Return List</h3>
			<div class="module_cont_block">
				
				<div class="module_cont_block_grid_total fl_left">
					<span class="stat total">Total : <b>10</b></span> 
					
				</div>
				<div class="module_cont_block_filters fl_right">
					<span class="filter_bydate">
						Filter by Date : 
						<input type="text" name="return_on_date" style="font-size: 12px;padding:3px 7px;width: 80px;" value="" placeholder="" >
						to 
						<input type="text" name="return_on_date_end" style="font-size: 12px;padding:3px 7px;width: 80px;" value="" placeholder="" >
					</span>
					<span class="filter_bykwd" style="margin-left:10px;">
						Search : <input type="text" name="return_kwd_srch" style="font-size: 12px;padding:3px 7px;width: 200px;" value="" placeholder="" >
						<input type="button" onclick="load_return_prods(0)" value="Search" />
					</span>
				</div>
				
				
				<div class="module_cont_block_grid">
					<table class="datagrid" width="100%">
						<thead>
							<th width="20">Sno</th>
							<th width="30">Return ID</th>
							<th width="150">Returned On</th>
							<th width="80">Returned By</th>
							<th width="30">Invoice no</th>
							<th width="30">Order no</th>
							<th width="200">Product name</th>
							<th width="30">Qty</th>
							<th width="100">Returned For</th>
							<th width="100">Current Status</th>
							<th width="100">Last Updated On</th>
							<th width="100">Last Updated By</th>
							<th width="100">Remarks</th>
						</thead>
						<tbody></tbody>
					</table>	
				</div>
				<div class="module_cont_grid_block_pagi">
					
				</div>	
			</div>
		</div>
		
	</div>	
	<!-- List Franchise Returns End -->
	<?php  if($is_prepaid){?>
	<!-- prepaid voucher activity Start -->
	<div id="voucher_activity">
				<b>Voucher Activity</b>
				<div class="dash_bar_right" style="padding: 12px 6px;">
					<b>Voucher Book Value:<?php echo 'Rs'.formatInIndianStyle($this->db->query("SELECT SUM(`value`) AS ttl_value FROM `pnh_t_voucher_details` WHERE franchise_id=? AND `status`>=2 AND is_alloted=1",$f['franchise_id'])->row()->ttl_value)?></b>
				</div>

				<div class="dash_bar_right" style="padding: 12px 6px;">
					<b>Activated Voucher Value:<?php echo 'Rs'.formatInIndianStyle($this->db->query("SELECT SUM(`value`) AS ttl_value FROM `pnh_t_voucher_details` WHERE franchise_id=? AND `status`>=3 AND is_alloted=1 and is_activated=1",$f['franchise_id'])->row()->ttl_value)?></b>
				</div>

				<div class="dash_bar_right" style="padding: 12px 6px;">
					<b>Not Activated Voucher Value:<?php echo 'Rs'.formatInIndianStyle($this->db->query("SELECT SUM(`value`) AS ttl_value FROM `pnh_t_voucher_details` WHERE franchise_id=? AND `status`=2 AND is_alloted=1 and is_activated=0",$f['franchise_id'])->row()->ttl_value)?></b>
				</div>
				<br> <br>

				<div class="tab_view">
					<ul class="fran_tabs">
					<li><a href="#inactivated_vouchers" onclick="load_voucher_activity(this,'inactivated_vouchers',0,0)">Inactive
								Vouchers</a></li>
								
						<li><a href="#activated_vouchers"
							onclick="load_voucher_activity(this,'activated_vouchers',0,0)">Activated
						</a></li>
						<li><a href="#fully_redeemed_vouchers"
							onclick="load_voucher_activity(this,'fully_redeemed_vouchers',0,0)">Fully
								Redeemed</a></li>
						<li><a href="#partially_redeemed_vouchers"
							onclick="load_voucher_activity(this,'partially_redeemed_vouchers',0,0)">Partially
								Redeemed</a></li>
					</ul>
					
					<div id="inactivated_vouchers">
						<h3>Inactive Vouchers</h3>
						<div class="tab_content"></div>
					</div>
					
					<div id="activated_vouchers">
						<h3>Activated Voucher</h3>
						<div class="tab_content"></div>
					</div>

					<div id="fully_redeemed_vouchers">
						<h3>Fully Redeemed Voucher</h3>
						<div class="tab_content"></div>
					</div>

					<div id="partially_redeemed_vouchers">
						<h3>Partially Redeemed Voucher</h3>
						<div class="tab_content"></div>
					</div>
				</div>
				<!-- End of tab -->
			</div><!-- Activity div blk end -->
<?php }?>
	<!-- prepaid voucher activity End -->
	
	<!-- IMEI slno log Start-->
	<?php if($is_membrsch_applicable){?>
	
			<div id="shipped_imeimobslno">
			<?php 	
				//$ttl_purchased=$this->db->query("SELECT sum(quantity) AS ttl FROM king_orders o JOIN king_transactions t ON t.transid=o.transid WHERE  o.imei_scheme_id > 0 and t.franchise_id=?",$f['franchise_id'])->row()->ttl;	
				//$ttl_activated_msch=$this->db->QUERY("SELECT COUNT(DISTINCT i.id) AS active_msch  FROM king_orders o  JOIN king_transactions t ON t.transid=o.transid  JOIN t_imei_no i ON i.order_id=o.id WHERE member_scheme_processed=1 AND o.imei_scheme_id > 0 AND t.franchise_id=? ",$f['franchise_id'])->ROW()->active_msch;
				//$ttl_inactiv_msch=$this->db->QUERY("SELECT COUNT(DISTINCT i.id) AS inactive_msch  FROM king_orders o  JOIN king_transactions t ON t.transid=o.transid  JOIN t_imei_no i ON i.order_id=o.id WHERE   member_scheme_processed=0 AND o.imei_scheme_id > 0 AND t.franchise_id=?",$f['franchise_id'])->ROW()->inactive_msch;
				
				$ttl_purchased=$this->db->query("SELECT COUNT(DISTINCT i.id) AS ttl FROM king_orders o JOIN king_transactions t ON t.transid=o.transid JOIN t_imei_no i ON i.order_id=o.id WHERE o.imei_scheme_id > 0 and t.franchise_id=?",$f['franchise_id'])->row()->ttl;
				$ttl_activated_msch=$this->db->QUERY("SELECT COUNT(DISTINCT i.id) AS active_msch FROM king_orders o JOIN king_transactions t ON t.transid=o.transid JOIN t_imei_no i ON i.order_id=o.id WHERE is_imei_activated=1 AND o.imei_scheme_id > 0 AND t.franchise_id=? ",$f['franchise_id'])->ROW()->active_msch;
				$ttl_inactiv_msch=$this->db->QUERY("SELECT COUNT(DISTINCT i.id) AS inactive_msch FROM king_orders o JOIN king_transactions t ON t.transid=o.transid JOIN t_imei_no i ON i.order_id=o.id WHERE is_imei_activated=0 AND o.imei_scheme_id > 0 AND t.franchise_id=?",$f['franchise_id'])->ROW()->inactive_msch;
				
				
		 		
				
				$ttl_imei_activation_credit=$this->db->QUERY("select sum(imei_reimbursement_value_perunit) as imei_credit  
																from king_orders a 
																join t_imei_no b on a.id = b.order_id 
																join king_transactions c on c.transid = a.transid
																where is_imei_activated = 1 and franchise_id = ? ",$f['franchise_id'])->ROW()->imei_credit;  
			?>
				<b>Total Purchased:<?php echo $ttl_purchased ;?></b>&nbsp;&nbsp;&nbsp;
				<b>Total Active: <?php echo $ttl_activated_msch?></b>&nbsp;&nbsp;&nbsp;
				<b>Total Inactive: <?php echo $ttl_inactiv_msch?></b>
				<b style="float: right;">Total Credit On activation:<?php echo 'Rs'.formatInIndianStyle($ttl_imei_activation_credit)?></b>
				<div class="tab_view">
					<br>
					<div class="tab_content"></div>
				</div>
			</div>
			<?php }?>
	<!-- IMEI slno log END-->
		<div id="name">
	 
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
				
					<td valign="top" width="35%" >
						<div class="emp_bio">
							
							<div class="vm">
							<table cellspacing="5"  id="details">
							<tr><td class="label">FID </td><td><b><?=$f['pnh_franchise_id']?></b></td></tr>
						<?php if($f['is_lc_store']){?><tr><td>Type </td><td><b><?=$f['is_lc_store']?"LC Store":"Franchise"?> </b></td></tr><?php }?>
							<?php if($f['login_mobile1']){?>
							<tr><td class="label">Mobile </td>
							<td><?=$f['login_mobile1']?><img src="<?=IMAGES_URL?>phone.png" class="phone_small" onclick='makeacall("0<?=$f['login_mobile1']?>")'>,<?php }?>
										<?php if($f['login_mobile2']){?>
								<?=$f['login_mobile2']?><img src="<?=IMAGES_URL?>phone.png" class="phone_small" onclick='makeacall("0<?=$f['login_mobile2']?>")'>
										<?php }?></td>
							</tr>
							<?php foreach($this->db->query("select * from pnh_m_franchise_contacts_info where franchise_id=?",$f['franchise_id'])->result_array() as $c){?>
							<?php if($c['contact_name']){?><tr><td class="label">Contact Person </td><td><b><?=$c['contact_name']?> </b></td></tr><?php }?>
							<?php if($c['contact_designation']){?><tr><td class="label">Designation </td><td><b><?=$c['contact_designation']?> </b></td></tr><?php }?>
							<?php if($c['contact_telephone']){?><tr><td class="label">Telephone </td><td><b><?=$c['contact_telephone']?>,<?=$c['contact_fax']?></b></td></tr><?php }?>
							<?php }?>
							<?php if($f['address']){?><tr><td class="label">Address</td><td><b><?=$f['address']?></b></td></tr><?php }?>
							<?php if($f['store_area']){?><tr><td class="label">Area</td><td><b><?=$f['store_area']?>sqft</b></td></tr><?php }?>
							
							<?php
								$f['town_name'] = $this->db->query("select town_name from pnh_towns a join pnh_m_franchise_info b on a.id = b.town_id where franchise_id = ? ",$f['franchise_id'])->row()->town_name; 
							?>
							<tr><td class="label">Town  | Territory</td><td><b><?=$f['town_name']?> | </b><b><?=$f['territory_name']?></b></td></tr>
							
							<?php if($f['lat']){?><tr><td class="label">Latitude</td><td><b><?=$f['lat']?></b></td></tr><?php }?>
							<?php if($f['long']){?><tr><td class="label">Longitude</td><td><b><?=$f['long']?></b></td></tr><?php }?>
							</table>
							</div>
							
							<div>
									<fieldset>
										<legend><b>Allotted Member IDs</b></legend>
										<table class="datagrid" width="100%">
											<thead>
												<tr>
													<th>Start</th>
													<th>End</th>
													<th>Allotted on</th>
													<th>Allotted by</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($this->db->query("select m.*,a.name as admin from pnh_m_allotted_mid m join king_admin a on a.id=m.created_by where franchise_id=?",$f['franchise_id'])->result_array() as $m){?>
												<tr>
													<td><?=$m['mid_start']?></td>
													<td><?=$m['mid_end']?></td>
													<td><?=date("d/m/y",$m['created_on'])?></td>
													<td><?=$m['admin']?></td>
													<?php }?>
											
											</tbody>
										</table>
									</fieldset>
							</div>	
							
						</div>
					</td>
					
					<td  valign="top">
						
						<div id="fran_misc_logs" style="font-size: 12px;" >
							<ul>
								<li><a href="#recent_call_log">Recent Call Log</a></li>
								<li><a href="#account_statement_summ">Recent Account statement</a></li>		
							</ul>	
							
				 
					<div id="recent_call_log">
							
							<table class="datagrid smallheader noprint" width="100%">
								<thead>
									<tr>
										
										<tH width="100">Call Made on</tH>
										<th width="100">By</th>
										<th width="200">Msg</th>
								</thead>
								<tbody>
									<?php foreach($this->db->query("select l.*,a.name,l.created_on from pnh_call_log l join king_admin a on a.id=l.created_by where franchise_id=? order by l.created_on desc limit 10",$fran['franchise_id'])->result_array() as $l){?>
									<tr>
										<td><?=format_datetime_ts($l['created_on'])?></td>
										<td><?=$l['name']?></td>
										<td>
											<?=$l['msg']?>
											<a href="javascript:void(0)"
											style="font-size: 85%;"
											onclick='$("form",$(this).parent()).toggle()'>add msg</a>
											<form method="post" style="display: none;"
												action="<?=site_url("admin/pnh_update_call_log/{$l['id']}")?>">
												<textarea name="msg">
											<?=$l['msg']?>
										</textarea>
												<input type="submit" value="add">
											</form>
										</td>
										
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
				
				<div id="account_statement_summ">
						
					<?php	
						if($this->erpm->auth(true,true)){
							$action_type_list = array(); 
							$action_type_list[1] = 'Invoice';
							$action_type_list[2] = 'Deposit';
							$action_type_list[3] = 'Topup';
							$action_type_list[4] = 'Membership';
							$action_type_list[5] = 'Correction';
							$action_type_list[7] = 'Credit Note';
					?>
						
							<table class="datagrid noprint" width="100%">
								<thead>
									<tr>
										<th>Type</th>
										<th>Date</th>
										<th>Credit</th>
										<th>Debit</th>
										<th>Remarks</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($this->db->query("select * from pnh_franchise_account_summary where franchise_id = ? order by statement_id desc limit 7 ",$f['franchise_id'])->result_array() as $t){?>
									<tr>
										<td><?=$action_type_list[$t['action_type']]?></td>
										<td><?=format_datetime($t['created_on'])?></td>
										<td><?=$t['credit_amt']?></td>
										<td><?=$t['debit_amt']?></td>
										<td width="200"><?=$t['remarks']?></td>
									</tr>
									<?php }?>
								</tbody>
							</table>
							<?php } ?>
							
						
							<div style="background: #eee; padding: 5px;">
								<form id="d_ac_form"
									action="<?=site_url("admin/pnh_download_stat/{$f['franchise_id']}")?>"
									method="post">
									<h4 style="margin: 0px;">Download account statement</h4>
									from <input type="text" name="from" id="d_ac_from" size=10> To
									<input size=10 type="text" name="to" id="d_ac_to"> 
									<select name="type">
										<option value="new">New</option>
										<option value="old">Old</option>
									</select>
									<input
										type="submit" value="Go">
								</form>
							</div>
						</div>
						
					</div>	
				 
				</td>
					 
			</tr>
			</table>
			 
			<br>
			<fieldset >
			<legend><b>Activity</b></legend>
			<table width="100%">
			<tr>
				<td width="100%">
					<a style="white-space:nowrap" href="<?=site_url("admin/pnh_manage_devices/{$f['franchise_id']}")?>" class="myButton_pnhfranpg">Manage devices</a> &nbsp;&nbsp;
					<a style="white-space:nowrap" href="<?=site_url("admin/pnh_assign_exec/{$f['franchise_id']}")?>" class="myButton_pnhfranpg">Assign Executives</a> &nbsp;&nbsp; 
					<a style="white-space:nowrap" href="<?=site_url("admin/pnh_upload_images/{$f['franchise_id']}")?>" class="myButton_pnhfranpg">Upload Images</a> &nbsp;&nbsp; 
				 	<a  onclick="members_details()" href="javascript:void(0)" class="myButton_pnhfranpg">Members</a>&nbsp;&nbsp; 
					<a onclick="load_bankdetails()" href="javascript:void(0)" class="myButton_pnhfranpg">Bank Details</a>&nbsp;&nbsp;
					
				</td>
			</tr>
			</table>
			</fieldset>
			
			<br>
			<fieldset>
			<legend><b>Alloted Menu</b>
				
				<a style="font-size: 11px;color: blue;" href="<?php echo site_url("admin/pnh_edit_fran/{$f['franchise_id']}#v_shop")?>" style="float: right;margin-left: 12px;">Add/Edit</a>
				
			</legend>
			
			<?php
				if($fran_menu)
				{ 
			?>
					<ol start="1">
						<?php foreach($fran_menu as $fmenu){?>
							<li><?php echo $fmenu['menu'] ?></li>
						<?php }?>
					</ol>
			<?php 
				}else
				{
					echo '<b>No menus linked</b>';
				}
				 ?>
			</fieldset>
			<br>
			
			<br>
			<table width="100%">
				<tr>
					<td>
					<div id="members" Title="Members Details">
						<div>
							<div class="dash_bar">
								Total Members : <span><?=$this->db->query("select count(1) as l from pnh_member_info where franchise_id=?",$f['franchise_id'])->row()->l?>
								</span>
							</div>
							<div class="dash_bar">
								Last month registered : <span><?=$this->db->query("select count(1) as l from pnh_member_info where franchise_id=? and created_on between ".mktime(0,0,0,-1,1)." and ".mktime(23,59,59,-1,31),$f['franchise_id'])->row()->l?>
								</span>
							</div>
							<div class="dash_bar">
								This month registered : <span><?=$this->db->query("select count(1) as l from pnh_member_info where franchise_id=? and created_on >".mktime(0,0,0,date("m"),1),$f['franchise_id'])->row()->l?>
								</span>
							</div>
						</div>

						<table class="datagrid" width="100%">
							<thead>
								<tr>
									<th>Member ID</th>
									<th>Name</th>
									<th>City</th>
									<th>Created On</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($this->db->query("select * from pnh_member_info where franchise_id=?",$f['franchise_id'])->result_array() as $m){?>
								<tr>
									<td><a
										href="<?=site_url("admin/pnh_viewmember/{$m['user_id']}")?>"
										class="link"><?=$m['pnh_member_id']?> </a></td>
									<td><?=$m['first_name']?> <?=$m['last_name']?></td>
									<td><?=$m['city']?></td>
									<td><?=$m['created_on']==0?"registration form not updated yet":date("g:ia d/m/y",$m['created_on'])?>
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
					</td>
				</tr>
				<tr>
				<td>
				<br>
				<fieldset >
				<legend><b>Scheme Discount</b></legend>
					<div>
						<a onclick="give_sch_discnt_frm()" href="javascript:void(0)" class="myButton_pnhfranpg">Give Scheme Discount</a>&nbsp;&nbsp;&nbsp;
						<a onclick = "give_supersch()" href="javascript:void(0)" class="myButton_pnhfranpg">Give Super Scheme</a>&nbsp;&nbsp;&nbsp;
						<?php if($is_membrsch_applicable ){?>
										<a onclick="give_membrsch()" href="javascript:void(0)"
											class="myButton_pnhfranpg">Give IMEI/Serialno Scheme</a>&nbsp;&nbsp;&nbsp;
										<?php }?>
						<a onclick="load_scheme_disc_history()" href="javascript:void(0)" class="myButton_pnhfranpg" style="float:right">Scheme Discount History</a>&nbsp;&nbsp;&nbsp;
						<h4 style="margin-bottom: 0px;">Active scheme discounts for brands &amp; categories</h4>
						
						
							<div class="tab_view tab_view_inner">
								<ol>
									<li><a href="#sch_disc">Scheme Discount</a></li>
									<li><a href="#super_sch">Super Scheme</a></li>
									<?php if($is_membrsch_applicable){?>								
									<li><a href="#membr_sch">IMEI/Serialno Scheme</a></li>
										<?php }?>
								</ol>
								<div id="sch_disc">
									<div class="tab_view">
										<ol>
											<li><a href="#sch_disc_active">Active</a></li>
											<li><a href="#super_sch_active">Expired</a></li>
										</ol>
										<div id="sch_disc_active" class="tab_view_inner">
											<table class="datagrid" width="100%">
											<thead>
												<tr>
													<th>Menu</th>
													<th>Brand</th>
													<th>Category</th>
													<th>Discount</th>
													<th>Valid from</th>
													<TH>Valid upto</TH>
													<th>Added on</th>
													<th>Added by</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($this->db->query("select s.*,a.name as admin,b.name as brand,c.name as category,s.menuid,i.name AS menu from pnh_sch_discount_brands s left outer join king_brands b on b.id=s.brandid left outer join king_categories c on c.id=s.catid join king_admin a on a.id=s.created_by JOIN `pnh_franchise_menu_link` m ON m.fid=s.franchise_id JOIN pnh_menu i ON i.id=s.menuid where s.franchise_id=? and ? between s.valid_from and s.valid_to and sch_type=1 GROUP BY s.id order by id desc ",array($fran['franchise_id'],time()))->result_array() as $s){
														if(!$s['is_sch_enabled'])
															continue;
												?>
												<?php// foreach($this->db->query("select h.*,a.name as admin,m.name AS menu  from pnh_sch_discount_track h left outer join king_admin a on a.id=h.created_by LEFT JOIN pnh_menu m ON m.id=h.sch_menu where franchise_id=? and ? between valid_from and valid_to and sch_type=1 order by h.id desc",array($fran['franchise_id'],time()))->result_array()  as $s){?>
												<tr>
													<td><?=$s['menu']?></td>
													<td><?=empty($s['brand'])?"All brands":$s['brand']?></td>
													<td><?=empty($s['category'])?"All categories":$s['category']?>
													</td>
													<td><?=$s['discount']?>%</td>
													<td><?=date("d/m/Y",$s['valid_from'])?></td>
													<td><?=date("d/m/Y",$s['valid_to'])?></td>
													<td><?=date("d/m/Y",$s['created_on'])?></td>
													<td><?=$s['admin']?></td>
													<td><?php if($s['is_sch_enabled']==1){?><a href="<?=site_url("admin/pnh_expire_scheme_discount/{$s['id']}")?>" class="danger_link">expire</a><?php }else{?><?php echo "<b>Expired</b>" ;}?></td>
												</tr>
												<?php }?>
											</tbody>
											</table>
										</div>
										<div id="super_sch_active" class="tab_view_inner">
											<table class="datagrid" width="100%">
											<thead>
												<tr>
													<th>Menu</th>
													<th>Brand</th>
													<th>Category</th>
													<th>Discount</th>
													<th>Valid from</th>
													<TH>Valid upto</TH>
													<th>Added on</th>
													<th>Added by</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($this->db->query("select s.*,a.name as admin,b.name as brand,c.name as category,s.menuid,i.name AS menu from pnh_sch_discount_brands s left outer join king_brands b on b.id=s.brandid left outer join king_categories c on c.id=s.catid join king_admin a on a.id=s.created_by JOIN `pnh_franchise_menu_link` m ON m.fid=s.franchise_id JOIN pnh_menu i ON i.id=s.menuid where s.franchise_id=? and ? between s.valid_from and s.valid_to  GROUP BY s.id order by id desc ",array($fran['franchise_id'],time()))->result_array() as $s){
														if($s['is_sch_enabled'])
															continue;
												?>
												<?php// foreach($this->db->query("select h.*,a.name as admin,m.name AS menu  from pnh_sch_discount_track h left outer join king_admin a on a.id=h.created_by LEFT JOIN pnh_menu m ON m.id=h.sch_menu where franchise_id=? and ? between valid_from and valid_to and sch_type=1 order by h.id desc",array($fran['franchise_id'],time()))->result_array()  as $s){?>
												<tr>
													<td><?=$s['menu']?></td>
													<td><?=empty($s['brand'])?"All brands":$s['brand']?></td>
													<td><?=empty($s['category'])?"All categories":$s['category']?>
													</td>
													<td><?=$s['discount']?>%</td>
													<td><?=date("d/m/Y",$s['valid_from'])?></td>
													<td><?=date("d/m/Y",$s['valid_to'])?></td>
													<td><?=date("d/m/Y",$s['created_on'])?></td>
													<td><?=$s['admin']?></td>
													<td><?php if($s['is_sch_enabled']==1){?><a href="<?=site_url("admin/pnh_expire_scheme_discount/{$s['id']}")?>" class="danger_link">expire</a><?php }else{?><?php echo "<b>Expired</b>" ;}?></td>
												</tr>
												<?php }?>
											</tbody>
											</table>
										</div>
									</div>
								</div>
								<div id="super_sch">
									<div class="tab_view">
										<ol>
											<li><a href="#super_sch_active">Active</a></li>
											<li><a href="#super_sch_expired">Expired</a></li>
										</ol>
										<div id="super_sch_active" class="tab_view_inner">
											<?php $t=$this->db->query("SELECT s.*,a.name AS admin,b.name AS brand,c.name AS category,s.menu_id,i.name AS menuname FROM pnh_super_scheme s  LEFT OUTER JOIN king_brands b ON b.id=s.brand_id LEFT OUTER JOIN king_categories c ON c.id=s.cat_id JOIN king_admin a ON a.id=s.created_by  JOIN `pnh_franchise_menu_link` m ON m.fid=s.franchise_id  JOIN pnh_menu i ON i.id=s.menu_id WHERE s.franchise_id=? AND ? between s.valid_from and s.valid_to AND is_active=1 GROUP BY s.id ORDER BY id DESC ",array($fran['franchise_id'],time()));
											
											if($t->num_rows()){
											$super_sch=	$t->result_array();
											?>
											<table class="datagrid">
												<thead><tr><th>Menu</th><th>Brand</th><th>Category</th><th>Target Sales</th><th>Credit</th><th>Valid From</th><th>Valid To</th><th>Added On</th><th>Added By</th><th></th></tr></thead>
												<tbody>
													<?php foreach($super_sch as $super_sh){
															if(!$super_sh['is_active'])
																continue;
													?>
													<tr>
													<td><?php echo $super_sh['menuname']?></td>
													<td><?=empty($super_sh['brand'])?"All brands":$super_sh['brand']?></td>
													<td><?=empty($super_sh['category'])?"All categories":$super_sh['category']?></td>
													<td><?php echo $super_sh['target_value'];?></td>
													<td><?php echo $super_sh['credit_prc'];?>%</td>
													<td><?=date("d/m/Y",$super_sh['valid_from'])?></td>
													<td><?=date("d/m/Y",$super_sh['valid_to'])?></td>
													<td><?=date("d/m/Y",$super_sh['created_on'])?></td>
													<td><?=$super_sh['admin']?></td>
													<td><?php if($super_sh['is_active']==1){?><a href="<?=site_url("admin/pnh_expire_superscheme/{$super_sh['id']}")?>" class="danger_link">expire</a><?php }else{?><?php echo "<b>Expired</b>"; }?></td>
													</tr>
												<?php }?>
												</tbody>
											</table>
											<?php }?>
										</div>
										<div id="super_sch_expired" class="tab_view_inner">
											<?php $t=$this->db->query("SELECT s.*,a.name AS admin,b.name AS brand,c.name AS category,s.menu_id,i.name AS menuname FROM pnh_super_scheme s  LEFT OUTER JOIN king_brands b ON b.id=s.brand_id LEFT OUTER JOIN king_categories c ON c.id=s.cat_id JOIN king_admin a ON a.id=s.modified_by  JOIN `pnh_franchise_menu_link` m ON m.fid=s.franchise_id  JOIN pnh_menu i ON i.id=s.menu_id WHERE s.franchise_id=?  AND is_active=0 GROUP BY s.id ORDER BY id DESC limit 10",$fran['franchise_id']);
											if($t->num_rows()){
											$super_sch=	$t->result_array();
											?>
											<table class="datagrid">
												<thead><tr><th>Menu</th><th>Brand</th><th>Category</th><th>Target Sales</th><th>Credit</th><th>Valid From</th><th>Valid To</th><th>Modified On</th><th>Modified By</th><th>Status</th></tr></thead>
												<tbody>
													<?php foreach($super_sch as $super_sh){
														if($super_sh['is_active'])
															continue;
													?>
													<tr>
													<td><?php echo $super_sh['menuname']?></td>
													<td><?=empty($super_sh['brand'])?"All brands":$super_sh['brand']?></td>
													<td><?=empty($super_sh['category'])?"All categories":$super_sh['category']?></td>
													<td><?php echo $super_sh['target_value'];?></td>
													<td><?php echo $super_sh['credit_prc'];?>%</td>
													<td><?=date("d/m/Y",$super_sh['valid_from'])?></td>
													<td><?=date("d/m/Y",$super_sh['valid_to'])?></td>
													<td><?=date("d/m/Y",$super_sh['created_on'])?></td>
													<td><?=$super_sh['admin']?></td>
													<td><?php if($super_sh['is_active']==1){?><a href="<?=site_url("admin/pnh_expire_superscheme/{$super_sh['id']}")?>" class="danger_link">expire</a><?php }else{?><?php echo "<b>Expired</b>"; }?></td>
													</tr>
												<?php }?>
												</tbody>
											</table>
											<?php }?>
								
										</div>
									</div>	
								</div>
								<?php if($is_membrsch_applicable){?>
								<div id="membr_sch">
												<div class="tab_view">
													<ol>
														<li><a href="#membr_sch_active">Active</a></li>
														<li><a href="#membr_sch_expired">Expired</a></li>
													</ol>
													<div id="membr_sch_active" class="tab_view_inner">
														<?php $m=$this->db->query("SELECT a.*,m.name AS menu,c.name AS cat_name,b.name AS brand_name,ad.name AS admin,a.id as sch_id,a.is_active as sch_active FROM imei_m_scheme a JOIN pnh_menu m ON m.id=a.menuid LEFT JOIN king_categories c ON c.id=a.categoryid LEFT JOIN king_brands b ON b.id=a.brandid JOIN king_admin ad ON ad.id=a.created_by WHERE a.is_active=1 and franchise_id=?",$fran['franchise_id']);?>
														<?php if($m->num_rows()){ 
																$membr_sch=	$m->result_array();
														?>
														<table class="datagrid">
															<thead>
																<tr>
																	<th>Menu</th>
																	<th>Brand</th>
																	<th>Category</th>
																	<th>Scheme Type</th>
																	<th>Credit Value</th>
																	<th>Valid from</th>
																	<TH>Valid upto</TH>
																	<th>Applicable from</th>
																	<th>Added on</th>
																	<th>Added by</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<?php 
																		$mbr_schtypes=array("Fixed Fee","Percentage");
																		foreach($membr_sch as $membr_sh){
																	?>
																	<td><?php echo $membr_sh['menu']?></td>
																	<td><?php echo $membr_sh['brand_name']?$membr_sh['brand_name']:"All brands"?></td>
																	<td><?php echo($membr_sh['cat_name'])?$membr_sh['cat_name']:"All categories"?>
																	</td>
																	<td><?php  echo $mbr_schtypes[$membr_sh['scheme_type']]?>
																	</td>
																	<td><?php echo $membr_sh['credit_value']?></td>
																	<td><?php echo date("d/m/Y",$membr_sh['scheme_from'])?></td>
																	<td><?php echo date("d/m/Y",$membr_sh['scheme_to'])?>
																	</td>

																	<td><?php echo date("d/m/Y",$membr_sh['sch_apply_from'])?>
																	</td>
																	<td><?php echo date("d/m/Y",$membr_sh['created_on'])?>
																	</td>
																	<td><?php echo $membr_sh['admin']?></td>
																	<td><?php if($membr_sh['is_active']==1){?><a
																		href="<?=site_url("admin/pnh_expire_membrscheme/{$membr_sh['sch_id']}")?>"
																		class="danger_link">expire</a> <?php }else{?> <?php echo "<b>Expired</b>"; }?>
																	</td>

																</tr>
																<?php }?>
															</tbody>
														</table>
														<?php }?>
													</div>

													<div id="membr_sch_expired" class="tab_view_inner">
														<?php $m=$this->db->query("SELECT a.*,m.name AS menu,c.name AS cat_name,b.name AS brand_name,ad.name AS admin,a.is_active as sch_active FROM imei_m_scheme a JOIN pnh_menu m ON m.id=a.menuid LEFT JOIN king_categories c ON c.id=a.categoryid LEFT JOIN king_brands b ON b.id=a.brandid JOIN king_admin ad ON ad.id=a.modified_by WHERE a.is_active=0 and franchise_id=?",$fran['franchise_id']);?>
														<?php if($m->num_rows()){
																$membr_sch=	$m->result_array();
														?>
														<table class="datagrid">
															<thead>
																<tr>
																	<th>Menu</th>
																	<th>Brand</th>
																	<th>Category</th>
																	<th>Scheme Type</th>
																	<th>Credit Value</th>
																	<th>Valid from</th>
																	<TH>Valid upto</TH>
																	<th>Applicable from</th>
																	<th>Modified on</th>
																	<th>Modified by</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<?php foreach($membr_sch as $membr_sh){
																		if($membr_sh['sch_active'])
																			continue;
													?>
																	<td><?php echo $membr_sh['menu']?></td>
																	<td><?php echo $membr_sh['brand_name']?$membr_sh['brand_name']:"All brands"?></td>
																	<td><?php echo($membr_sh['cat_name'])?$membr_sh['cat_name']:"All categories"?>
																	
																	<td><?php $mbr_schtypes=array("Fixed Fee","Percentage"); echo $mbr_schtypes[$membr_sh['scheme_type']]?>
																	</td>
																	<td><?php echo $membr_sh['credit_value']?></td>
																	<td><?php echo date("d/m/Y",$membr_sh['scheme_from'])?>
																	</td>
																	<td><?php echo date("d/m/Y",$membr_sh['scheme_to'])?></td>
																	<td><?php echo date("d/m/Y",$membr_sh['sch_apply_from'])?>
																	</td>
																	<td><?php echo date("d/m/Y",$membr_sh['modified_on'])?>
																	</td>
																	<td><?php echo $membr_sh['admin']?></td>
																	<td><?php if($membr_sh['sch_active']==1){?><a
																		href="<?=site_url("admin/pnh_expire_membrscheme/{$membr_sh['id']}")?>"
																		class="danger_link">expire</a> <?php }else{?> <?php echo "<b>Expired</b>"; }?>
																	</td>

																</tr>
																<?php }?>
															</tbody>
														</table>
														<?php }?>
													</div>
												</div>
											</div>
											<?php }?>
						</div>
					</div>
					
				</fieldset>
				</td>
				</tr>
				</table>
				</fieldset>
				<br>
				<fieldset>
				<legend><b>Device Information</b></legend>
				<table width="100%">
				 
				<tr>
				<td width="20%">
						<?php 
							$app_v = '';
							$app_v_res = $this->db->query("select version_no from pnh_app_versions where id=? ",$f['app_version']);
							if($app_v_res->num_rows())
								$app_v=$app_v_res->row()->version_no;
							?>
							<p>
								<h4 style="margin: 0px; font-size: 15px;">
									<b>App Version : </b><span><?=$app_v?></span>
								</h4>
							</p>
							
							
							<form action="<?=site_url("admin/pnh_change_app_version")?>">
								<input type="hidden" name="fid" value="<?=$f['franchise_id']?>">
							<p>	Change to New Version : <select id="fran_ver_change">
									<option value="0">select</option>
									<?php foreach($this->db->query("select version_no,id from pnh_app_versions where id>?",$f['app_version'])->result_array() as $v){?>
									<option value="<?=$v['id']?>">
										<?=$v['version_no']?>
									</option>
									<?php }?>
								</select></p>
							</form>
					</td>	

				</tr>
				
			</table>
			 
		</div>
				<!-- End of name block -->
				<?php if($this->erpm->auth(FINANCE_ROLE,true)){?>
			<div id="statement">
					<div style="float: left; margin-top: 33px; margin-left: 20px; background: #eee; padding: 5px; width: 500px;">
					<h4 style="background: #C97033; color: #fff; padding: 5px; margin: -5px -5px 5px -5px;">Make a Topup/Security Deposit</h4>
						<form method="post" id="top_form" action="<?=site_url("admin/pnh_topup/{$fran['franchise_id']}")?>">
							<table cellpadding=3>
								<tr>
									<td>Type</td><td>:</td>
									<td><select name="r_type" id="r_type"><option value="1">Topup</option>
											<option value="0">Security Deposit</option>
									</select></td>
								</tr>
								<tr>
									<td>Amount</td><td>:</td>
									<td>Rs <input type="text" class="inp amount" name="amount"
										size=5>
									</td>
								</tr>
								<tr>
									<td>Instrument Type</td><td> :</td>
									<td><select name="type" class="inst_type">
											<option value="0">Cash</option>
											<option value="1">Cheque</option>
											<option value="2">DD</option>
											<option value="3">Transfer</option>
									</select></td>
								</tr>
								<tr>
									<td>Instrument Status</td><td> :</td>
									<td><select name="transit_type">
											<option value="0">In Hand</option>
											<option value="1">Via Courier</option>
											<option value="2">With Executive</option>
									</select></td>
								</tr>
								<tr class="inst inst_name">
									<td class="label">Bank name </td><td>:</td>
									<td><input type="text" name="bank" size=30></td>
								</tr>
								<tr class="inst inst_no">
									<td class="label">Instrument No</td><td> :</td>
									<td><input type="text" name="no" size=10></td>
								</tr>
								<tr class="inst inst_date">
									<td class="label">Instrument Date</td><td> :</td>
									<td><input type="text" name="date" id="sec_date" size=15></td>
								</tr>
								<tr class="inst_msg">
									<td>Message</td><td> :</td>
									<td><input type="Text" class="inp msg" name="msg" size=30></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" value="Add Topup"></td>
								</tr>
							</table>
						</form>
					</div>


					<div
						style="float: left; margin-top: 33px; margin-left: 20px; background: #eee; padding: 5px; width: 580px;">
						<h4
							style="background: #C97033; color: #fff; padding: 5px; margin: -5px -5px 5px -5px;">Account
							Statement Correction</h4>
						<form method="post" id="acc_change_form"
							action="<?=site_url("admin/pnh_acc_stat_c/{$fran['franchise_id']}")?>">
							<table cellpadding=3>
								<tr>
									<td>Type</td><td>:</td>
									<td><select name="type"><option value="0">In (credit)</option>
											<option value="1">Out (debit)</option>
									</select></td>
								</tr>
								<tr>
									<td>Amount</td><td>:</td>
									<td>Rs <input type="text" name="amount" class="inp" size=5>
									</td>
								</tr>
								<tr>
									<td>Description</td><td>:</td>
									<td><input type="text" name="desc" class="inp" size=30></td>
								</tr>
								<tr>
								<td>Send SMS to Franchise</td><td>:</td>
									<td><label><input type="checkbox" name="sms" value="1"></label></td>
									
								</tr>
								<tr>
									<td></td>
									<td><input type="submit" value="Make correction" ></td>
								</tr>
							</table>
						</form>
					</div>
				<?php }?>
					<div class="clear"></div></br></br>

					<div class="tab_view">
					
					
						<h4 style="margin-bottom: 0px">
							Receipts <a href="<?=site_url("admin/pnh_pending_receipts")?>"
								style="font-size: 75%">activate/cancel</a>
						</h4>
						
						
						<ul>
							<li><a href="#pending">Pending</a></li>
							<li><a href="#processed">Processed</a></li>
							<li><a href="#realized">Realized</a></li>
							<li><a href="#cancelled">Cancelled/Bounced</a></li>
							<li><a href="#acct_stat">Account Correction</a></li>
						</ul>
						<div id="pending">
							<b style="font-size: 85%">Total Receipts:<?php echo count($pending_receipts);?>&nbsp;&nbsp;Total value:Rs <?php echo formatInIndianStyle($pending_ttlvalue['total'])?></b>
							<table class="datagrid smallheader" width="100%">
								<thead>
									<tr>
										<th>Receipt Details</th>
										<th>Amount Details</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($pending_receipts as $pr){?>
									<tr>
										<td>
											<div id="receipt_det">
											<table class="datagrid1" >
												<tr>
													<td><b>Receipt Id</b></td><td><b>:</b></td>
													<td><?php echo $pr['receipt_id'];?></td>
												</tr>
												<tr>
													<td><b>created on</b></td>
													<td><b>:</b></td>
													<td><?php echo date("g:ia d/m/y",$pr['created_on'])?></td>
												</tr>
												<tr>
													<td><b>created by</b></td>
													<td><b>:</b></td>
													<td><b><?=$pr['admin']?></b></td>
												</tr>
											</table>
										</div>
									</td>
										
										<td>
											<div id="cash_det">
											<table class="datagrid1" width="100%">
											<tr><td><b><?php $modes=array("cash","Cheque","DD","Transfer");?><b>Payment Mode</b></td><td><b>:</b></td><td><?=$modes[$pr['payment_mode']]?> <b>Rs <?=$pr['receipt_amount']?> </b> </td></tr>
											<tr><td><b>Type</b></td><td><b>:</b></td><td> <?=$pr['receipt_type']==0?"Deposit":"Topup"?></td></tr>
											<?php if($pr['payment_mode']>=0){?>
											<?php if($pr['bank_name']){?><tr><td><b>Bank</b></td><td><b>:</b></td><td><?=$pr['bank_name']?></td></tr><?php }?>
											<?php if($pr['payment_mode']>0){?><tr><td><b>Cheque no/DD no</b></td><td><b>:</b></td><td><?=$pr['instrument_no']?></td></tr><?php }?>
											<tr><td><?php $transit_types=array("In Hand","Via Courier","With Executive");?><b>Transit Type</b></td><td><b>:</b></td><td><?=$transit_types[$pr['in_transit']]?></td>
											<?php }?>
											<?php if($pr['in_transit']!=0){?>
											<td><a class="transit_link" href="javascript:void(0)" onclick="change_status(<?=$pr['receipt_id']?>)">Change to In Hand</a></td>
											<?php }?>
											</tr>
											<?php if($pr['modified_on']){?>
											<tr><td><b>Transit Status Modified By</b></td><td><b>:</b></td><td><?php echo $pr['modifiedby']?></td></tr>
											<tr><td><b>Transit Status Modified On</b></td><td><b>:</b></td><td><?php echo date("g:ia d/m/Y",$pr['modified_on'])?></td></tr>
											<?php }?>
											<tr><td><b>Payment Date</b></td><td><b>:</b></td><td><?=$pr['instrument_date']!=0?date("d/m/y",$pr['instrument_date']):""?></td></tr>
											<tr><td><b>Remarks</b></td><td><b>:</b></td><td><?=$pr['remarks']?></td></tr>
											</table>
											</div>
										</td>
										<td><b><?php if($pr['status']==1) echo 'Activated'; else if($pr['status']==0) echo 'Pending'; else if($r['status']==3) echo 'Reversed'; else echo 'Cancelled';?></b>
											<?php if($pr['status']==1 && $pr['receipt_type']==1){?> <br> <br> 
											<a class="danger_link"
											href="<?=site_url("admin/pnh_reverse_receipt/{$pr['receipt_id']}")?>">reverse</a>
											<?php }?>
										</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
						
						<div id="processed">
							<b style="font-size: 85%">Total Receipts:<?php echo count($processed_receipts);?>&nbsp;&nbsp;Total value:Rs <?php echo formatInIndianStyle($processed_ttlvalue['total'])?></b>
							<table class="datagrid smallheader"  width="100%">
								<thead>
									<tr>
										<th>Receipt Details</th>
										<Th>Payment Details</Th>
										<th>Status</th>
										<th>Processed Details</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($processed_receipts as $pro_r){?>
									<tr>
										<td>
										<div id="receipt_det">
										<table class="datagrid1">
											<tr><td><b>Receipt Id</b></td><td><b>:</b></td><td><?php echo $pro_r['receipt_id'];?></td></tr> 
											<tr><td><b>created on</b></td><td><b>:</b></td><td><?php echo date("g:ia d/m/y",$pro_r['created_on'])?></td></tr> 
											<tr><td><b>created by</b></td><td><b>:</b></td><td> <b><?=$pro_r['admin']?></b></td></tr> 
											</table>
										</div>
										</td>
										
										<td>
										<div id="cash_det" width="50%">
											<table class="datagrid1" width="100%" cellspacing="3">
												<tr>
													<td><b><?php $modes=array("cash","Cheque","DD","Transfer");?>AmountType</b></td><td><b>:</b></td>
													<td><?=$modes[$pro_r['payment_mode']]?>&nbsp;&nbsp;<b>Rs <?=$pro_r['receipt_amount']?></b></td>
												</tr>
												<tr>
													<td><b>Type</b></td><td><b>:</b></td>
													<td><?=$pro_r['receipt_type']==0?"Deposit":"Topup"?></td>
												</tr>
												<tr>
													<?php if($pro_r['bank_name']){?>
													<td><b>Bank</b></td><td><b>:</b></td>
													<td><?=$pro_r['bank_name']?></td>
													<?php }?>
												</tr>
												<?php if($pro_r['payment_mode']!=0){?>
												<tr>
													<td><b>Cheque no</b></td><td><b>:</b></td>
													<td><?=$pro_r['instrument_no']?></td>
												</tr>
												<?php }?>
												<tr>
													<td><b>Payment Date</b></td><td><b>:</b></td>
													<td><?=$pro_r['instrument_date']!=0?date("d/m/y",$pro_r['instrument_date']):""?></td>
												</tr>
												<tr>
													<td><b>Remarks</b></td><td><b>:</b></td>
													<td><?=$pro_r['remarks']?></td>
												</tr>
											</table>
										</div>
									</td>
										<td><b><?php if($pro_r['status']==1) echo 'Activated'; else if($pro_r['status']==0) echo 'Pending'; else if($pro_r['status']==3) echo 'Reversed'; else echo 'Cancelled';?>
											<?php if($pro_r['status']==1 && $pro_r['receipt_type']==1){?> <br> <br> 
											<a class="danger_link"
											href="<?=site_url("admin/pnh_reverse_receipt/{$pro_r['receipt_id']}")?>">reverse</a>
											<?php }?>
										</b></td>
										<td>
										<div id="process_det">
											<table class="datagrid1" width="100%" cellspacing="3">
												<tr>
													<td><b>Processed On</b></td><td><b>:</b></td>
													<td><?php echo format_date($pro_r['submitted_on'])?></td>
												</tr>
												<tr>
													<td><b>Processed By</b></td><td><b>:</b></td>
													<td><?php echo $pro_r['submittedby']?></td>
												</tr>
												<tr>
													<td><b>Processed Bank</b></td><td><b>:</b></td>
													<td><?php echo $pro_r['submit_bankname']?></td>
												</tr>
												<tr>
													<td><b>Remarks</b></td><td><b>:</b></td><td><?php echo $pro_r['submittedremarks']?></td>
												</tr>
											</table>
										</div>
									</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
						<div id="realized">
							<b style="font-size: 85%">Total Receipts:<?php echo count($realized_receipts);?>&nbsp;&nbsp;Total value:Rs <?php echo formatInIndianStyle($realized_ttlvalue['total'])?></b>
							 <table class="datagrid smallheader"  width="100%" >
								<thead>
									<tr>
										<th>Receipt Details</th>
										<Th>Amount Details</Th>
										<th>Status</th>
										<th>Realized Details</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($realized_receipts as $r){?>
									<tr>
										<td>
										<div id="receipt_det">
											<table class="datagrid1" >
												<tr><td><b>Receipt Id</b></td><td><b>:</b></td><td><?php echo $r['receipt_id']?></td></tr>
												<tr><td><b>created on</b></td><td><b>:</b></td><td><?php echo date("g:ia d/m/y",$r['created_on'])?></td></tr>
												<tr><td><b>Created by</b></td><td><b>:</b></td><td><b><?=$r['admin']?></b></td></tr>
											</table>
										</div>
										</td>
										<td >
										<div id="cash_det">
										<table class="datagrid1">
											<tr><td><b><?php $modes=array("cash","Cheque","DD","Transfer");?>Payment Mode</b></td><td><b>:</b></td><td><?=$modes[$r['payment_mode']]?>&nbsp;&nbsp;<b>Rs <?=$r['receipt_amount']?></b></td></tr>
											<tr><td><b>Type</b></td><td><b>:</b></td><td><?=$r['receipt_type']==0?"Deposit":"Topup"?></td></tr>
											<?php if($r['payment_mode']!=0){?>
											<tr><td><b>Cheque no</b></td><td><b>:</b></td><td><?=$r['instrument_no']?></td></tr>
											<?php }?>
											<?php if($r['bank_name']){?><tr><td><b>Bank</b></td><td><b>:</b></td><td><?=$r['bank_name']?></td></tr><?php }?>
											<tr><td><b>Payment Date</b></td><td><b>:</b></td><td><?=$r['instrument_date']!=0?date("d/m/Y",$r['instrument_date']):""?></td></tr>
											<tr><td><b>Remarks</b></td><td><b>:</b></td><td><?=$r['remarks']?></td></tr>
										</table>
										</div>
										</td>
										<td><b><?php if($r['status']==1) echo 'Activated'; else if($r['status']==0) echo 'Pending'; else if($r['status']==3) echo 'Reversed'; else echo 'Cancelled';?></b>
											<?php if($r['status']==1 && $r['receipt_type']==1){?> <br> <br> 
											<a class="danger_link"
											href="<?=site_url("admin/pnh_reverse_receipt/{$r['receipt_id']}")?>">reverse</a>
											<?php }?>
										</td>
										<td>
										<div id="realize_det">
										<table class="datagrid1">
										<tr><td><b>Realized On</b></td><td><b>:</b></td><td><?=format_date_ts($r['activated_on'])?></td></tr>
										<tr><td><b>Realized By</b></td><td><b>:</b></td><td><?=$r['activated_by']?></td></tr>
										<tr><td><b>Remarks</b></td><td><b>:</b></td><td><?=$r['reason']?></td></tr>
										</table>
										</div>
										</td>
									</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
						
							<div id="cancelled">
							<b style="font-size: 85%">Total Receipts:<?php echo count($cancelled_receipts);?>&nbsp;&nbsp;Total value:Rs <?php echo formatInIndianStyle($cancelled_ttlvalue['total'])?></b>
							 <table class="datagrid smallheader" width="100%" >
								<thead>
									<tr>
										<th>Receipt Details</th>
										<Th>Payment Details</Th>
										<th>Status</th>
										<th>Cancelled Details</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($cancelled_receipts as $cancel){?>
								<tr>
									<td>
										<div id="receipt_det">
											<table class="datagrid1" >
													<tr>
														<td><b>Receipt Id</b></td>
														<td><b>:</b></td>
														<td><?php echo $cancel['receipt_id']?>
														</td>
													</tr>
													<tr>
														<td><b>created on</b></td>
														<td><b>:</b></td>
														<td><?php echo date("g:ia d/m/y",$cancel['created_on'])?>
														</td>
													</tr>

													<tr>
														<td><b>created by</b></td>
														<td><b>:</b></td>
														<td><b><?=$cancel['admin']?> </b>
														</td>
													</tr>
											</table>
										</div>
									</td>
									<td>
										<div id="cash_det">
											<table class="datagrid1" >
												<tr>
													<td><?php $modes=array("cash","Cheque","DD","Transfer");?><b>Payment 
															Mode</b></td>
													<td><b>:</b></td>
													<td><?=$modes[$cancel['payment_mode']]?>&nbsp;&nbsp;<b>Rs <?=$cancel['receipt_amount']?>
													</b></td>
												</tr>
												<tr>
													<td><b>Type</b></td>
													<td><b>:</b></td>
													<td><?=$cancel['receipt_type']==0?"Deposit":"Topup"?></td>
												</tr>
												<tr>
													<td><b>Bank</b></td>
													<td><b>:</b></td>
													<td><?=$cancel['bank_name']?></td>
												</tr>
												<tr>
													<td><b>Cheque Date</b></td>
													<td><b>:</b></td>
													<td><?=$cancel['instrument_date']!=0?date("d/m/Y",$cancel['instrument_date']):""?>
													</td>
												</tr>
												<tr>
													<td><b>Cheque no</b></td>
													<td><b>:</b></td>
													<td><?=$cancel['instrument_no']?></td>
												</tr>
												<tr>
													<td><b>Remarks</b></td>
													<td><b>:</b></td>
													<td><?=$cancel['remarks']?></td>
												</tr>
											</table>
								</div>
								</td>
										<td><b><?php if($cancel['status']==1) echo 'Activated'; else if($cancel['status']==0) echo 'Pending'; else if($cancel['status']==3) echo 'Reversed'; else echo 'Cancelled';?></b>
											<?php if($cancel['status']==1 && $cancel['receipt_type']==1){?> <br> <br> 
											<a class="danger_link"
											href="<?=site_url("admin/pnh_reverse_receipt/{$cancel['receipt_id']}")?>">reverse</a>
											<?php }?>
										</td>
										<td>
										<div id="cancel_det">
											<table class="datagrid1">
												<tr>
													<td><b>Cancelled On</b>
													</td>
													<td><b>:</b>
													</td>
													<td><?=$cancel['cancelled_on']?format_datetime($cancel['cancelled_on']):format_datetime_ts($cancel['activated_on'])?>
													</td>
												</tr>
												<tr>
													<td><b>Cancelled By</b>
													</td>
													<td><b>:</b>
													</td>
													<td><?php echo $cancel['activated_by']?>
													</td>
												</tr>
												<tr>
													<td><b>Remarks</b>
													</td>
													<td><b>:</b>
													</td>
													<td><?=$cancel['cancel_reason']?$cancel['cancel_reason']:$cancel['reason']?>
													</td>
												</tr>
											</table>
										</div>
									</td>
									</tr>
									<?php }?>
								</tbody>
							</table> 
						</div>
						<div id="acct_stat">
						<b>Account Statement Correction Log</b>
						<?php 
							if($account_stat)
							{
						?>	
						<table class="datagrid">
						<thead><th>Description</th><th>Credit (Rs)</th><th>Debit (Rs)</th><th>Corrected On</th></thead>
						<tbody>
						<?php foreach($account_stat as $ac_st){
						?>
						<tr>
							<td><?php echo $ac_st['remarks']?></td>
							<td><?php echo $ac_st['credit_amt']?></td>
							<td><?php echo $ac_st['debit_amt']?></td>
							<td><?php echo format_datetime($ac_st['created_on'])?></td>
						</tr>
						<?php }?>
						</tbody>
						</table>
						<?php 
							}else
							{
								echo 'No Data found';
							}
						?>	
						</div>
					</div>
					<div class="clear"></div>
				</div>
				<?php if($this->erpm->auth(PNH_EXECUTIVE_ROLE|CALLCENTER_ROLE,true)){?>
				<div id="actions">
				<table width="100%">
				<tr>
				<td>
					<div>
					<fieldset>
						<legend><b>Allotted Member IDs</b></legend>
						<table class="datagrid" width="100%">
							<thead>
								<tr>
									<th>Start</th>
									<th>End</th>
									<th>Allotted on</th>
									<th>Allotted by</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($this->db->query("select m.*,a.name as admin from pnh_m_allotted_mid m join king_admin a on a.id=m.created_by where franchise_id=?",$f['franchise_id'])->result_array() as $m){?>
								<tr>
									<td><?=$m['mid_start']?></td>
									<td><?=$m['mid_end']?></td>
									<td><?=date("d/m/y",$m['created_on'])?></td>
									<td><?=$m['admin']?></td>
									<?php }?>
							
							</tbody>
						</table>
						<?php if($this->erpm->auth(PNH_EXECUTIVE_ROLE,true)){?>
						<h4 style="margin-bottom: 0px;">Allot Member IDs</h4>
						<form
							action="<?=site_url("admin/pnh_allot_mid/{$f['franchise_id']}")?>"
							id="allot_mid_form" method="post">
							From <input type="text" name="start" class="inp" size=7
								maxlength="8"> to <input maxlength="8" type="text" name="end"
								class="inp" size=7> <input type="submit" value="Allot">
						</form>
						<?php } ?>
						</fieldset>
					</div>
					</td>
				</tr>
				<tr></tr>
				<tr>
					<td>
						<div>
						<fieldset>
							<legend><b>Give Credit</b></legend>
							<form method="post" class="credit_form"
								action="<?=site_url("admin/pnh_give_credit")?>">
								<input type="hidden" name="reason" class="c_reason"> <input
									type="hidden" name="fid" value="<?=$f['franchise_id']?>">
								Enhance credit limit : Rs
								<?=$f['credit_limit']?>
								+ <input type="text" class="inp" size=4 name="limit"> <input
									type="submit" value="Add Credit">
							</form>
							<table class="datagrid" width="100%">
								<thead>
									<tr>
										<th>Credit Added</th>
										<th>New credit limit</th>
										<th>Reason</th>
										<th>Added by</th>
										<th>Added On</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($this->db->query("select c.*,a.name as admin from pnh_t_credit_info c join king_admin a on a.id=c.credit_given_by where franchise_id=? order by id desc",$f['franchise_id'])->result_array() as $c){?>
									<tr>
										<td><?=$c['credit_added']?></td>
										<td><?=$c['new_credit_limit']?></td>
										<td><?=$c['reason']?></td>
										<td><?=$c['admin']?></td>
										<td><?=date("g:ia d/m/y",$c['created_on'])?></td>
									</tr>
									<?php }?>
								</tbody>
							</table>
							<form method="post" class="credit_form"
								action="<?=site_url("admin/pnh_give_credit")?>">
								<input type="hidden" name="reason" class="c_reason"> <input
									type="hidden" name="reduce" value="1"> <input type="hidden"
									name="fid" value="<?=$f['franchise_id']?>"> Reduce credit limit
								: Rs
								<?=$f['credit_limit']?>
								- <input type="text" class="inp" size=4 name="limit"> <input
									type="submit" value="Reduce Credit">
							</form>
							</fieldset>
						</div>
						<p>
						<div id="sch_hist" title=" Give Scheme Discount" style="overflow: hidden">
								<form id="sch_form" method="post" action="<?=site_url("admin/pnh_give_sch_discount/{$f['franchise_id']}")?>" data-validate="parsley">
									
										<table cellspacing="10">
										
											<tr>
												<Td>Scheme Discount</td><td>:</td>
												<td>
													<input type="text" name="discount" value="1" size="5" data-required="true">%
												</td>
											</tr>
										<tr>
											<td>Menu </td><td>:</td>
											<td><select name="menu" class="schmenu" data-placeholder="Select Menu" style="width:250px;" data-required="true">
											<option value="0"></option>
											<?php foreach($this->db->query("SELECT distinct a.menuid as id,b.name FROM `pnh_franchise_menu_link`a JOIN pnh_menu b ON b.id=a.menuid WHERE a.status=1 and fid=? group by id order by b.name asc",$f['franchise_id'])->result_array() as $menu){?>
											<option value="<?php echo $menu['id']?>"><?php echo $menu['name']?></option>
											<?php }?>
											</select></td>

										</tr>
										
											<tr>
												<td>Category </td><td>:</td>
												<td><select name="cat" class="select_cat"  data-placeholder="Select Category" style="width:250px;" data-required="true"></select>
												</select>
												</td>
											</tr>
											
											<tr>
												<td>Brand </td><td>:</td>
												<td><select name="brand"  class="select_brand"  data-placeholder="Select Brand" style="width:250px;" data-required="true"></select>
												</td>
											</tr>
											<tr>
												<td>From</td><td>:</td>
												<td><input type="text" class="inp" size="10" name="start" id="d_start" data-required="true">
												 to <input type="text" class="inp" size="10" name="end" id="d_end" data-required="true"></td>
													
											</tr>
											<tr>
												<td valign="top">Reason</td><td valign="top">:</td>
												<td><textarea class="inp" name="reason" style="width: 300px;height: 100px;" data-required="true" ></textarea>
														
												</td>
											</tr>
											</div>
										</table>
								</form>
						</div>
						</p>
						
						<p>
						<div id="pnh_superschme" title=" Give Super Scheme" style="overflow: hidden">
								<form id="super_schform" method="post" action="<?=site_url("admin/pnh_give_super_sch/{$f['franchise_id']}")?>" data-validate="parsley">
									
										<table cellspacing="10">
											<tr>
												<Td>Cash Back</td><td>:</td>
												<td><select name="credit" data-required="true">
														<?php for($i=1;$i<=4;$i++){?>
														<option value="<?=$i?>"><?=$i?>%</option>
														<?php }?>
													</select>
												</td>
											</tr>
											<tr><td>Total Sales Value</td><td>:</td><td><input type="text" name="ttl_sales_value" data-required="true"></td></tr>
										<tr>
											<td>Menu </td><td>:</td>
											<td><select name="super_schmenu" class="schmenu" data-placeholder="Select Menu" style="width:250px;" data-required="true">
											<option value="0"></option>
											<?php foreach($this->db->query("SELECT distinct a.menuid as id,b.name FROM `pnh_franchise_menu_link`a JOIN pnh_menu b ON b.id=a.menuid WHERE a.status=1 and fid=? group by id order by b.name asc",$f['franchise_id'])->result_array() as $menu){?>
											<option value="<?php echo $menu['id']?>"><?php echo $menu['name']?></option>
											<?php }?>
											</select></td>

										</tr>
										
											<tr>
												<td>Category </td><td>:</td>
												<td><select name="cat" class="select_cat"  data-placeholder="Select Category" style="width:250px;" data-required="true" ></select>
												</select>
												</td>
											</tr>
											
											<tr>
												<td>Brand </td><td>:</td>
												<td><select name="brand"  class="select_brand"  data-placeholder="Select Brand" style="width:250px;" data-required="true" ></select>
												</td>
											</tr>
											<!--  <tr>
												<td>From</td><td>:</td>
												<td><input type="text" class="inp" size="10" name="super_schstart" id="supersch_start" data-required="true">
												 to <input type="text" class="inp" size="10" name="super_schend" id="supersch_end" data-required="true"></td>
													
											</tr>-->
											<tr>
												<td valign="top">Reason</td><td valign="top">:</td>
												<td><textarea class="inp" name="reason" style="width: 300px;height: 100px;" data-required="true" ></textarea>
														
												</td>
											</tr>
											
											<tr><td>Validity</td><td>:</td><td><b>Valid For the Calender Month</b></td></tr>
											</div>
										</table>
								</form>
						</div>
						</p>

<div id="pnh_membersch" title="Give Member Scheme">
									<form id="membr_schform" method="post"
										action="<?=site_url("admin/pnh_give_member_sch/{$f['franchise_id']}")?>"
										data-validate="parsley">

										<table cellspacing="10">

											<tr>
												<td>Scheme Type</td>
												<td>:</td>
												<td><select name="ime_schtype">
														<option value="0">Fixed Fee</option>
														<option value="1">percentage</option>
												</select></td>
											</tr>
											<tr>
												<Td>Cash Back</td>
												<td>:</td>
												<td><input type="text" name="mbrsch_credit" size="25">
												</td>
											</tr>

											<!--  <tr>
												<td>Menu </td><td>:</td>
												<td><b><?php //echo $is_membrsch_applicable['menu'] ;?></b></td>
											</tr>-->
											<tr>
												<td>Menu</td>
												<td>:</td>
												<td><select name="mbr_schmenu" class="schmenu"
													data-placeholder="Select Menu" style="width: 250px;"
													data-required="true">
														<option value="0"></option>
														<?php foreach($this->db->query("SELECT distinct a.menuid as id,b.name FROM `pnh_franchise_menu_link`a JOIN pnh_menu b ON b.id=a.menuid WHERE a.status=1 and fid=? group by id order by b.name asc",$f['franchise_id'])->result_array() as $menu){?>
														<option value="<?php echo $menu['id']?>">
															<?php echo $menu['name']?>
														</option>
														<?php }?>
												</select></td>

											</tr>

											<tr>
												<td>Category</td>
												<td>:</td>
												<td><select name="mbr_schcat" class="select_cat"
													data-placeholder="Select Category" style="width: 250px;"
													data-required="true"></select> </select>
												</td>
											</tr>

											<tr>
												<td>Brand</td>
												<td>:</td>
												<td><select name="mbr_schbrand" class="select_brand"
													data-placeholder="Select Brand" style="width: 250px;"
													data-required="true"></select>
												</td>
											</tr>

											<tr>
												<td>From</td>
												<td>:</td>
												<td><input type="text" class="inp" size="10"
													name="msch_start" id="msch_start" data-required="true"> to
													<input type="text" class="inp" size="10" name="msch_end"
													id="msch_end" data-required="true"></td>

											</tr>
											<tr>
												<td>Apply From</td>
												<td>:</td>
												<td><input type="text" class="inp" size="10"
													name="mbrsch_applyfrm" id="msch_applyfrm"
													data-required="true">
											
											</tr>
											</div>
										</table>
									</form>

								</div>

					</td>
				</tr>

				<div class="clear"></div>
			</table>
		</div>
				<?php } ?>
		 <div class="clear"></div>
					<div id="schme_disc_history" title="Scheme Discount History" >
						<h4 style="margin-bottom: 0px;">Scheme Discount History</h4>
						<table class="datagrid" width="100%">
							<thead>
								<tr>
									<th>Discount</th>
									<th>Menu</th>
									<th>Brand</th>
									<th>Category</th>
									<th>From</th>
									<th>To</th>
									<th>Reason</th>
									<th>Given by</th>
									<th>On</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($this->db->query("select h.*,a.name as admin,m.name AS menu  from pnh_sch_discount_track h left outer join king_admin a on a.id=h.created_by LEFT JOIN pnh_menu m ON m.id=h.sch_menu where franchise_id=? order by h.id desc",$f['franchise_id'])->result_array() as $h){?>
								<tr>
									<td><?=$h['sch_discount']?>%</td>
									<td><?php echo $h['menu'];?> </td>
									<td><?=$h['brandid']==0?"All Brands":$this->db->query("select name from king_brands where id=?",$h['brandid'])->row()->name?>
									</td>
									<td><?=$h['catid']==0?"All Categories":$this->db->query("select name from king_categories where id=?",$h['catid'])->row()->name?>
									</td>
									<td><?=date("d/m/y",$h['sch_discount_start'])?></td>
									<td><?=date("d/m/y",$h['sch_discount_end'])?></td>
									<td><?=$h['reason']?></td>
									<td><?=$h['admin']?></td>
									<td><?=date("g:ia d/m/y",$h['created_on'])?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<div style="padding: 10px; background: #eee;">
							Current Scheme Discount for all brands : <b><?=$f['sch_discount']?>%</b><br>
							Valid from :
							<?=date("d/m/y",$f['sch_discount_start'])?>
							&nbsp; &nbsp; Valid upto :
							<?=date("d/m/y",$f['sch_discount_end'])?>
							<br>
							<?php if($f['is_sch_enabled']){?>
							Status : Enabled <a style="float: right" class="danger_link"
								href="<?=site_url("admin/pnh_disenable_sch/{$f['franchise_id']}/0")?>">disable</a>
							<?php }else{?>
							Status : Disabled <a style="float: right" class="danger_link"
								href="<?=site_url("admin/pnh_disenable_sch/{$f['franchise_id']}/1")?>">enable</a>
							<?php }?>
							<div class="clear"></div>
						</div>
					</div>
					<div class="clear"></div>


				<div id="orders">

					<div>
						<div class="dash_bar">
							Total Orders : <span><?=$this->db->query("select count(1) as l from king_transactions where franchise_id=?",$f['franchise_id'])->row()->l?>
							</span>
						</div>
						<div class="dash_bar">
							Orders last month : <span><?=$this->db->query("select count(1) as l from king_transactions where franchise_id=? and init between ".mktime(0,0,0,date("m")-1,01,date('Y'))." and ".(mktime(0,0,0,date("m"),01,date('Y'))-1),$f['franchise_id'])->row()->l?>
							</span>
						</div>
						<div class="dash_bar">
							Orders this month : <span><?=$this->db->query("select count(1) as l from king_transactions where franchise_id=? and init >".mktime(0,0,0,date("m"),1),$f['franchise_id'])->row()->l?>
							</span>
						</div>

						<div class="dash_bar">
							Total Order value : <span>Rs <?=number_format($this->db->query("select sum(amount) as l from king_transactions where franchise_id=?",$f['franchise_id'])->row()->l,0)?>
							</span>
						</div>
						<div class="dash_bar">
							Value last month : <span>Rs <?=number_format($this->db->query("select sum(amount) as l from king_transactions where franchise_id=? and init between ".mktime(0,0,0,-1,1)." and ".mktime(23,59,59,-1,31),$f['franchise_id'])->row()->l,2)?>
							</span>
						</div>
						<div class="dash_bar">
							Value this month : <span>Rs <?=number_format($this->db->query("select sum(amount) as l from king_transactions where franchise_id=? and init >".mktime(0,0,0,date("m"),1),$f['franchise_id'])->row()->l,2)?>
							</span>
						</div>
						<div class="dash_bar">
							Total commission : <span>Rs <?=number_format($this->db->query("select sum(o.i_coup_discount) as l from king_transactions t join king_orders o on o.transid=t.transid where t.franchise_id=?",$f['franchise_id'])->row()->l,2)?>
							</span>
						</div>
						<div class="dash_bar">
							Total commission this month : <span>Rs <?=number_format($this->db->query("select sum(o.i_coup_discount) as l from king_transactions t join king_orders o on o.transid=t.transid where t.franchise_id=? and o.time>".mktime(0,0,0,date("m"),1),$f['franchise_id'])->row()->l,2)?>
							</span>
						</div>
					</div>
					<div id="franchise_order_list_wrapper" style="clear: both; z-index: 9 !important;">
						
						<div id="franchise_ord_list" style="clear: both;overflow: hidden">
							<table width="100%" >
								<tr>
									<td>
										<div class="tab_list" style="clear: both;overflow: hidden">
											<ol>
												<li><a class="all" href="javascript:void(0)" onclick="load_franchise_orders('all')" >All</a></li>
												<li><a class="shipped" href="javascript:void(0)" onclick="load_franchise_orders('shipped')">Shipped</a></li>
												<li><a class="unshipped" href="javascript:void(0)" onclick="load_franchise_orders('unshipped')">UnShipped</a></li>
												<li><a class="cancelled" href="javascript:void(0)" onclick="load_franchise_orders('cancelled')">Cancelled</a></li>
											</ol>
										</div>
									</td>
									<td align="right">
										<div >
											<form id="franchise_ord_list_frm" method="post"
												action="<?php echo site_url('admin/jx_pnh_getfranchiseordersbydate')?>">
												<input type="hidden" value="all" name="type">
												<input type="hidden" name="fid"
													value="<?php echo $f['franchise_id']?>"> <b>Show Orders </b> :
												From :<input type="text" style="width: 90px;" id="ord_fil_from"
													name="ord_fil_from" value="<?php echo date('Y-m-01',time())?>" />
												To :<input type="text" style="width: 90px;" id="ord_fil_to"
													name="ord_fil_to" value="<?php echo date('Y-m-d',time())?>" /> <input
													type="button" onclick="load_franchise_orders(1)" value="Submit">
											</form>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2" align="left">
										 <div class="franchise_ord_list_content" style="clear:both;"></div>
									</td>
								</tr>
							</table>
							<div id="remarks_changestatus" title="Change Amount Transit Status">
								<form id="transit_rmks" method="post" action="<?php echo site_url("admin/pnh_change_receipt_trans_type/{$pr['receipt_id']}")?>" date-validate="parsley">
									<table>
										<tr><td><b>Receipt Id</b></td><td><b>:</b></td><td id="r_receiptid"><b></b></td></tr>
										<tr><td><b>Remarks</b></td><td><b>:</b></td><td><textarea name="transit_rmks" data-required="true" style="width: 331px; height: 172px;"></textarea></td></tr>
										
										<tr><td><input type="hidden" name="rid" value=""></td></tr>
									</table>
								</form>
							</div>
						</div>  
					</div>
				</div>
				<div id="images">
					<table width="100%" cellpadding=10>
						<tr>
							<?php foreach($this->db->query("select * from pnh_franchise_photos where franchise_id=?",$f['franchise_id'])->result_array() as $i=>$img){?>
							<td align="center"><a
								href="<?=ERP_IMAGES_URL?>franchises/<?=$img['pic']?>"
								target="_blank"><img
									src="<?=ERP_IMAGES_URL?>franchises/<?=$img['pic']?>"
									width="200"> </a>
								<div>
									<?=$img['caption']?>
								</div>
							</td>
							<?php if(($i+1)%4==0) echo '</tr><tr>'; }?>
						</tr>
					</table>
				</div>

				<div id="bank" title="Bank Details" style="display: none;">
					<div style="margin: 5px;">
						<table class="datagrid">
							<thead>
								<tR>
									<th>Bank Name</th>
									<th>Account No</th>
									<th>Branch Name</th>
									<th>IFSC Code</th>
								</tR>
							</thead>
							<tbody>
								<?php foreach($this->db->query("select * from pnh_franchise_bank_details where franchise_id=?",$f['franchise_id'])->result_array() as $b){?>
								<tr>
									<td><?=$b['bank_name']?></td>
									<td><?=$b['account_no']?></td>
									<td><?=$b['branch_name']?></td>
									<td><?=$b['ifsc_code']?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
						<?php if(empty($b)) echo "No bank details linked"?>
					</div>
					<input type="button" value="Add new bank details"
						onclick='$("#bank_form").show();$(this).hide();'>
					<form id="bank_form" method="post"
						action="<?=site_url("admin/pnh_franchise_bank_details/{$f['franchise_id']}")?>"
						style="display: none;">
						<table style="background: #dedede; padding: 5px; margin: 10px;"
							cellpadding=5>
							<tr>
								<Th colspan="100%">Add new bank details</Th>
							</tr>
							<tr>
								<Td>Bank Name</td>
								<td>:</Td>
								<td><input type="text" class="inp mand bank_name"
									name="bank_name" size="30"></td>
							</tr>
							<tr>
								<Td>Account No</td>
								<td>:</Td>
								<td><input type="text" class="inp  mand account_no"
									name="account_no" size="20"></td>
							</tr>
							<tr>
								<Td>Branch Name</td>
								<td>:</Td>
								<td><input type="text" class="inp mand branch_name"
									name="branch_name" size="40"></td>
							</tr>
							<tr>
								<Td>IFSC Code</td>
								<td>:</Td>
								<td><input type="text" class="inp mand ifsc_code"
									name="ifsc_code" size="20"></td>
							</tr>
							<tr>
								<Td></Td>
								<td><input type="submit" value="Add bank details"></td>
							</tr>
						</table>
					</form>
				</div>


				</div>


				</div>
<!-- Franchise suspend form START -->
	<div id="fran_suspend" title="Suspend Franchise" style="overflow: hidden;">
		<form id="suspend_reasonfrm" method="post"
			action="<?php echo site_url("admin/pnh_suspend_fran/{$f['franchise_id']}")?>"
			data-validate="parsley">
			<input type="hidden" name="franchise_id" id="franchise_id">
			<table cellspacing="5" width="100%">
				<tr>
					<td valign="top"><b>Suspension Type</b></td>
					<td valign="top"><b>:</b></td>
					<td valign="top"><select name="sus_type" id="sus_type"
						data-placeholder="Select Suspension type" data-required="true"><option
								value="">Choose</option><option value="1">
							
							 Permanent Suspension
							</option><option value="2">Payment Suspension</option>
							<option value="3">Temporary Suspension</option>
					</select></td>
				</tr>
				<tr></tr>
				<tr>
					<td valign="top"><b>Reason</b></td>
					<td valign="top"><b>:</b></td>
					<td valign="top"><textarea name="sus_reason" data-required="true"
							style="width: 289px; height: 110px;"></textarea></td>
				</tr>
			</table>
		</form>
	</div>
	<!-- Franchise suspend form END -->
	
	<div id="unsuspend_fran" title="Unsuspend Franchise">
	<form id="unsuspend_reasonfrm" method="post" data-validate="parsley">
	<input type="hidden" name="unsuspend_fid" id="unsuspend_fid">
			<table cellspacing="5" width="100%">
			<tr>
					<td valign="top"><b>Reason</b></td>
					<td valign="top"><b>:</b></td>
					<td valign="top"><textarea name="unsus_reason" data-required="true" style="width: 289px; height: 73px;"></textarea></td>
			</tr>
			</table>
	</form>
	</div>
	    <div class="modal" style="display:none">
	   	</div>
    	<div class="loading" align="center" style="display:none">
        Loading. Please wait.<br />
        <br />
        <img src="<?php echo base_url('/images/ajax-loader.gif')?>" alt="" />
    </div>
<style>
.subdatagrid {
	width: 100%
}

.subdatagrid th {
	padding: 5px;
	font-size: 11px;
	background: #F4EB9A;
	color: maroon
}

.subdatagrid td {
	padding: 3px;
	font-size: 12px;
}

.subdatagrid td a {
	color: #121213;
}

.cancelled_ord td {
	text-decoration: line-through;
	color: #cd0000 !important;
}

.cancelled_ord td a {
	text-decoration: line-through;
	color: #cd0000 !important;
}

.tabs ul.tabsul li a {
	display: block;
	padding: 5px 10px;
}
.vm #details td{
padding:7px;
background:#dfdfff;
}
.label{
font-weight:bold;
width:100px;
background:#eee !important;
}
.modal
        {
            position: fixed;
            top: 0;
            left: 0;
            background-color: black;
            z-index: 99;
            opacity: 0.8;
            filter: alpha(opacity=80);
            -moz-opacity: 0.8;
            min-height: 100%;
            width: 100%;
        }
        .loading
        {
            font-family: Arial;
            font-size: 10pt;
            border: 5px solid #67CFF5;
            width: 200px;
            height: 100px;
            display: none;
            position: fixed;
            background-color: White;
            z-index: 999;
        }
</style>
</div>
<script>
$('.select_brand').chosen();
$('.select_cat').chosen();
$('#sus_type').chosen();
/*function load_allbrands()
{
	var brands_html='<option value=""></option>';
	$.getJSON(site_url+'/admin/jx_getallbrands','',function(resp){
		if(resp.status == 'error')
		{
			alert(resp.message);
		}
		else
		{
			brands_html+='<option value="0">All</option>';
			$.each(resp.brand_list,function(i,b){
			brands_html+='<option value="'+b.id+'">'+b.name+'</option>';
			});
		}
		
		$('select[name="brand"]').html(brands_html);
		$('select[name="brand"]').trigger("liszt:updated");
		
	});
}

function load_allcatgory()
{
	var cat_html='<option value=""></option>';
	$.getJSON(site_url+'/admin/jx_getallcategory','',function(resp){
		if(resp.status == 'error')
		{
			alert(resp.message);
		}
		else
		{
			cat_html+='<option value="0">All</option>';
			$.each(resp.cat_list,function(i,c){
				cat_html+='<option value="'+c.id+'">'+c.name+'</option>';
			});
		}
		
		$('select[name="cat"]').html(cat_html);
		$('select[name="cat"]').trigger("liszt:updated");
		
	});
}*/

	var fil_ordersby = 'all';
	
	function load_franchise_orders(stat)
	{
		if(stat != 1)
			fil_ordersby = stat;
				
		
		$('.tab_list .selected').removeClass('selected');
		$('.tab_list .'+fil_ordersby).addClass('selected');
			
				
		$('#franchise_ord_list_frm input[name="type"]').val(fil_ordersby);
		
		$('.franchise_ord_list_content').html("Loading...");
		$.post($('#franchise_ord_list_frm').attr('action'),$('#franchise_ord_list_frm').serialize()+'&stat='+stat,function(resp){
			$('.franchise_ord_list_content').html(resp);
		});
		return false;
	}
$(function(){
	var fran_reg_date = "<?php echo date('m/d/Y',$f['created_on'])?>";
	prepare_daterange('ord_fil_from','ord_fil_to');
	$("#d_start,#d_end").datepicker({minDate:0});
	prepare_daterange('msch_start','msch_end');
	$('#msch_applyfrm').datepicker();
	$("#sec_date").datepicker();
	$( "#d_ac_from").datepicker({
	      changeMonth: true,
	      dateFormat:'yy-mm-dd',
	      numberOfMonths: 1,
	      maxDate:0,
	      minDate: new Date(fran_reg_date),
	    	onClose: function( selectedDate ) {
	        $( "#d_ac_to" ).datepicker( "option", "minDate", selectedDate );
	      }
	    });
	    $( "#d_ac_to" ).datepicker({
	      changeMonth: true,
	      dateFormat:'yy-mm-dd',
	      numberOfMonths: 1,
	      maxDate:0,
	      onClose: function( selectedDate ) {
	        $( "#d_ac_from" ).datepicker( "option", "maxDate", selectedDate );
	      }
	    });
	
	
	 
	$(".inst_type").change(function(){
		$(".inst").hide();
		if($(this).val()=="1")
		{
			$(".inst").show().val("");
			$(".inst_no .label").html("Cheque No");
			$(".inst_date .label").html("Cheque Date");
		}
		else if($(this).val()=="2")
		{
			$(".inst").show().val("");
			$(".inst_no .label").html("DD No");
			$(".inst_date .label").html("DD Date");
		}
		else if($(this).val()=="3")
		{
			$(".inst").show().val("");
			$(".inst_date .label").html("Transfer Date");
			$(".inst_no").hide();
		}
	}).val("0").change();

					
	$("#sch_form").data('psubumit',false).submit(function(){
		if($("#d_start").val().length==0 || $("#d_end").val().length==0)
		{
			$("#sch_form").data('psubumit',false);
			alert("Enter start date and end date");
			return false;
		}
		
		var sch_disc = $('input[name="discount"]',this).val();
			sch_disc = $.trim(sch_disc)*1;
			if(isNaN(sch_disc))
			{
				$("#sch_form").data('psubumit',false);
				alert("invalid discount entered");
				return false;
			}else
			{
				$.post(site_url+'/admin/jx_check_schemexist/<?php echo $fran['franchise_id']?>','',function(resp){
					if(resp.status == 'error')
					{
						$("#sch_form").data('psubumit',false);
						alert(resp.message);
						
					}else
					{
						$("#sch_form").data('psubumit',true);
						$("#sch_form").submit();
						$(this).dialog('close');
						
						
					} 
				});
			}
		//alert(resp.message);
		//return $(this).data('psubumit');
	});
	

	
	$(".credit_form").submit(function(){
		if(!is_integer($("input[name=limit]",$(this)).val()))
		{
			alert("Enter a number");
			return false;
		}
		reason=prompt("Please mention a resaon");
		if(reason.length==0)
			return false;
		$(".c_reason",$(this)).val(reason);
		return true;
	});
	$("#bank_form").submit(function(){
		f=true;
		$("input",$(this)).each(function(){
			if($(this).val().length==0)
			{
				alert($("td:first",$(this).parents("tr").get(0)).text());
				f=false;
				return false;
			}
			return f;
		});
	});

	$("#top_form").submit(function(){
		 
		 $('input[type="text"]').each(function(){
		 	$(this).val($.trim($(this).val()))
		 });
		 
		var error_msgs = new Array();
		var inst_type = $('select[name="type"]',this).val();
		var bank = $('input[name="bank"]',this).val();
		var inst_no = $('input[name="no"]',this).val();
		var dateval = $('input[name="date"]',this).val();
		
			if(!is_numeric($(".amount",$(this)).val()))
				error_msgs.push("Enter a valid amount");
			
			var inst_type_str = 'Cash';	
				if(inst_type == 1)
					inst_type_str = 'Cheque';
				else if(inst_type == 2) 	
					inst_type_str = 'DD';
				else if(inst_type == 3) 	
					inst_type_str = 'Transfer';
					
			// validate cash entry 
			if(inst_type != 0)
			{
				if(!bank.length)
					error_msgs.push("Enter Bank Name");
					
				if(!inst_no.length && inst_type != 3)
					error_msgs.push("Enter "+inst_type_str+" no");
					
				if(!dateval.length)
					error_msgs.push("Enter "+inst_type_str+" Date ");
						
			}
			
			if($(".msg",$(this)).val().length==0)
				error_msgs.push("Please enter Message");
		
		if(error_msgs.length)
		{
			alert("Invalid Inputs Entered \n\n"+error_msgs.join("\n"));
			return false;
		}
		
		if(!confirm("Are you sure you want add this receipt ?"))
			return false;
		
		if(inst_type == 0)
		{
			$('input[name="bank"]',this).val("");
			$('input[name="date"]',this).val("");
		}
		
		if(inst_type == 3 || inst_type == 0 )
			$('input[name="no"]',this).val("");
		
	});
	
	$("#acc_change_form").submit(function(){
		 $('input[type="text"]').each(function(){
		 	$(this).val($.trim($(this).val()))
		 });
		 
		var error_msgs = new Array();
		
			if(!$('input[name="amount"]',this).val().length)
				error_msgs.push("Enter amount");
				
			if(!$('input[name="desc"]',this).val().length)
				error_msgs.push("Enter description");
			
			if(error_msgs.length)
			{
				alert("Invalid Inputs Entered \n\n"+error_msgs.join("\n"));
				return false;
			}
			
			if(!confirm("Are you sure you want to make this correction ?"))
				return false;
		 
	});
	

	$("#allot_mid_form").submit(function(){
		if($("input[name=start]",$(this)).val().length!=8 || $("input[name=end]",$(this)).val().length!=8 || $("input[name=start]",$(this)).val().charAt(0)!="2" || $("input[name=end]",$(this)).val().charAt(0)!="2")
		{
			alert("Please enter valid MID");
			return false;
		}
		return true;
	});

	$("#d_ac_form").submit(function(){
		if($("#d_ac_from").val().length==0 || $("#d_ac_to").val().length==0)
		{
			alert("Please enter valid from and to date");
			return false;
		}
		return true;
	});

	$("#fran_ver_change").change(function(){
		if($(this).val()=="0")
			return;
		if(confirm("Are you sure to change the version?"))
			location="<?=site_url("admin/pnh_fran_ver_change/{$fran['franchise_id']}")?>/"+$(this).val();
	});
	load_franchise_orders('all');
});
function give_sch_discnt_frm()
{
	$('#sch_hist').dialog('open');
	//load_allbrands();
	//load_allcatgory();
}
$( "#sch_hist" ).dialog({
	modal:true,
	autoOpen:false,
	width:500,
	height:500,
	autoResize:true,
	open:function(){
	dlg = $(this);
	
	},
	buttons:{
		'Cancel' :function(){
		 $(this).dialog('close');
		},
		'Submit':function(){
			var sch_form=$("#sch_form",this);
			if(sch_form.parsley('validate'))
			{
				//sch_form.submit();

				if($("#d_start").val().length==0 || $("#d_end").val().length==0)
				{
					alert("Enter start date and end date");
					return false;
				}

				var sch_disc = $('input[name="discount"]',this).val();
					sch_disc = $.trim(sch_disc)*1;
					if(isNaN(sch_disc))
					{
						alert("invalid discount entered");
						return false;
					}
					if(sch_disc > 20)
					{
						alert("Maximum 10% is allowed for scheme discount");
						return false;
					}	

				$.post(site_url+'/admin/jx_check_schemexist/<?php echo $f['franchise_id']?>',$("#sch_form").serialize(),function(resp){
					if(resp.status == 'error')
					{
						alert(resp.message);
					}else
					{
						$("#sch_form").submit();
						//$("#sch_hist").dialog('close');
						ShowProgress();
						$("#sch_hist").dialog('close');
						
					} 
				},'json');
			}
			else
			{
				alert("All fileds are required");
			}
		},
	}
});

function ShowProgress() {
    setTimeout(function () {
        var modal = $('<div />');
        modal.addClass("modal");
        $('body').append(modal);
        var loading = $(".loading");
        loading.show();
        var top = Math.max($(window).height() / 2 - loading[0].offsetHeight / 2, 0);
        var left = Math.max($(window).width() / 2 - loading[0].offsetWidth / 2, 0);
        loading.css({ top: top, left: left });
    }, 300);
}
function load_bankdetails()
{
	$('#bank').dialog('open');
}

$( "#bank" ).dialog({
	modal:true,
	autoOpen:false,
	width:'600',
	height:'auto',
	open:function(){
	dlg = $(this);
	},
	buttons:{
		'Close' :function(){
		 $(this).dialog('close');
		}
	}
});

function members_details()
{
	$('#members').dialog('open');
}

$( "#members" ).dialog({
	modal:true,
	autoOpen:false,
	width:'700',
	height:'auto',
	open:function(){
	dlg = $(this);
	},
	buttons:{
		'Close' :function(){
		 	$(this).dialog('close');
		}
	}
});
function load_scheme_disc_history()
{
	$('#schme_disc_history').dialog('open');
}

$( "#schme_disc_history" ).dialog({
	modal:true,
	autoOpen:false,
	width:'900',
	height:'auto',
	open:function(){
		dlg = $(this);
	},
	buttons:{
		'Close' :function(){
		 $(this).dialog('close');
		}
	}
});


function init_frmap() {
  	$('.fran_menu').chosen();
}
$(function(){
	$('.leftcont').hide();	
});
$('.schmenu').chosen();

var sel_menuid=0;

$(function(){

	$('.select_cat').change(function(){
	//alert($(this).val());
	//sel_menuid=$('.schmenu').val();
	sel_catid=$(this).val();
	if(sel_catid!='0')
	{
		$(".select_brand").html('').trigger("liszt:updated");
		$.getJSON(site_url+'/admin/jx_load_allbrandsbycat/'+sel_catid,'',function(resp){
		var brands_html='';
		if(resp.status=='error')
		{
			alert(resp.message);
		}
		else
		{
			brands_html+='<option value=""></option>';
			brands_html+='<option value="0">All</option>';
			$.each(resp.brand_list,function(i,b){
			brands_html+='<option value="'+b.brandid+'">'+b.name+'</option>';
			});
		}
		 $('.select_brand').html(brands_html).trigger("liszt:updated");
		 $('.select_brand').trigger('change');
		});
	}
/*	else
	{
		load_allbrands();
	}*/
});

$('.schmenu').change(function()
{
	var sel_menuid=$(this).val();
	//var sel_brandid=$(this).val();
	if(sel_menuid!='0')
	{
		$(".select_cat").html('').trigger("liszt:updated");
		$.getJSON(site_url+'/admin/jx_load_allcatsbymenu/'+sel_menuid,'',function(resp){
			var cats_html='';
				if(resp.status=='error')
				{
					alert(resp.message);
				}
				else
				{
					cats_html+='<option value=""></option>';
					cats_html+='<option value="0">All</option>';
					$.each(resp.cat_list,function(i,b){
					cats_html+='<option value="'+b.catid+'">'+b.name+'</option>';
					});
				}
		 	$('.select_cat').html(cats_html).trigger("liszt:updated");
		 	$('.select_cat').trigger('change');
		});
	}

});

});

$('.tab_view').tabs();
$( ".fran_tabs a" ).click(function()
{
	window.location.hash = $(this).attr('href');   
	window.scrollTo(0,0); 
});


/*$(".transit_link").click(function(e){
	if(!confirm("Are you sure want change to 'IN Hand' status?"))
	{
		e.preventDefault();
		return false;
	}
	return true;
});*/

$('#r_type').change(function(){
	r=$(this).val();
	if(r=='0')
	{
		$(".inst_type option[value="+1+"]").hide();
	}
	else
	{
		$(".inst_type option[value="+1+"]").show();
	}
});

function change_status(rid)
{
	$('#remarks_changestatus').data('receipt_id',rid).dialog('open');
}

$('#remarks_changestatus').dialog({

	model:true,
	autoOpen:false,
	width:'500',
	height:'330',
	open:function(){
		dlg = $(this);
		$('#transit_rmks input[name="rid"]',this).val(dlg.data('receipt_id'));
		$("#r_receiptid b",this).html(dlg.data('receipt_id'));
		$("#transit_rmks",this).attr('action',site_url+'/admin/pnh_change_receipt_trans_type/'+dlg.data('receipt_id')); 
	},
	buttons:{
		'Submit':function(){
			var transit_rmksfrm = $("#transit_rmks",this);
			 	if(transit_rmksfrm.parsley('validate'))
				{
					$('#transit_rmks').submit();
					$(this).dialog('close');
				}
		       else
		       {
		       		alert('Remarks Need to be addedd!!!');
		       }
		},
		'Cancel':function()
		{
			$(this).dialog('close');
		},
	}
	
});


function give_supersch()
{
	$("#pnh_superschme").dialog('open');
}

$('#fran_misc_logs').tabs();

$("#pnh_superschme").dialog({
	modal:true,
	autoOpen:false,
	width:'500',
	height:'500',
	open:function(){
		
	},
	buttons:{
		'Cancel':function(){
			$(this).dialog('close');
		},
		'Submit':function(){
			var sch_form=$("#super_schform",this);
			if(sch_form.parsley('validate'))
			{
				$.post(site_url+'/admin/jx_check_schemexist/<?php echo $f['franchise_id']?>',$("#super_schform").serialize(),function(resp){
					if(resp.status == 'error')
					{
						alert(resp.message);
						return false;
					}else
					{
						$("#super_schform").data('psubumit',true);
						$("#super_schform").submit();
						ShowProgress();
						$("#pnh_superschme").dialog('close');
						
					} 
				},'json');
			}
			else
			{
				alert("All fileds are required");
			}
		},
	}
});

function give_membrsch()
{
	$('#pnh_membersch').dialog('open');
}

$("#pnh_membersch").dialog({
	modal:true,
	autoOpen:false,
	width:'500',
	height:'500',
	open:function(){
		
	},
	buttons:{
		'Cancel':function(){
			$(this).dialog('close');
		},
		'Submit':function(){
			var mbr_schfrm=$('#membr_schform');
			if(mbr_schfrm.parsley('validate'))
			{
				$.post(site_url+'/admin/jx_check_mbrschmenu/<?php echo $f['franchise_id']?>',$("#membr_schform").serialize(),function(resp){
					if(resp.status == 'error')
					{
						alert(resp.message);
						return false;
					}else
					{
						$('#membr_schform').data('psubumit',true);
						$('#membr_schform').submit();
						ShowProgress();
						$("#pnh_membersch").dialog('close');
					}
				},'json');
			}
				else
				{
					alert("All fileds are required");
				}
			},
		}
	
	});
</script>

<style>
.datagrid1 {border-collapse: collapse;border:none !important}
.datagrid1 th{border:none !important;font-size: 12px;padding:0px 0px;}
.datagrid1 td{border-right:none;border-left:none;border-bottom:1px dotted #ccc;font-size: 12px;}
.datagrid1 td a{text-transform: capitalize}
	#franchise_order_list_wrapper .tab_list{
		clear:both;
		display: block;
	}
	#franchise_order_list_wrapper .tab_list ol{
		padding-left:0px;
	}
	#franchise_order_list_wrapper .tab_list li{
		display: inline-block;
	}
	#franchise_order_list_wrapper .tab_list li a{
		display: block;
		background: #efefef;
		padding:5px 10px;
		font-size: 12px;
		color: #454545;
		cursor:pointer;
	}
	#franchise_order_list_wrapper .tab_list li a.selected{
		background: #555;
		color: #fff;
	}


.transit_link{
	border-radius:5px;
	background:#96C5E0;
	display:inline-block;
	padding:3px 7px;
	color:#fff;
}
.transit_link:hover{
	border-radius:0px;
	background:#3084C1;
	text-decoration:none;
}

.datagrid th{padding:12px 7px}
.datagrid1 {border-collapse: collapse;border:none !important}
.datagrid1 th{border:none !important;font-size: 13px;padding:0px 0px;}
.datagrid1 td{border-right:none;border-left:none;border-bottom:none;font-size: 12px;padding:2px;color: #444;text-transform: capitalize}
.datagrid1 td a{text-transform: capitalize}
.datagrid1 td b{font-weight: bold;font-size: 11px;}

</style>	 
<style>
		.module_cont{padding;2px;}
		.module_cont .module_cont_title{margin:5px 0px;}
		.module_cont .module_cont_block{clear:both;}
		.module_cont .module_cont_block .module_cont_block_grid_total{margin:3px 0px;}
		.module_cont .module_cont_grid_block_pagi{padding:3px;text-align: right;}
		.module_cont .module_cont_grid_block_pagi a{padding:5px 10px;color:#454545;background: #f1f1f1;display: inline-block}
		
	</style>
	
	<script>
		$('input[name="return_on_date"],input[name="return_on_date_end"]').datepicker({});
		
		$('input[name="return_on_date"],input[name="return_on_date_end"]').change(function(){
			$('input[name="return_kwd_srch"]').val('');
			load_return_prods(0);
		});
		
		$('input[name="return_kwd_srch"]').change(function(){
			$('input[name="return_on_date"]').val('');
			$('input[name="return_on_date_end"]').val('');
		});
		
		 
		function load_all_return_prods(pg)
		{
			$('input[name="return_kwd_srch"]').val('');
			$('input[name="return_on_date"]').val('');
			$('input[name="return_on_date_end"]').val('');
			load_return_prods(pg);
		}
		function load_return_prods(pg)
		{
			$('#return_products .module_cont_block_grid .datagrid tbody').html('<tr><td colspan="8"><div align="center"><img src="'+base_url+'/images/loading_bar.gif'+'"> </div></td></tr>');
			
			var ret_params = {};
				ret_params.fid = "<?php echo $f['franchise_id'] ?>";
				ret_params.return_on = $('input[name="return_on_date"]').val();
				ret_params.return_on_end = $('input[name="return_on_date_end"]').val();
				ret_params.return_srch_kwd = $('input[name="return_kwd_srch"]').val();
				
				if(!(ret_params.return_on && ret_params.return_on_end))
				{
					ret_params.return_on = '';
					ret_params.return_on_end = '';
				}
				
				$('#return_products .module_cont_block_grid_total .total b').text("");
				
			$.post(site_url+'/admin/jx_getreturnprodsbyfid/'+pg,ret_params,function(resp){
				if(resp.status == 'error')
				{
					alert(resp.error)
				}else
				{
					$('#return_products .module_cont_block_grid_total .total b').text(resp.total);
					if(resp.fran_rplist.length == 0)
					{
						$('#return_products .module_cont_block_grid .datagrid tbody').html('<tr><td colspan="12"><div align="center">No Data found</div></td></tr>');			
					}else
					{
						var ret_prodlist_html = '';
							$.each(resp.fran_rplist,function(a,b){
								ret_prodlist_html += '<tr>'
														+'<td>'+(pg+a+1)+'</td>'
														+'<td><a target="_blank" href="'+site_url+'/admin/view_pnh_invoice_return/'+b.return_id+'"><b>'+b.return_id+'</b></a></td>'
														+'<td>'+formatDateTime(new Date(b.created_on))+'</td>'
														+'<td>'+b.return_by+'</td>'
														+'<td>'+b.invoice_no+'</td>'
														+'<td>'+b.order_id+'</td>'
														+'<td style="line-height:20px;"><a href="'+site_url+'/admin/product/'+b.product_id+'"><b>'+b.product_name+'</b></a>  '+(b.barcode?' <br> Barcode :'+b.barcode:'')+' '+(b.imei_no?' <br> IMEINO :'+b.imei_no:'')+' '+' </td>'
														+'<td>'+b.qty+'</td>'
														+'<td>'+resp.return_cond[b.condition_type]+'</td>'
														+'<td>'+resp.return_process_cond[b.status]+'</td>'
														+'<td>'+formatDateTime(new Date(b.remarks.created_on))+'</td>'
														+'<td>'+b.remarks.remark_by+'</td>'
														+'<td>'+b.remarks.remarks+'</td>'
														
													+'</tr>';
							});
						$('#return_products .module_cont_block_grid .datagrid tbody').html(ret_prodlist_html);
						
						$('#return_products .module_cont_grid_block_pagi').html(resp.fran_rplist_pagi);
						
						$('#return_products .module_cont_grid_block_pagi a').unbind('click').click(function(e){
								e.preventDefault();
								
							var link_part = $(this).attr('href').split('/');
							var link_pg = link_part[link_part.length-1]*1;
								if(isNaN(link_pg))
									link_pg = 0;
									
								load_return_prods(link_pg);	
						});
						
					}
				}
			},'json');
		}
		load_return_prods(0);
		
		function load_credit_notes(pg)
		{
			$.post(site_url+'/admin/jx_getfrancreditnotes/'+pg,'fid=<?php echo $f['franchise_id'] ?>',function(resp){
				if(resp.status == 'error')
				{
					alert(resp.error)
				}else
				{
					$('#credit_notes .module_cont_block_grid_total .total b').text(resp.total);
					if(resp.fran_crnotelist.length == 0)
					{
						$('#credit_notes .module_cont_block_grid .datagrid tbody').html('<tr><td colspan="12"><div align="center">No Data found</div></td></tr>');			
					}else
					{
						var crnotelist_html = '';
							$.each(resp.fran_crnotelist,function(a,b){
								crnotelist_html += '<tr>'
														+'<td>'+(pg+a+1)+'</td>'
														+'<td>'+b.credit_note_id+'</td>'
														+'<td><a target="_blank" href="'+site_url+'/admin/invoice/'+b.invoice_no+'"><b>'+b.invoice_no+'</b></a></td>'
														+'<td>'+b.order_id+'</td>'
														+'<td>'+b.credit_note_amt+'</td>'
														+'<td>'+formatDateTime(new Date(b.createdon*1000))+'</td>'
													+'</tr>';
							});
						$('#credit_notes .module_cont_block_grid .datagrid tbody').html(crnotelist_html);
						
						$('#credit_notes .module_cont_grid_block_pagi').html(resp.fran_crnotelist_pagi);
						
						$('#credit_notes .module_cont_grid_block_pagi a').unbind('click').click(function(e){
								e.preventDefault();
								
							var link_part = $(this).attr('href').split('/');
							var link_pg = link_part[link_part.length-1]*1;
								if(isNaN(link_pg))
									link_pg = 0;
									
								load_credit_notes(link_pg);	
						});
						
					}
				}
			},'json');
		}
		
		load_credit_notes(0)

		//console.log(franchise_id).val();
		function  load_voucher_activity(ele,type,franchise_id,pg)
		{
			var franchise_id = '<?php echo $f['franchise_id'];?>';
			
			$($(ele).attr('href')+' div.tab_content').html('<div align="center"><img src="'+base_url+'/images/jx_loading.gif'+'"></div>');
			$.post(site_url+'/admin/jx_getpnh_voucher_activitylog/'+type+'/'+franchise_id+'/'+pg*1,'',function(resp){
				$($(ele).attr('href')+' div.tab_content').html(resp.log_data+resp.pagi_links);
				$($(ele).attr('href')+' div.tab_content .datagridsort').tablesorter();
				
			},'json');
		}

		function  load_allshipped_imei(ele,type,franchise_id,pg)
		{
			type = 1;
			pg = 0;
			var franchise_id = '<?php echo $f['franchise_id'];?>';
			$('#shipped_imeimobslno div.tab_content').html('<div align="center"><img src="'+base_url+'/images/jx_loading.gif'+'"></div>');
			$.post(site_url+'/admin/jx_load_all_shipped_mobimei/'+type+'/'+franchise_id+'/'+pg*1,'',function(resp){
				$('#shipped_imeimobslno div.tab_content').html(resp.log_data+resp.pagi_links);
				$('#shipped_imeimobslno div.tab_content .datagridsort').tablesorter();
			},'json');
		}
		$('.log_pagination a').live('click',function(e){
			e.preventDefault();
			$.post($(this).attr('href'),'',function(resp){
				$('#'+resp.type+' div.tab_content').html(resp.log_data+resp.pagi_links);
				$('#'+resp.type+' div.tab_content .datagridsort').tablesorter();
			},'json');
		});


		function reson_forsuspenfran(fid)
		{
			$("#fran_suspend").data('franchise_id',fid).dialog('open');
		}
		
		$("#fran_suspend").dialog({
			modal:true,
			autoOpen:false,
			width:'519',
			height:'300',
			open:function(){
				var dlg=$(this);
				$('#suspend_reasonfrm input[name="franchise_id"]',this).val(dlg.data('franchise_id'));
				//$("#r_receiptid b",this).html(dlg.data('receipt_id'));
				$("#suspend_reasonfrm",this).attr('action',site_url+'/admin/pnh_suspend_fran/'+dlg.data('franchise_id'));
			},
		buttons:{
			'Submit':function(){
				var dlg= $(this);
				var frm_fransuspend = $("#suspend_reasonfrm",this);
					 if(frm_fransuspend.parsley('validate')){

						 frm_fransuspend.submit();
						 $(this).dialog('close');
					}
		            else
		            {
		            	alert('All Fields are required!!!');
		            }
			},
			'Cancel':function(){
				$(this).dialog('close');
			}
		}
		});

		function reson_forunsuspension(fid)
		{
			$("#unsuspend_fran").data('unsuspend_fid',fid).dialog('open');
		}

		$("#unsuspend_fran").dialog({
			modal:true,
			autoOpen:false,
			width:'400',
			height:'200',
			open:function(){
				var dlg=$(this);
				$('#unsuspend_reasonfrm input[name="unsuspend_fid"]',this).val(dlg.data('unsuspend_fid'));
				$("#unsuspend_reasonfrm",this).attr('action',site_url+'/admin/pnh_unsuspend_fran/'+dlg.data('unsuspend_fid'));
			},
			buttons:{
			'Submit':function(){
				var unsuspendfran_form=$("#unsuspend_reasonfrm",this);
				if(unsuspendfran_form.parsley('validate')){
					unsuspend_reasonfrm.submit();
					$(this).dialog('close');
				}
				else
				{
					alert("Remarks required!!!");
				}
			},
			'Cancel':function(){
				$(this).dialog('close');
				}
			}

		});
	</script>
 
<?php
