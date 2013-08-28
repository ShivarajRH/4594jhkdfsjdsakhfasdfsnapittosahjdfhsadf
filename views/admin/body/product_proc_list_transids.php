<html>
<head>
<title>Stock procure list</title>
</head>
<body onload='window.print()' style="font-family:arial;font-size:14px;">
<div style="float:right;color:#aaa;font-size:12px;"><?=date("g:ia d/m/y")?></div>
<h2 style="margin:5px 0px;">Stock procure list</h2>
<?php $pdata=$prods; foreach($prods as $transid=>$prods){?>
<h4 style="margin-bottom:0px;"><?=$transid?></h4>
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
<?php }?>
</body>
</html>
<?php
