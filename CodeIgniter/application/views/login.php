<?php echo form_open('/sessions/authenticate') ?>
<?php	
    $nombreUsuario = array('name' => 'nombreUsuario', 'placeholder' =>  '');
    $password = array('name' =>  'password', 'placeholder' => '');
?>
<?php echo form_label('Usuario','usuario')?>
<?php echo form_input($nombreUsuario)?>
<?php echo form_label('Contraseña','password')?>
<?php echo form_input($password)?>
<?php echo form_submit('','Ingresar')?>
<?php echo form_close()?>

