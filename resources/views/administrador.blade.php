@extends('layouts.master2')
@section('content')

    <div class="container">
        
        <h2 align="center">Controle de Caixa Online</h2> <br>
        
        <div class="row">
            <div class="col-md-6">
                
                <?php $calendar->show(); ?>
                
            <br>
            <br>
            
            </div>
            
            <div class="col-md-6">
                
                <div id="yourdiv" align="center">
                    <br>
                    <h3>Clique no dia que deseja consultar.</h3>
                    <br>
                 </div>
                
                <br>
                <br>
                
                </div>
                
        </div>
    </div>
    
    <hr>
    
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
                <h2>Dados de Acesso</h2>
                
                 <table border="1" style="width:100%">
                      <thead align="center" style="display: table-header-group">
                      <tr>
                          <th class="text-center">Nome</th>
                         <th class="text-center">Senha</th>
                         <th class="text-center">Acessa Tabelas</th>
                         <th class="text-center">Excluir</th>
                      </tr>
                      </thead>
                    <tbody>
                
                <?php foreach ($acessos as $acesso) { ?>
                    
                <tr class='item_row'>
                
                <td> <?php echo $acesso->Nome ?> </td>
                <td> <?php echo $acesso->Senha ?> </td>   
                <td align="center">
                	
                	<?php if($acesso->UserAdmin == 1){echo 'o';} else {echo '-';} ?> </td>   
                
                
                <td align='middle'>
                <a href='http://copiadoramoc.com/public/excluir/<?php echo $acesso->Nome ?>' title='Excluir <?php echo $acesso->Nome ?> da Tabela de Acesso' id='<?php echo $acesso->Nome ?>' class='delete' style='color: red'>x</a> 
                </td>
                </tr>
                
                <?php } ?>
                
                </tbody>
                </table>
                
                <br>
                <a href="http://copiadoramoc.com/public/adicionar" title="Adicionar Acessos"><button>Adicionar Acesso (+)</button></a>
                
            </div>
            
            <div class="col-md-8">
                
                <h2>Últimos 10 dias</h2>
                
                <table border="1" style="width:100%">
                      <thead align="left" style="display: table-header-group">
                      <tr>
                          <th>Data</th>
                         <th><b><p style="color: green;">Abertura</p></b></th>
                         <th>Valor</th>
                         <th>Horário</th>
                         <th><b><p style="color: blue;">Fechamento</p></b></th>
                         <th>Valor</th>
                         <th>Horário</th>
                      </tr>
                      </thead>
                    <tbody>
                
                <?php
                foreach ($controles as $controle) {
                        
                        
                        echo "<tr class='item_row'>";
                        
                        echo "<td><b>" .$controle->Data. "</b></td> 
                       <td>".$controle->Entrada1. " / "
                            .$controle->Entrada2. " </td> 
                       <td><b><p style='color: green;'>R$".$controle->ValorEntrada. ",00</p></b></td>
                       <td>".$controle->timeEntrada. "</td>  
                       <td>".$controle->Saida1. "/
                           ".$controle->Saida2. " </td> 
                       <td><b><p style='color: blue;'>R$".$controle->ValorSaida. ",00</p></b></td>
                       <td>".$controle->timeSaida. "</td></tr>"; }
    
                 ?>
                 
</tbody>
</table>
                 
            </div>
            
        </div>
    </div>
    
    <br>
    
    <hr>
    
    <div class="container">
        <div class="row">
            <div class="col-md-4">
    
 <a href='http://copiadoramoc.com/public/alldays'><p>  Lista completa de Abertura e Fechamento do Caixa </p> </a>
   
  <a href="http://copiadoramoc.com/public/allcosts"><p>   Lista completa de Custos </p> </a>
       </div>
            
        </div>
    </div>
    <hr>



        
                    
<script>
$( "li" ).click(function() {
    var date = $(this).attr("id");
    $.ajax({
        url : '{{("http://copiadoramoc.com/public/administrador/check")}}',
        type: "POST",
        data: {name : date,
            '_token': '{!! csrf_token() !!}'},
        success:function (result) {
            $("#yourdiv").html(result);
            }
            });
            });
</script>        


<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
    $("a.delete").click(function(e){
    	var currentId = $(this).attr('id');
        if(!confirm('Excluir '+ currentId + ' da lista de Acesso?')){
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>
    

@endsection