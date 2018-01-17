<?php
/**
 * Created by PhpStorm.
 * User: MG
 * Date: 16.01.2018
 * Time: 22:56
 */
$today=time();

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

$month=$Month_r[date("m")];
$todayName = date("N");
$dayFirst = date("d") +  4 - $todayName ;
$daySeven = $dayFirst + 7;

$helloText="Расписание кинотеатр им. Ковтюха на $dayFirst - $daySeven $month <br> 
Стоимость билетов: 2D - 200 руб., 3D - 250 руб. <br> 
Телефон: 8 (86165) 4-04-88 справочная, бронирование мест. <br> ";

echo $helloText;

$req="https://kudago.com/public-api/v1.3/movies/?lang=&fields=title,description,body_text,director,stars,awards,trailer,poster,imdb_rating&expand=&order_by=&text_format=&ids=&location=&premiering_in_location=&actual_since=".$today;

$response = json_decode(file_get_contents($req));

//print_r($response);
//$response=$response->results;

/*
foreach( $response as $key => $value){
    echo "key: $key, value: $value->results->title[0]<br />";
}
*/
//echo $response->results[0]->title;
echo "<h2> Сейчас в кино </h2>";
foreach( $response->results as $key => $value){
    echo "$value->title<br />";
    echo "Трейлер: $value->trailer<br />";

}

echo "<h2> Подробно про каждый фильм </h2>";


foreach( $response->results as $key => $value){
    echo "<h3> $value->title <br /> </h3>";
    echo "Рейтинг: $value->imdb_rating<br />";
//    echo "$value->description<br /> <br />";
    echo "$value->body_text<br />";
    echo "Трейлер: $value->trailer<br />";
//    echo "Постер: $value->poster <br />";

}