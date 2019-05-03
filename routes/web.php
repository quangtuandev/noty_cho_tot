<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $client = new GuzzleHttp\Client();
    $res = $client->get('gateway.chotot.com/v1/public/ad-listing?region_v2=3017&cg=2020&w=1&limit=20&st=s,k');
    $arr = json_decode( $res->getBody());
    $data = $arr->ads;
    foreach ($data as $value) {
        $title = str_slug($value->area_name, "-");
        $id = $value->list_id;
        $url = "https://xe.chotot.com/$title/mua-ban-xe-may/$id.htm";
        DB::table('news')->insert([
            'list_id'      => $value->list_id,
            'slug'         => $url,
            'subject'      => $value->subject,
            'price_string' => $value->price_string,
            'area_name'    => $value->area_name
        ]);
        echo $url;
    }
});
