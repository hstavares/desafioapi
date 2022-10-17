<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/teste2.css'); ?>">

<body>
    <?= $validation->listErrors();?>
</body>

<?php

helper('form');
helper('html');

echo form_open("/EditarContato/{$dados[0]["IdContato"]}");


echo form_label('Insira o nome da empresa: ', 'nomeEmpresa');
echo form_input('nomeEmpresa', "{$dados[0]["NomeEmpresa"]}", "required","required");
echo form_label('Insira o nome do contato: ', 'nomeContato');
echo form_input('nomeContato', "{$dados[0]["Nome"]}", "required","required");
echo form_label('Insira o sobrenome do contato: ', 'sobrenomeContato');
echo form_input('sobrenomeContato', "{$dados[0]["Sobrenome"]}", "required","required");
echo form_label('Insira o email do contato: ', 'email');
echo form_input('email', "{$dados[0]["Email"]}", "required","required");
echo form_label('Insira a data de nascimento do contato: ', 'dataNascimento');
echo form_input('dataNascimento', "{$dados[0]["DataNascimento"]}", "required","required");
echo form_label('Insira o telefone do contato: ', 'telefone');
echo form_input('telefone', "{$dados[0]["Telefone"]}", "required","required");

echo form_submit('mysubmit', 'Submit Post!');
echo form_close();

?>
