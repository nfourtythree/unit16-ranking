<?=form_open('/match')?>
<ul>
	<li>
		<?=form_dropdown('player1', $players);?>
		<?=form_input('player1_score', '');?>
	</li>
	<li>
		<strong>VS</strong>
	</li>
	<li>
		<?=form_dropdown('player2', $players);?>
		<?=form_input('player2_score', '');?>
		
	</li>
</ul>
<?=form_submit('submit', 'submit');?>
<?=form_close();?>


<table border="0" cellspacing="5" cellpadding="5">
	<tr>
		<th>&nbsp;</th>
		<th>P</th>
		<th>W</th>
		<th>D</th>
		<th>L</th>
		<th>F</th>
		<th>A</th>
		<th>GD</th>
		<th>R</th>
	</tr>
	<?foreach($ranking AS $p):?>
	<tr>
		<td><?=$p->name?></td>
		<td><?=($p->wins+$p->draws+$p->loses)?></td>
		<td><?=$p->wins?></td>
		<td><?=$p->draws?></td>
		<td><?=$p->loses?></td>
		<td><?=$p->for?></td>
		<td><?=$p->against?></td>
		<td><?=$p->for-$p->against?></td>
		<td><?=$p->rank?></td>
	</tr>
	<?endforeach;?>
</table>
