<?=form_open('/player/add')?>
<ul>
	<li>
		<label for='name'>Name</label>
		<?=form_input('name', '', 'id="name"');?>
	</li>
	<li>
		<label for='rank'>Rank</label>
		<?=form_input('rank', '1200', 'id="rank"');?>
	</li>
</ul>
<?=form_submit('submit', 'submit');?>
<?=form_close();?>

