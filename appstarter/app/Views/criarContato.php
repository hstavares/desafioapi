<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/teste2.css'); ?>">

<body>
    <?= $validation->listErrors();?>
</body>

<?php



helper('form');
helper('html');

echo form_open('/CriarContato');


echo form_label('Insira o nome da empresa: ', 'nomeEmpresa');
echo form_input('nomeEmpresa', '', "required","required");
echo form_label('Insira o nome do contato: ', 'nomeContato');
echo form_input('nomeContato', '', "required","required");
echo form_label('Insira o sobrenome do contato: ', 'sobrenomeContato');
echo form_input('sobrenomeContato', '', "required","required");
echo form_label('Insira o email do contato: ', 'email');
echo form_input('email', '', "required","required");
echo form_label('Insira a data de nascimento do contato: ', 'dataNascimento');
echo form_input('dataNascimento', '', "required","required");
echo form_label('Insira o telefone do contato: ', 'telefone');
echo form_input('telefone', '', "required","required");

echo form_submit('mysubmit', 'Submit Post!');
echo form_close();

?>
