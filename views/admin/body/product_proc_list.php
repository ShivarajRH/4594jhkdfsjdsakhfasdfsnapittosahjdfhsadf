<html>
<head>
<title>Product procurement list</title>
</head>
<body style="font-family:arial;font-size:14px;">
<h2>Product procurement list for BATCH<?=$this->uri->segment(3)?></h2>
<table border=1 style="font-family:arial;font-size:13px;" cellpadding=3>
<tr style="background:#aaa">
<th>Product Name</th><th>Qty</th><Th>MRP</Th><th>Location</th>
</tr>
<?php $i=0; foreach($prods as $p){?>
<tr <?php if($i%2==0){?>style="background:#eee;"<?php }?>>
<td><?=$p['product']?></td>
<td><?=$p['qty']?></td>
<td><?=$p['mrp']?></td>
<td><?=$p['location']?>&nbsp;</td>
</tr>
<?php $i++;}?>
</table>
</body>
</html>
<?php
