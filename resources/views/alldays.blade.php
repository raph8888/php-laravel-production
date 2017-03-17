@extends('layouts.master2')
@section('content')

    <div class="container">
        
        <h2 align="center">Abertura e Fechamento do Caixa</h2> <br>
        
        <div class="row">
            <div class="col-md-12">
                
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
            <br>
            
            
            <div class="col-md-6">
                
@endsection