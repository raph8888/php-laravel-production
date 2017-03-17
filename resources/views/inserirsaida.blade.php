@extends('layouts.master2')
@section('content')

 
    
     <div class="login-card">
    <div id="data"></div>
    <h1>Fechamento do Caixa</h1><br>
  <form action="#" method="post" enctype="multipart/form-data">
   <input type="text" name="user1" placeholder="Nome 1" required>
   <input type="password" name="pass1" placeholder="Senha 1" required>
    <br>
     <input type="text" name="user2" placeholder="Nome 2" required>
    <input type="password" name="pass2" placeholder="Senha 2" required>
    <br>
     <input type="text" name="valorsaida" placeholder="Valor de Fechamento" required>
    <input type="submit" name="login" class="login login-submit" value="Concluir">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  </form>

</div>


<script src='http://codepen.io/assets/libs/fullpage/jquery_and_jqueryui.js'></script>
   
</div>

<script>
  NomeMes = new Array(12)
    NomeMes[0] = "1"
    NomeMes[1] = "2"
    NomeMes[2] = "3"
    NomeMes[3] = "4"
    NomeMes[4] = "5"
    NomeMes[5] = "6"
    NomeMes[6] = "7"
    NomeMes[7] = "8"
    NomeMes[8] = "9"
    NomeMes[9] = "10"
    NomeMes[10] = "11"
    NomeMes[11] = "12"
 
 var data=new Date();
 var dia=data.getDate();
  if(dia < 10) {
        dia = "0" + dia;
    }
 var mes=data.getMonth();
 var ano=data.getFullYear();
 
 data = dia + ' / ' + NomeMes[mes] + ' / ' + ano;
 
 document.getElementById("data").innerHTML = data;
 
 </script>
 
@endsection