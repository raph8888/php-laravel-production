@extends('layouts.master2')
@section('content')

<br>
<br>
<br>

<div class='text-center'>

<form action="/public/adicionar" method="post" enctype="multipart/form-data">
            
            <input type="text" name="newuser" placeholder="Novo Acesso" required>
            
            <br><br>
            
            <input type="text" name="newpass" placeholder="Senha" required>
            
            <br><br>
            
            <input type="checkbox" name="newadmin" value='1'>Permitir acesso às tabelas
            
            <br><br>
            
            <input type="submit" name="login" class="login login-submit" value="Adicionar">
            
            <br><br>
            
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
        </form>
        
        </div>
        
@endsection