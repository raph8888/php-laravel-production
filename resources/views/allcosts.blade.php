@extends('layouts.master2')
@section('content')

    <div class="container">
        
        <div class="row">
            <div class="col-md-12">
                
                <h3>Despesas diarias</h3>
                
                 <table border="1" style="width:100%">
                      <thead align="left" style="display: table-header-group">
                      <tr>
                          <th>Data</th>
                          <th>Descrição</th>
                         <th>Valor</th>
                      </tr>
                      </thead>
                    <tbody>
                
                <?php
                foreach ($custos as $custo) {
                    
                echo "<tr class='item_row'>";
                
                echo "<td> ".$custo->Date." </td>
                <td> ".$custo->Description." </td>
                <td><p>R$ ".$custo->Value." </p></td>"; }
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