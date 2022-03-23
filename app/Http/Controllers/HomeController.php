<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dictCo($word) {
        if (cache()->has('dictCo_'.$word)) cache('dictCo_'.$word);
        $client = new Client();
        try {
            $url = 'http://dict-co.iciba.com/api/dictionary.php?key=5EC1DA030C26869BF05F763CB2BF3185&type=json&w=';
            $response = $client->request('GET',$url.$word);
            $result = json_decode($response->getBody()->getContents(), true);
//            dd($result['symbols'][0]['parts'][0]['means'][0]);
            cache(['dictCo_'.$word=>$result],36000000);
            return $result;
        } catch (\Exception $e) {
            Log::error('dictCo Something went wrong: ' . $e);
            return $e;
        }
    }

    public function pixabayImgApi()
    {
        $imgs = $this->pixabayImgSearch(request()->all());
        return $imgs;
        // var_dump(request()->all());
        // foreach ($imgs as $k => $v) {
        //     echo '<img src="'.$v.'"/>';
        // }
    }

    public function pixabayImgSearch($param)
    {
        $param['key'] = '13535467-451358051a5f7c0c1d1f0ca56';
        $param['lang'] = $this->arrGet($param, 'lang', 'en');
        $param['image_type'] = $this->arrGet($param, 'image_type', 'photo');// "all", "photo", "illustration", "vector"
        $param['orientation'] = $this->arrGet($param, 'orientation', 'all');// "all", "horizontal", "vertical"
        $param['category'] = $this->arrGet($param, 'category', '');//fashion, nature, backgrounds, science, education, people, feelings, religion, health, places, animals, industry, food, computer, sports, transportation, travel, buildings, business, music
        $param['min_width'] = $this->arrGet($param, 'min_width', '480');
        $param['min_height'] = $this->arrGet($param, 'min_height', '860');
        $param['colors'] = $this->arrGet($param, 'lang', '');//"grayscale", "transparent", "red", "orange", "yellow", "green", "turquoise", "blue", "lilac", "pink", "white", "gray", "black", "brown"
        $param['editors_choice'] = $this->arrGet($param, 'editors_choice', 'false');
        $param['safesearch'] = $this->arrGet($param, 'safesearch', 'true');
        $param['order'] = $this->arrGet($param, 'order', 'popular');//"popular", "latest"
        $param['page'] = $this->arrGet($param, 'start', '1');
        $param['per_page'] = $this->arrGet($param, 'per_page', '10');

        // var_dump($param);
//        $param['callback'] = $this->arrGet($param, 'callback', '');
//        $param['pretty'] = $this->arrGet($param, 'pretty', 'false');

        $param = implode('&', array_map(
            function ($v, $k) { return sprintf("%s=%s", $k, $v); },
            $param, array_keys($param)
        ));

        $cacheKey = 'pixabayImgSearch'.urlencode($param);
        if (cache()->has($cacheKey)) return cache($cacheKey);//&&cache($cacheKey)

        $endpoint = 'https://pixabay.com/api/';

        $client = new Client();
        try {
            $response = $client->request('GET', $endpoint . "?" . $param);
            $result = json_decode($response->getBody()->getContents(), true);
            $imgs = Arr::pluck($result['hits'],'webformatURL');
            // dd($endpoint . "?" . $param,$result,cache($cacheKey));
            cache([$cacheKey=>$imgs],36000000);
            // dd($imgs);
            return $imgs;
        } catch (\Exception $e) {
            return response('pixabayImgSearch Something went wrong: ' . $e->getMessage(), 500);
        }
    }

    function arrGet($arr, $key, $default = null)
    {
        $isDefault = false;
        if (empty($arr) || empty($key) && 0 !== $key) {
            $isDefault = true;
        } else {
            if (!isset($arr[$key])) {
                $isDefault = true;
            }
        }
        if ($isDefault) {
            if ($default instanceof Exception) {
                throw $default;
            } else {
                return $default;
            }
        }

        return $arr[$key];
    }
}
