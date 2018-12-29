<?php $this->load->view('email/_header'); ?>

<p><?php echo $email_content ?></p>

<table>
	<?php foreach ($data as $key => $value): ?>
		<tr>
			<td><strong><?php echo humanize($key); ?>: </strong></td>
			<td><?php echo $value; ?></td>
		</tr>
	<?php endforeach ?>
</table>

<?php $this->load->view('email/_footer'); ?>