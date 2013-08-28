<div class="container">

<h2>Proforma Invoice : <?=$invoice['p_invoice_no']?></h2>



<table class="datagrid noprint">
<tbody>
<tr><td>No :</td><td><?=$invoice['p_invoice_no']?></td></tr>
<tr><td>Status :</td><td><?=$invoice['invoice_status']==0?"CANCELLED":($batch['invoice_no']==0?"NOT INVOICED":"INVOICED")?>
&nbsp;&nbsp; 
<?php if($invoice['invoice_status']==1 && $batch['invoice_no']==0){?>
<a href="<?=site_url("admin/cancel_proforma_invoice/{$invoice['p_invoice_no']}")?>" class="danger_link">CANCEL</a>
<?php }?>
</td></tr>
<tr><td>Invoice no :</td><td><?php if($batch['invoice_no']!=0){?><a href="<?=site_url("admin/invoice/{$batch['invoice_no']}")?>"><?=$batch['invoice_no']?></a><?php }?></td></tr>
<tr><td>Batch :</td><td><a href="<?=site_url("admin/batch/{$batch['batch_id']}")?>"><?=$batch['batch_id']?></a></td></tr>
</tbody>
</table>


<h3>Items in the proforma invoice</h3>
<table class="datagrid">
<thead><tr><th>Sno</th><th>Item</th><th>Qty</th><th>Status</th></tr></thead>
<tbody>
<?php $sno=1; foreach($orders as $o){?>
<tr>
<td><?=$sno++?></td>
<td><a href="<?=site_url("admin/deal/{$o['itemid']}")?>"><?=$o['product']?></a></td>
<td><?=$o['quantity']?></td>
<td><?=$this->db->query("select 1 from king_invoice where order_id=? and invoice_no=?",array($o['id'],$batch['invoice_no']))->num_rows()==0?"NOT INVOICED":"INVOICED"?>
</tr>
<?php }?>
</tbody>
</table>

</div>
<?php
