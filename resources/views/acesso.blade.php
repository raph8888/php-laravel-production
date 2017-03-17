@extends('layouts.master')
@section('content')

<div id="main">

    <br>
        
    <div class="login-card">
        
          {!! isset($situation) ? $situation : null !!}
          
        <h1>Acesso</h1>
        
        <h1><small><div id="data"></div></small></h1><br>
        
        <form action="http://copiadoramoc.com/public/acesso" method="post" enctype="multipart/form-data">
            
            <input type="text" name="user" placeholder="Nome" required>
            <input type="password" name="pass" placeholder="Senha" required>
            <input type="submit" name="login" class="login login-submit" value="Acessar">
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