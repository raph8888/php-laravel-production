@extends('layouts.master2')
@section('content')

 <div class="text-center">
        
    
<?php echo $mensagem; ?>

<?php if (isset($pathname) || isset($urlname)) {
    
    echo "<hr>";
    echo "path name: " .$pathname;
    echo "<hr>";
    echo "url name: " .$urlname;
     echo "<hr>";
}
?>

// <?php if (isset($value) || isset($data)) {
//     
    // echo "<hr>";
    // echo "path name: " .$value;
    // echo "<hr>";
    // echo "url name: " .$data;
     // echo "<hr>";
}
// 
// ?>

</div>

 
@endsection