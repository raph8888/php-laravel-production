<?php
namespace App\Http\Controllers;

use DB;
use App\Models\Acessos;
use App\Models\ControleCaixa;
use App\Models\Custos;
use App\Models\Calendar;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Clickatell;
use App\Clickatell\TransportInterface;

use Session;

class CopiadoraController extends Controller
{

    /**
     * Returns Calendar, all Users and last 5 days rows of ControleCaixa table.
     *
     * @return Response
     */
    public function administrador(Request $request)
    {
        $admin = $this->findadmin();

        if (isset($admin) && $admin === 1) {

            //The administrador view


            //Get all users
            $acessos = Acessos::all();

            //Get last 5 rows.
            $controles = ControleCaixa::orderBy('IDda', 'desc')->take(10)->get();

            //Create calendar
            $calendar = new Calendar();
            return view('administrador',
                ['acessos' => $acessos,
                    'controles' => $controles,
                    'calendar' => $calendar]);

        } else {

            return redirect('/status');

        }

    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        return view('copiadora');

    }

    /**
     * Show contact view.
     *
     * @return Response
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Show address view.
     *
     * @return Response
     */
    public function address()
    {

        return view('address');
    }

    /**
     * Show acesso view.
     *
     * @return Response
     */
    public function acesso()
    {

        if (isset($_POST['user']) && isset($_POST['pass'])) {

            $myusername = $_REQUEST['user'];
            $mypassword = $_REQUEST['pass'];

            $users = DB::select("SELECT * FROM Acesso WHERE Nome='$myusername' and Senha='$mypassword'");

            if (count($users) === 1) {

                Session::put('user', $myusername);

                $checkdate = DB::select('SELECT * FROM ControleCaixa WHERE Data="' . $this->diadehoje() . '"');

                if (count($checkdate) === 1) {

                    return $this->status();

                } else {

                    //!! Muito Importante -- Inserting date into database !!//

                    $checkdate = DB::select('INSERT INTO ControleCaixa (Data)
                VALUES ("' . $this->diadehoje() . '")');

                    return $this->status();
                }

            } else {

                return view('acesso', ['situation' => 'Dados de Acesso incorretos.']);
            }
        } else {

            return view('acesso');
        }
    }


    /**
     * Show day status.
     *
     * @return Response
     */
    public function status()
    {
        if (!Session::has('user')) {

            return view('acesso', ['situation' => 'No Session Values.']);

        } else {

            $hr = date(" H ");
            if ($hr >= 12 && $hr < 18) {
                $resp = "Boa tarde";

            } else if ($hr >= 0 && $hr < 12) {
                $resp = "Bom dia";

            } else {
                $resp = "Boa noite";
            }


            $checkdate = DB::select('SELECT * FROM ControleCaixa WHERE Data="' . $this->diadehoje() . '" AND StatusEntrada=0 AND StatusSaida=0');

            if (count($checkdate) === 1) {

                $status = '
        <table align="center">
        <tr>
        <td>
            <div class="abertura">
                <p style="color: #ff0000">Abertura do Caixa Pendente<br>
                    <a href="http://copiadoramoc.com/public/inserirentrada">Executar Abertura</a></p>
            </div>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>
            <div class="fechamento">
                <p style="color: #ff0000">Fechamento do Caixa Pendente<br>
                    <a href="http://copiadoramoc.com/public/inserirsaida">Executar Fechamento</a></p>
            </div>
        </td>
        </tr>
        </table> ';

            } else {

                $checkdate = DB::select('SELECT * FROM ControleCaixa WHERE Data="' . $this->diadehoje() . '" AND StatusEntrada=1 AND StatusSaida=0');

                if (count($checkdate) === 1) {

                    $status = '
            
        <table align="center">
        <tr>
        <td>
            <div class="abertura">
                <p style="color: #33CC33">Abertura do Caixa Executada<br>Obrigado</p>
            </div>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>
            <div class="fechamento">
                <p style="color: #ff0000">Fechamento do Caixa Pendente<br>
                    <a href="http://copiadoramoc.com/public/inserirsaida">Executar Fechamento</a></p>
            </div>
        </td>
        </tr>
        </table> ';


                } else {

                    $checkdate = DB::select('SELECT * FROM ControleCaixa WHERE Data="' . $this->diadehoje() . '" AND StatusEntrada=1 AND StatusSaida=1');

                    if (count($checkdate) === 1) {

                        $status = '
             
             <table align="center">
        <tr>
        <td>
            <div class="abertura">
                <p style="color: #33CC33">Abertura do Caixa Executada<br>Obrigado</p>
            </div>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>
            <div class="fechamento">
                <p style="color: #33CC33">Fechamento do Caixa Executado<br>Obrigado</p>
            </div>
        </td>
        </tr>
        </table> ';


                    } else {

                        $checkdate = DB::select('SELECT * FROM ControleCaixa WHERE Data="' . $this->diadehoje() . '" AND StatusEntrada=0 AND StatusSaida=1');

                        if (count($checkdate) === 1) {

                            $status = '
        
        <table align="center">
        <tr>
        <td>
            <div class="abertura">
                <p style="color: #ff0000">Abertura do Caixa Bloqueada<br></p>
            </div>
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>
            <div class="fechamento">
                <p style="color: #33CC33">Fechamento do Caixa Executado<br>Obrigado</p>
            </div>
        </td>
        </tr>
        </table> ';

                        }
                    }
                }
            }

            ////Display list of costs
            $custos = Custos::where('Date', '=', $this->diadehoje())->get();

            $myusername = Session::get('user');

            $admin = $this->findadmin();

            if ($admin === 1) {

                $greeting = '<a href="http://copiadoramoc.com/public/administrador">Clique aqui para Analisar Tabelas</a>';
                return view('status',

                    ['data' => $this->diadehoje(),
                        'situation' => $resp . ' ' . $myusername . ',',
                        'greeting' => $greeting,
                        'status' => $status,
                        'custos' => $custos]);

            } else {

                $greeting = "";

                return view('status',
                    ['data' => $this->diadehoje(),
                        'situation' => $resp . ' ' . $myusername . ',',
                        'greeting' => $greeting,
                        'status' => $status,
                        'custos' => $custos]);


            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function inserirentrada()
    {

        $checkdate = DB::select('SELECT * FROM ControleCaixa WHERE Data="' . $this->diadehoje() . '" AND StatusEntrada=0');

        if (count($checkdate) === 1) {
            date_default_timezone_set("Brazil/East");
            if (isset($_POST['user1']) && isset($_POST['pass1']) && isset($_POST['valorentrada'])) {
                $user1 = $_REQUEST['user1'];
                $pass1 = $_REQUEST['pass1'];
                $user2 = $_REQUEST['user2'];
                $pass2 = $_REQUEST['pass2'];
                $valorentrada = $_REQUEST['valorentrada'];
                $horas = date("h:i:sa");

                $sql = DB::select('SELECT * FROM Acesso WHERE Nome="' . $user1 . '" AND Senha="' . $pass1 . '"');

                if (count($sql) === 1) {

                    $sql = DB::select('SELECT * FROM Acesso WHERE Nome="' . $user2 . '" AND Senha="' . $pass2 . '"');

                    if (count($sql) === 1) {
                        $sql = DB::select('UPDATE ControleCaixa SET Entrada1="' . $user1 . '", Entrada2="' . $user2 . '", ValorEntrada="' . $valorentrada . '", timeEntrada="' . $horas . '", StatusEntrada = "1" WHERE Data ="' . $this->diadehoje() . '"');

                        $to = "[\"+5538991926473\"]";

                        $message = "O Caixa foi aberto hoje as " . $horas . " por " . $user1 . " e " . $user2 . " Valor do Caixa no momento de abertura: R$ " . $valorentrada;

                        $authToken = "4ZnXsl.LcQrDl4ZHWBt6_J1KLqNZVV7Tfg9KK25nd1EYaQ7SPP2mmLkODKhzJ1S";


                        $ch = curl_init();


                        curl_setopt($ch, CURLOPT_URL, "https://api.clickatell.com/rest/message");

                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                        curl_setopt($ch, CURLOPT_POST, 1);

                        curl_setopt($ch, CURLOPT_VERBOSE, 1);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"text\":\"$message\",\"to\":$to}");

                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

                            "X-Version: 1",

                            "Content-Type: application/json",

                            "Accept: application/json",

                            "Authorization: Bearer $authToken"

                        ));

                        $result = curl_exec($ch);

//                        if ($result === false) {
//                            $lastError = curl_error($ch);
//                        }
//
//                        $curlInfo = curl_getinfo($ch);

                        curl_close($ch);

                        return redirect('/status');

                    } else {

                        echo "Nome2 ou Senha2 de Acesso Incorretos.";
                        return view('inserirentrada');
                    }
                } else {

                    echo "Nome1 ou Senha1 de Acesso Incorretos.";
                    return view('inserirentrada');
                }


            } else {
                return view('inserirentrada');
            }

        } else {

            $mensagem = "O Caixa ja foi aberto hoje. Até a próxima!";

            return view('errors',
                ['mensagem' => $mensagem]);

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function inserirsaida()
    {

        $checkdate = DB::select('SELECT * FROM ControleCaixa WHERE Data="' . $this->diadehoje() . '" AND StatusSaida=0');

        if (count($checkdate) === 1) {
            date_default_timezone_set("Brazil/East");
            if (isset($_POST['user1']) && isset($_POST['pass1']) && isset($_POST['valorsaida'])) {
                $user1 = $_REQUEST['user1'];
                $pass1 = $_REQUEST['pass1'];
                $user2 = $_REQUEST['user2'];
                $pass2 = $_REQUEST['pass2'];
                $valorsaida = $_REQUEST['valorsaida'];
                $horas = date("h:i:sa");

                $sql = DB::select('SELECT * FROM Acesso WHERE Nome="' . $user1 . '" AND Senha="' . $pass1 . '"');

                if (count($sql) === 1) {

                    $sql = DB::select('SELECT * FROM Acesso WHERE Nome="' . $user2 . '" AND Senha="' . $pass2 . '"');

                    if (count($sql) === 1) {
                        $sql = DB::select('UPDATE ControleCaixa SET Saida1="' . $user1 . '", Saida2="' . $user2 . '", ValorSaida="' . $valorsaida . '", timeSaida="' . $horas . '", StatusSaida = "1" WHERE Data ="' . $this->diadehoje() . '"');

                        $to = "[\"+5538991926473\"]";

                        $message = "O Caixa foi fechado hoje as " . $horas . " por " . $user1 . " e " . $user2 . " Valor do Caixa no momento de fechamento: R$ " . $valorsaida;

                        $authToken = "4ZnXsl.LcQrDl4ZHWBt6_J1KLqNZVV7Tfg9KK25nd1EYaQ7SPP2mmLkODKhzJ1S";


                        $ch = curl_init();


                        curl_setopt($ch, CURLOPT_URL, "https://api.clickatell.com/rest/message");

                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                        curl_setopt($ch, CURLOPT_POST, 1);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"text\":\"$message\",\"to\":$to}");

                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(

                            "X-Version: 1",

                            "Content-Type: application/json",

                            "Accept: application/json",

                            "Authorization: Bearer $authToken"

                        ));

                        $result = curl_exec($ch);

                        return redirect('/status');
                    } else {

                        echo "Nome2 ou Senha2 de Acesso Incorretos.";
                        return view('inserirsaida');
                    }
                } else {

                    echo "Nome1 ou Senha1 de Acesso Incorretos.";
                    return view('inserirsaida');
                }

            } else {
                return view('inserirsaida');
            }
        } else {

            $mensagem = "O Caixa ja foi fechado hoje. Até a próxima!";

            return view('errors',
                ['mensagem' => $mensagem]);


        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function viewday()
    {
        if (isset($_POST['name'])) {

            $str = $_POST['name'];

            //$id = "li-19-10-2015";

            $dia = substr($str, 3, 2);  // returns "19"
            $mes = substr($str, 6, 2);  // returns "10"
            $ano = substr($str, 9, 4);  // returns "10"
            $dataid = $dia . "/" . $mes . "/" . $ano;

            $sql = DB::select('SELECT * FROM ControleCaixa WHERE Data="' . $dataid . '"');

            if (count($sql) === 1) {


                $controle = ControleCaixa::where('Data', '' . $dataid . '')->first();

                //This here returns an integer.
                $diatras = ControleCaixa::where('IDda', '<', $controle->IDda)->max('IDda');

                $yesterday = ControleCaixa::where('IDda', '' . $diatras . '')->first();


                $result =

                    "<h3 align='center'>" . $controle->Data . "</h3>
      
<table border='1' style='width:100%'>
      
      <thead align='left' style='display: table-header-group'>
      <tr>
      <th style='width:40%'>Abertura</th>
      <th style='width:30%'>Valor</th>
      <th style='width:30%'>Horário</th>
      </tr>
      </thead>
      
      <tbody>
      <td>" . $controle->Entrada1 . " / " . $controle->Entrada2 . "</td> 
      <td><p>R$" . $controle->ValorEntrada . ",00*</p></td>
      <td>" . $controle->timeEntrada . "</td>
      </tbody>
</table>  
<br>
<table border='1' style='width:100%'>
    <thead align='left' style='display: table-header-group'>
    <tr>
    <th style='width:40%'>Fechamento</th>
    <th style='width:30%'>Valor</th>
    <th style='width:30%'>Horário</th>
    </tr>
    </thead>
    
    <tbody>
    <td>" . $controle->Saida1 . " / " . $controle->Saida2 . " </td> 
    <td><p>R$" . $controle->ValorSaida . ",00</p></td>
    <td>" . $controle->timeSaida . "</td></tr> </tbody>
</table>
<br><br>
<p>*Abertura do dia deve ser igual ao Fechamento do dia anterior </p>
<table border='1' style='width:100%'>
      
      <thead align='left' style='display: table-header-group'>
      <tr>
      <th style='width:40%'>Fechamento do dia anterior</th>
      <th style='width:30%'>Abertura do dia</th>
      <th style='width:30%'>Diferença</th>
      </tr>
      </thead>
      
      <tbody>
      
      
       <td>R$ " . $yesterday->ValorSaida . ",00</td> 
      <td><p>R$ " . $controle->ValorEntrada . ",00</p></td>
      <td style='color:red'>R$ " . abs($controle->ValorEntrada - $yesterday->ValorSaida) . ",00</td>
      </tbody>
</table>";

                return $result;

            } else {

                $result = "<h3 align='center'>" . $dataid . "</h3>
                <br>
                <p>Não há dados para esta data. Tente outra.</p>";

                return $result;
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (isset($_POST['newuser']) && isset($_POST['newpass'])) {

            $newuser = $_REQUEST['newuser'];
            $newpass = $_REQUEST['newpass'];


            $user = new Acessos;

            $user->Nome = $newuser;

            $user->Senha = $newpass;

            if (isset($_POST['newadmin'])) {

                $newadmin = $_REQUEST['newadmin'];

                $user->UserAdmin = $newadmin;
            }

            $user->save();

            $resultado = "Novo acesso criado com sucesso";

            return redirect('/administrador');
        } else {

            return view('adduser');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($name)
    {
        return view('hello', array('name' => $name));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($name)
    {
        return view('edituser', array('name' => $name));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($name)
    {
        $controles = Acessos::where('Nome', $name)->take(1)->delete();

        return redirect('/administrador');

    }

    public function errors(Request $request, $mensagem = "Nao ha mensagens")
    {

        Session::forget('user');

        $data = $request->session()->all();

        $pathname = $request->path();
        $urlname = $request->url();

        if ($request->isMethod('post')) {
            echo $name;

        } else {
            echo "<hr>";
        }
        return view('errors', [

            'mensagem' => $mensagem,
            'pathname' => $pathname,
            'urlname' => $urlname,
            'data' => $data

        ]);

    }

    public function diadehoje()
    {

        $mes = date('M');
        $dia = date('d');
        $ano = date('Y');

        $mes_extenso = array(
            'Jan' => '01',
            'Feb' => '02',
            'Mar' => '03',
            'Apr' => '04',
            'May' => '05',
            'Jun' => '06',
            'Jul' => '07',
            'Aug' => '08',
            'Sep' => '09',
            'Oct' => '10',
            'Nov' => '11',
            'Dec' => '12'
        );

        $data = $dia . '/' . $mes_extenso["$mes"] . '/' . $ano;

        return $data;
    }

    public function findadmin()
    {
        $myusername = Session::get('user');
        $sqls = Acessos::where('Nome', '=', $myusername)->take(1)->get();
        foreach ($sqls as $sql) {
            $admin = $sql->UserAdmin;
        }

        if (isset($admin)) {

            return $admin;

        } else {

            $admin = null;
            return $admin;

        }


    }

    //Adicionar Custos

    public function custos()
    {

        if (!empty($_POST['custo']) && !empty($_POST['value'])) {

            $data = $this->diadehoje();
            $newcost = $_REQUEST['custo'];
            $newvalue = $_REQUEST['value'];
            $user = new Custos;

            $user->Date = $data;

            $user->Description = $newcost;

            $user->Value = $newvalue;

            $user->save();
        } else {

            $resultado = "Nenhum valor de custo inserido.";
            return $resultado;
        }
    }

    //Clear Sessions

    public function sair()
    {

        Session::flush();
        return view('copiadora');

    }

    public function allcosts()
    {

        $custos = Custos::orderBy('id', 'desc')->get();
        return view('allcosts',
            ['custos' => $custos]);


    }

    public function alldays()
    {

        $controles = ControleCaixa::orderBy('IDda', 'desc')->get();
        return view('alldays',
            ['controles' => $controles]);

    }

}
