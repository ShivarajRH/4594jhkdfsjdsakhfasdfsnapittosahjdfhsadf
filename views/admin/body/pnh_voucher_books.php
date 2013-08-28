<div class="container page_wrap">
	<div class="clearboth">
		<div class="fl_left" >
			<h2 class="page_title">Voucher Books</h2>
		</div>
	</div>
	
	<div class="page_topbar" >
		<div class="fl_left" >
			<br>
			<b>Total Books :</b> <span><?php echo $total_books; ?></span>
		</div>
		<div class="page_action_buttonss fl_right" align="right">
			<a href="<?php echo site_url('admin/pnh_create_voucher_book') ?>" target="_blank" class="button button-rounded button-flat-secondary button-small">Create voucher book</a>&nbsp;
		</div>
	</div>
	<div style="clear:both">&nbsp;</div>
	<div class="page_content">
		<?php 
		if($books_list)
		{
		?>
			<table class="datagrid" cellpadding="5" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>#</th>
						<th>Book type</th>
						<th>Book serial no</th>
						<th>Value</th>
						<th>is_alloted</th>
						<th>Created on</th>
						<th>Created by</th>
					</tr>
				</thead>
				<tbody>
					<?php 				
						foreach($books_list as $i=> $book)
						{
					?>	
						<tr>
							<td><?php echo ($i+1);?></td>
							<td><?php echo ucfirst($book['book_type_name']); ?></td>
							<td><?php echo $book['book_slno']; ?></td>
							<td><?php echo $book['book_value']; ?></td>
							<td><?php echo $book['franchise_id']?'yes':'No'; ?></td>
							<td><?php echo format_date($book['created_on']);?></td>
							<td><?php echo $book['username'];?></td>
						</tr>
				<?php } ?>
					<tr >
						<td colspan="7" align="right"><?php echo $pagination; ?></td>
					</tr>
				</tbody>
			</table>
	<?php }else{
		echo '<div align="center"><b>No books found</b></div>';
	}?>
	</div>
</div>
