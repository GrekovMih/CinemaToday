<style>
    body{
        margin:2% 25%;
    }

</style>


<?php
/**
 * Created by PhpStorm.
 * User: MG
 * Date: 16.01.2018
 * Time: 22:56
 */


$gid = "-158697256";
$token = "aad4d3e0c1a5380213868010c57dd56f1596e336d7aa1cbe7d7455645f2cf16274d7fc88ece6391b1572b";
//$today=time();

$Month_r = array(
    "01" => "января",
    "02" => "февраля",
    "03" => "марта",
    "04" => "апреля",
    "05" => "мая",
    "06" => "июня",
    "07" => "июля",
    "08" => "августа",
    "09" => "сентября",
    "10" => "октября",
    "11" => "ноября",
    "12" => "декабря");


/*
$todayName = date("N");
$dayFirst = date("d") +  4 - $todayName ;
$daySeven = $dayFirst + 7;

*/

$date = new DateTime();
$todayName = date("N");
$next = ($todayName<4) ? 0 : 7;
$dney = $next + 4 - $todayName;
$date->modify("+$dney day");
$dayFirst = $date->format('d');
$date->modify('+6 day');
$today = strtotime("+6 day");
$daySeven = $date->format('d');
//echo $date->format('Y-m-d H:i:s');
$month=$Month_r[$date->format("m")];


$helloText="Расписание кинотеатр им. Ковтюха на $dayFirst - $daySeven $month <br> 
Стоимость билетов: 2D - 200 руб., 3D - 250 руб. <br> 
Телефон: 8 (86165) 4-04-88 справочная, бронирование мест. <br> ";

echo $helloText;

$req="https://kudago.com/public-api/v1.3/movies/?lang=&fields=title,description,body_text,director,stars,awards,trailer,poster,imdb_rating,age_restriction&expand=&order_by=&text_format=&ids=&location=&premiering_in_location=&actual_since=".$today;

$response = json_decode(file_get_contents($req));

//print_r($response);
//$response=$response->results;

/*
foreach( $response as $key => $value){
    echo "key: $key, value: $value->results->title[0]<br />";
}
*/
//echo $response->results[0]->title;
echo "<h2> Сейчас в кино трейлер: </h2>";
foreach( $response->results as $key => $value){
    echo "$value->title <br />";


}


echo "<h2> Сейчас в кино трейлер: </h2>";
foreach( $response->results as $key => $value){
    echo "$value->title <br />";
    echo "$value->trailer<br />";

}


echo "<h2> Сейчас в кино ограничение и трейлер: </h2>";
foreach( $response->results as $key => $value){
    echo "$value->title $value->age_restriction<br />";
    echo "$value->trailer<br />";

}

echo "<h2> Подробно про каждый фильм </h2>";


foreach( $response->results as $key => $value){
    echo "<h3> $value->title $value->age_restriction <br /> </h3>";
    echo "Рейтинг: $value->imdb_rating<br />";
//    echo "$value->description<br /> <br />";
    echo "$value->body_text<br />";
    echo "Трейлер: $value->trailer<br />";
//    echo "Постер: $value->poster <br />";

    $message=urlencode($value->title." \n  \n ".strip_tags($value->body_text));
    $url="https://api.vk.com/method/wall.post?owner_id=".$gid."&from_group=1&message=".$message."&access_token=".$token."&attachments=".$value->trailer;

    echo "<a href=$url> Выложить пост  </a><br />";


}




//https://oauth.vk.com/access_token


/*
$query = file_get_contents
("https://api.vk.com/method/wall.post?owner_id=".$gid."&from_group=1&message=".$message."&access_token=".$token);
$response = json_decode($query);
echo $response;
*/