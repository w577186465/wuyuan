<?php include $this->admin_tpl('header','admin');?>
<div class="table-list">
	<table width="100%">
        <thead>
            <tr>
			<th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="40">ID</th>
			<th>行业名称</th>
            <th width="40">行业ID</th>
            </tr>
        </thead>
		<tbody>
			<?php
				foreach ($industry as $r) {
			?>
			<tr>
				<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
				<td align='center' ><?php echo $r['id'];?></td>
				<td align='center'><?php echo $r['name'];?></td>
				<td align='center'><?php echo $r['dfcfval'];?></td>
			</tr>
			 <?php } ?>
		</tbody>
     </table>
	 <div id="pages"><?php echo $pages;?></div>
</div>