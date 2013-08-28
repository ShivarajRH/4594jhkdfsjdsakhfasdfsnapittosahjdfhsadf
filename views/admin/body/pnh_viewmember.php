<?php $u=$member; 
$gender=array("Male","Female");
$salutation=array("Mr","Mrs","Ms");
$marital=array("Single","Married","Other");
$expenses=array("&lt; Rs. 2000","Rs 2001 - Rs 5000","Rs 5001 - Rs 10000","&gt; Rs. 10000");
?>
<div class="container vm">
<h2>PNH Member Details</h2>

<div>
<div class="dash_bar">Member ID : <span><?=$u['pnh_member_id']?></span></div>
<div class="dash_bar">Loyalty Points : <span><?=$u['points']?></span></div>
<div class="dash_bar">Total orders : <span><?=$this->db->query("select count(distinct(transid)) as l from king_orders where userid=?",$u['user_id'])->row()->l?></span></div>
<div class="dash_bar">Total orders value : <span>Rs <?=number_format($this->db->query("select sum(t.amount) as l from king_transactions t where t.transid in (select transid from king_orders o where o.userid=?)",$u['user_id'])->row()->l)?></span></div>
<div class="dash_bar">Franchise : <span><?=$this->db->query("select concat(franchise_name,', ',city) as name from pnh_m_franchise_info where franchise_id=?",$u['franchise_id'])->row()->name?></span></div>
</div>

<div class="clear"></div>

<div class="tabs">

<ul>
<li><a href="#details">Details</a></li>
<li><a href="#orders">Orders</a></li>
<li><a href="#points">Loyalty points</a></li>
</ul>

<div id="details">

<div style="background:#eee;padding:5px;font-weight:bold;">Personal Data</div>

<div style="float:right;margin:20px;">
<div class="dash_bar">Is MID Card batch processed? : <span><?=$u['is_card_printed']?"YES":"PENDING"?></span></div>
</div>


<table cellpadding=3>
<tr><td class="label">Gender</td><td><?=$gender[$u['gender']]?></td></tr>
<tr><td class="label">Name</td><td><?=$salutation[$u['salute']]?>. <?="{$u['first_name']} {$u['last_name']}"?></td></tr>
<tr><td class="label">DOB</td><td><?=date("d/m/Y",strtotime($u['dob']))?></td></tr>
<tr><td class="label">Address</td><td><?=nl2br($u['address'])?></td></tr>
<tr><td class="label">City</td><td><?=$u['city']?></td></tr>
<tr><td class="label">Pin Code</td><td><?=$u['pincode']?></td></tr>
<tr><td class="label">Mobile</td><td><?=$u['mobile']?></td></tr>
<tr><td class="label">Email</td><td><?=$u['email']?></td></tr>
</table>


<div style="margin-top:10px;background:#eee;padding:5px;font-weight:bold;">Help us to know you better!</div>

<table cellpadding=0>
<tr>
<td width="50%">
<table cellpadding=3>
<tr><td style="height:35px;" class="label">Marital Status</td><td><?=$marital[$u['marital_status']]?></td></tr>
<tr><td class="label">Spouse Name</td><td><?=$u['spouse_name']?></td></tr>
<tr><td class="label">Child's Name</td><td><?=$u['child1_name']?></td></tr>
<tr><td class="label">Child's Name</td><td><?=$u['child2_name']?></td></tr>
</table>
</td>
<td width="50%">
<table cellpadding=3>
<tr><td class="label">Wedding Anniversary</td><td><?=$u['anniversary']==0?"na":date("d/m/Y",strtotime($u['anniversary']))?></td></tr>
<tr><td class="label">DOB</td><td><?=$u['child1_dob']==0?"na":date("d/m/Y",strtotime($u['child1_dob']))?></td></tr>
<tr><td class="label">DOB</td><td><?=$u['child2_dob']==0?"na":date("d/m/Y",strtotime($u['child2_dob']))?></td></tr>
</table>
</td>
</tr>
</table>

<table cellpadding=5>
<tr><td class="label">Profession</td><td><?=$u['profession']?></td></tr>
<tr>
<td class="label">Monthly Shopping Expense of your Household</td>
<td><?=$expenses[$u['expense']]?></td>
</tr>
</table>

</div>

<div id="orders">
<table class="datagrid">
<thead><tr><th>Transid</th><th>Amount</th><th>Ordered On</th><th>Status</th></tr></thead>
<tbody>
<?php $status=array("Pending","Invoiced","Shipped","Cancelled"); foreach($this->db->query("select o.*,t.amount from king_orders o join king_transactions t on t.transid=o.transid where o.userid=? group by o.transid order by sno desc",$u['user_id'])->result_array() as $o){?>
<tr>
<td><a class="link" href="<?=site_url("admin/trans/{$o['transid']}")?>"><?=$o['transid']?></a></td>
<td><?=$o['amount']?></td>
<td><?=date("g:ia d/m/y",$o['time'])?></td>
<td><?=$status[$o['status']]?></td>
</tr>
<?php }?>
</tbody>
</table>
</div>

<div id="points">
<table class="datagrid">
<thead><tr><th>Transid</th><th>Points</th><th>Allotted on</th></tr></thead>
<tbody>
<?php  foreach($this->db->query("select * from pnh_member_points_track where user_id=?",$u['user_id'])->result_array() as $t){?>
<tr>
<td><a href="<?=site_url("admin/trans/".$t['transid'])?>" class="link"><?=$t['transid']?></a></td>
<td><?=$t['points']?></td>
<td><?=date("d/m/y",$t['created_on'])?></td>
</tr>
<?php }?>
</tbody>
</table>
</div>

</div>



</div>
<style>
.vm #details td{
padding:7px;
background:#dfdfff;
}
.label{
font-weight:bold;
width:100px;
background:#eee !important;
}
</style>
<?php
