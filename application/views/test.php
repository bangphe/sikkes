<html>
<head>
<title>My Form</title>
<style type="text/css">
	.field_error{
		color:#F00;
		display:block;	
	}
</style>
</head>
<body>

<?php echo validation_errors(); ?>

<?php echo form_open('form/add'); ?>

<h5>Kode</h5>
<input type="text" name="kode" value="" size="50" /><?php echo form_error('kode','<p class="field_error">','</p>');?>

<h5>Nama</h5>
<input type="text" name="nama" value="" size="50" /><?php echo form_error('nama','<p class="field_error">','</p>');?>

<div><input type="submit" value="Submit" /></div>

</form>

</body>
</html>
