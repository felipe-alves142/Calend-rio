<?php
// pega o fuso
date_default_timezone_set('Brazil/East');
//Pega uma prévia e proximo mês
if(isset($_GET['ym'])){
    $ym = $_GET['ym'];
}else{
    // Esse mês
    $ym = date('Y-m');
}


//checa o formato
$timestamp = strtotime($ym.'-01');
if($timestamp === false){
    $ym = date('Y-m');
    $timestamp = strtotime($ym,'-01');
}
//Today
$today = date ('Y-m-j',time());
// para o h3 
$html_title = date('Y / m', $timestamp);
//cria uma prévia e novo mes lin mktime(hour,minute,second, day. month, year)
$prev = date("Y-m", mktime(0,0,0,date('m' , $timestamp) -1,1,date('Y', $timestamp)));
$next = date('Y-m', mktime(0,0,0, date('m' , $timestamp) + 1,1, date('Y', $timestamp)));
//Numero de dias
$day_count = date('t', $timestamp);
$str = date('w', mktime(0,0,0,date('m',$timestamp),1,date('Y',$timestamp)));

//Cria o calendario
$weeks = array();
$week = '';
//Adiciona uma celula vazia

$week .= str_repeat('<td></td>',$str);
for($day = 1;$day <= $day_count;$day++, $str++){
    $date = $ym . '-'.$day;
    if($today == $date){
        $week .= '<td class="today">'. $day;

    }else{
        $week .= '<td>' . $day;
    }
    $week .= '</td>';


    if($str % 7 == 6 || $day == $day_count){
        if($day == $day_count){
            $week .= str_repeat('<td></td>', 6- ($str % 7));
        }
        $weeks[] = '<tr>' . $week . '</tr>';
        //Prepara para nova semana
        $week = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PHP Calendar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <style>
        .container {
            font-family: 'Noto Sans', sans-serif;
            margin-top: 80px;
        }
        h3 {
            margin-bottom: 30px;
        }
        th {
            height: 30px;
            text-align: center;
        }
        td {
            height: 100px;
        }
        .today {
            background: orange;
        }
        th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                 <th>S</th>
                <th>T</th>
                <th>Q</th>
                <th>Qu</th>
                <th>Sex</th>
                <th>Sab</th>
                <th>Dom</th>
                
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>
</body>
</html>