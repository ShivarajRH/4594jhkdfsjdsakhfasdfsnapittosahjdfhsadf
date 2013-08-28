<html>
	<head>
		<title></title>
		<style>
			body{font-family: arial;margin:5%;font-size: 130%;line-height: 1.3em}
		</style>
	</head>
	<body>
		<div align="center">
			<br />
		<?php if($destination_details){
					foreach($destination_details as $details){
			?>
		
			<h1 style="font-size:260%;line-height: auto"><?php echo $details['pick_up_name'].'-'.$details['pick_up_contact']; ?></h1>
			<h2 style="font-size:180%"><?php echo $details['short_name'];?></h2>
			<br >
			<br >
			<div style="width: 100%">
			<fieldset style="padding:5%;border:2px solid #000">
				<div style="margin:10px;text-align: left;font-size: 90%">
				<?php echo $details['address'];?>
				<br>
				Mob - <?php echo $details['contact_no'];?>
				</div>
			</fieldset>
			</div>
			
			<br >
			<br >
			<div style="font-size:150%;line-height: 130%">
				<span style="font-size: 70%">FROM</span>	
			<h2 style="margin-bottom: 3px;font-weight: normal;margin-top: 5px;">PayNearHome</h2>
			<p style="margin-top: 5px;font-size:70%;">
				#1060,15th Cross,25th Main Road,BSK 2nd Stage,Bangalore - 560070 <br />
				<b>Ph: 080-26718801 - Mob - 9980143349</b> 
			</p>		
			</div>
			<?php } 
		}?>
		</div>
		<script>
			window.print();
		</script>
	</body>
</html>