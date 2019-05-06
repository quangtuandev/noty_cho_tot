<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use App\Jobs\SendEmail;
use DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
class NewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->get('gateway.chotot.com/v1/public/ad-listing?region_v2=3016&region_v2=3017&cg=2020&cg=2010&w=1&limit=2&st=s,k');
        $arr = json_decode( $res->getBody());
        $data = $arr->ads;
        foreach ($data as $value) {
            $title = str_slug($value->area_name, "-");
            $id = $value->list_id;
            $url = "https://xe.chotot.com/$id.htm";
            DB::table('news')->insert([
                'list_id'      => $id,
                'slug'         => $url,
                'subject'      => $value->subject,
                'price_string' => $value->price_string,
                'area_name'    => $value->area_name
            ]);
            $isNoty = DB::table('news')
                        ->select('noty')
                        ->where('list_id',$id)->first();
                        // dd($isNoty);
            if(!$isNoty->noty) {
                // Send email noty to user
                $info = [
                    'email' => 'quangtuandev@gmail.com',
                    // 'email' => 'ngoisaobayveoveo2@gmail.com',
                    'subject' => 'Thông Báo Từ Chợ Tốt',
                ];

                $fields = [
                    'url'   => $url,
                    'value' => $value,
                ];

                dispatch(new SendEmail($info, 'email.sendNotify', $fields));
                echo 'done !';
                //edit noty
                DB::table('news')
                    ->where('list_id',$id)
                    ->update(['noty' => true]);
            }
        }
    }
}
