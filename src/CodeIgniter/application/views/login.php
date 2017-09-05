<?php echo form_open('/sessions/authenticate','class="form-control"'); ?>
<?php	$nombreUsuario = array('name' => 'nombreUsuario',
	'placeholder' =>  '');
	$password = array('name' =>  'password' ,
	'placeholder' => '');

?>
<div class="form-group has-feedback">
<?php echo form_label('Usuario','usuario')?>
<?php echo form_input($nombreUsuario)?>
<?php echo form_label('Contraseña','password')?>
<?php echo form_password($password)?>
<?php echo form_submit('','Ingresar')?>
<?php echo form_close()?>
</div>



