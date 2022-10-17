<?php

namespace App\Controllers;

use Config\Services;

class ContatoController extends BaseController
{

protected $helpers = ['form'];

public function GetCriarContato(){

    if (strtolower($this->request->getMethod()) !== 'post') {
        return view('criarContato', [
            'validation' => Services::validation(),
        ]);
    }

    return view('criarContato');
}

public function CriarContato() {

    if (strtolower($this->request->getMethod()) !== 'post') {
        return view('criarContato', [
            'validation' => Services::validation(),
        ]);
    }

    $rules = [        
        'nomeEmpresa' => 'min_length[3]',
        'nomeContato' => 'min_length[3]',
        'sobrenomeContato' => 'min_length[10]',
        'dataNascimento' => 'min_length[8]|max_length[8]',
        'telefone' => 'min_length[11]|max_length[11]',    
        'email'    => 'valid_email',
    ];

    if (! $this->validate($rules)) {
        return view('criarContato', [
            'validation' => $this->validator,
        ]);
    }


$request = \Config\Services::request();

$nomeEmpresa = $_POST['nomeEmpresa'];
$nomeContato = $_POST['nomeContato'];
$nascimento = $_POST['dataNascimento'];
$sobrenomeContato = $_POST['sobrenomeContato'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];


    //conecta ao banco
    $db = \Config\Database::connect();

    // verifica se há uma empresa cadastrada com esse nome
    if ($this->AdicionaEmpresa($nomeEmpresa)) {
        $idEmpresa = $this->recuperaIdEmpresa($nomeEmpresa);
    }

    // verifica se há um registro cadastrado com esse email
    if ($this->AdicionaContato($email, $nomeContato, $sobrenomeContato, $nascimento, $telefone)) {
        $idContato = $this->recuperaIdContato($email);
    }

    $this->AdicionaContatoEmpresa($idContato, $idEmpresa);

    echo 'Sucesso';
}

public function ExcluirContato($idContato, $nomeEmpresa) {


    $db = \Config\Database::connect();

    

    $sql = $db->query("Select * from contato,Empresa, contatoEmpresa where contatoEmpresa.IdContato = contato.IdContato and contatoEmpresa.IdEmpresa = Empresa.IdEmpresa and contatoEmpresa.IdContato = {$idContato} and Empresa.NomeEmpresa = '{$nomeEmpresa}'");
        

    foreach ($sql->getResult() as $row) {
        
        $row = json_decode(json_encode($row),true);

        $remove = $db->query("Delete From contatoEmpresa where IdContatoEmpresa = {$row["IdContatoEmpresa"]}");


    }

    return $this->BuscarContato();

}

public function GetContato($idContato){
    
    $db = \Config\Database::connect();    

    $sql = $db->query("Select Empresa.NomeEmpresa,contato.* FROM contato,Empresa, contatoEmpresa WHERE contatoEmpresa.IdContato = contato.IdContato and contatoEmpresa.IdEmpresa = Empresa.IdEmpresa and Contato.IdContato = {$idContato} ");
    $result = $sql->getResult();


    if (strtolower($this->request->getMethod()) !== 'post') {
        return view('editarContato',[
            'validation' => Services::validation(),
            'dados' => json_decode(json_encode($result), true) 
        ]);
    }
        
}

public function EditarContato($idContato) {
    $db = \Config\Database::connect();    
    $sql = $db->query("Select Empresa.NomeEmpresa,contato.* FROM contato,Empresa, contatoEmpresa WHERE contatoEmpresa.IdContato = contato.IdContato and contatoEmpresa.IdEmpresa = Empresa.IdEmpresa and Contato.IdContato = {$idContato} ");
    $result = $sql->getResult();

    $rules = [        
        'nomeEmpresa' => 'min_length[3]',
        'nomeContato' => 'min_length[3]',
        'sobrenomeContato' => 'min_length[10]',
        'dataNascimento' => 'min_length[8]|max_length[8]',
        'telefone' => 'min_length[11]|max_length[11]',    
        'email'    => 'valid_email',
    ];

    if (! $this->validate($rules)) {
        return view('editarContato', [
            'validation' => $this->validator,
            'dados' =>json_decode(json_encode($result), true)
        ]);
    }

    $nomeEmpresa = $_POST['nomeEmpresa'];
    $nomeContato = $_POST['nomeContato'];
    $nascimento = $_POST['dataNascimento'];
    $sobrenomeContato = $_POST['sobrenomeContato'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $db = \Config\Database::connect();

    $sql = "UPDATE contato SET Nome = '{$nomeContato}', Sobrenome = '{$sobrenomeContato}', DataNascimento = '{$nascimento}', Email =  '{$email}',Telefone = '{$telefone}' where contato.IdContato = $idContato";
    $db->query($sql);
    return $this->BuscarContato();
    
}

public function BuscarContato() {    
    
    $db = \Config\Database::connect();
    $sql = $db->query("SELECT Empresa.NomeEmpresa, contato.* FROM contato,Empresa, contatoEmpresa WHERE contatoEmpresa.IdContato = contato.IdContato and contatoEmpresa.IdEmpresa = Empresa.IdEmpresa");
       
        
    $data = ['dados' => []];
    
    foreach ($sql->getResult() as $row) {

        $row = json_decode(json_encode($row),true);        
                        
            $dados = [
                
                'Id' => $row['IdContato'],                
                'Nome' => $row['Nome'].' '.$row['Sobrenome'],   
                'Email' => $row['Email'],
                'Nascimento' => $row['DataNascimento'],
                'Telefone' => $row['Telefone'],
                'NomeEmpresa' => $row['NomeEmpresa'],
            ]; 
        
            array_push($data['dados'], $dados);
    };    
    
    return view('buscarContato', $data);
}

function AdicionaEmpresa($nomeEmpresa) {
    $db = \Config\Database::connect();

    try {

        $sql = $db->query("SELECT * FROM Empresa WHERE Empresa.NomeEmpresa like '" . strtoupper($nomeEmpresa) . "'");
        $result = $sql->getResult();
        
        if (empty($result)) {

            $sql = "INSERT INTO empresa VALUES(0, '{$nomeEmpresa}')";
            $db->query($sql);            
        }

        return true;
    } catch (\Throwable $th) {
        die('Erro ao cadastrar empresa.');
    }
}

public function AdicionaContato($email, $nomeContato, $sobrenomeContato, $nascimento, $telefone) {
    $db = \Config\Database::connect();

    try {
        $sql = $db->query("SELECT * FROM contato WHERE contato.Email = '$email'");
        $result = $sql->getResult();
        

        if (empty($result)) {
            
            $sql = "INSERT INTO contato VALUES (0, '{$nomeContato}', '{$sobrenomeContato}', '{$nascimento}', '{$email}', '{$telefone}')";
            $db->query($sql);
        }

        return true;
    } catch (\Throwable $th) {
        die('Erro ao cadastrar contato.');
    }
}

public function AdicionaContatoEmpresa($idContato, $idEmpresa) {

    $db = \Config\Database::connect();

    $sql = $db->query("SELECT * FROM contatoempresa WHERE contatoempresa.IdContato = '{$idContato}' and contatoempresa.IdEmpresa = '{$idEmpresa}'");
    $result = $sql->getResult();

    if (!empty($result)) {
        die('Contato já cadastrado para esta empresa');
    }

    $sql = $db->query("INSERT INTO contatoempresa VALUES(0, '{$idContato}', '{$idEmpresa}')");
    
}

public function recuperaIdEmpresa($nomeEmpresa) {
    //conecta ao banco
    $db = \Config\Database::connect();

    $sql = $db->query("SELECT IdEmpresa FROM Empresa WHERE Empresa.NomeEmpresa like '" . strtoupper($nomeEmpresa) . "'");
    $row = $sql->getRow();

    return $row->IdEmpresa;
}

public function recuperaIdContato($email) {
    $db = \Config\Database::connect();

    $sql = $db->query("SELECT IdContato FROM Contato WHERE Contato.Email = '" . $email . "'");
    $row = $sql->getRow();
    
    return $row->IdContato;
}
}



