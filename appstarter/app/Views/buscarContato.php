<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/teste2.css'); ?>">


<a id='btn_add' href='/CriarContato' class='btn btn-primary'  role='button'>Adicionar Contato</a>
<?php

$table = new \CodeIgniter\View\Table();

$data = [
  ['UsuarioID','Nome', 'Email', 'Nascimento', 'Telefone','Empresa','Comandos']  
];

$template = [
  'table_open' => "<table id='tabelaBuscar' class='table table-striped'>",
];

$table->setTemplate($template);

foreach ($dados as $item) {
      
  $item['Comando1'] = "<a id='btn_add' href='/GetContato/{$item['Id']}' class='btn btn-primary'  role='button'>Alterar</a> <a id='btn_del' class='btn btn-primary'  href='/ExcluirContato/{$item['Id']}/{$item['NomeEmpresa']}' role='button'>Excluir</a>";  
    
  array_push($data, $item);
}


echo $table->generate($data);
?>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"> </script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $('#tabelaBuscar').DataTable();
});
</script>
