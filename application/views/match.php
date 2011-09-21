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


<ol>
	<?foreach($ranking AS $p):?>
	<li><?=$p->name?> [<?=$p->rank?>]</li>
	<?endforeach;?>
</ol>
