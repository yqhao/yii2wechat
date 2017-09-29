<?php
/**
 * Created by PhpStorm.
 * User: HowardPC
 * Date: 2017/9/28
 * Time: 18:06
 */

namespace backend\models;


use yii\base\Exception;

class Weibo
{
    public function curl($url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:54.0) Gecko/20100101 Firefox/54.0"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        }
        return $response;
    }

    public function loadPage($url,$savePath=''){

        $medias = $this->findPageMedia($this->curl($url));
        if (!empty($medias))foreach ($medias as $fileName => $src){
            if($savePath){
                $status = $this->saveFile($src,$savePath.DIRECTORY_SEPARATOR.$fileName);
            }
            echo '<a target="_blank" href="'.$src.'">'.$src.'</a> - ok</br>';
        }

    }
    public function findPagePic($response)
    {
        $medias_array = [];
        preg_match('/var \$render_data \= (\[\{.*?)<\/script>/ism',$response,$match);
        if(!empty($match) && !empty($match[1])){
            $json = str_replace('[0] || {};','',$match[1]);
            $obj = \GuzzleHttp\json_decode($json);
            if(!empty($obj)){
//                $title = $obj[0]->status->status_title;
                $medias = $obj[0]->status->pics;
                //echo  \GuzzleHttp\json_encode($json);
                //print_r($obj[0]->status);exit;
                if(!empty($medias))foreach ($medias as $k => $value){
                    $url = $value->large->url;
                    if($url){
                        //echo $url."</br>";
                        //echo "<img src='$url'/></br>";
                        $fileName = strstr($url,$value->pid);
                        $medias_array[$fileName] = $url;
                    }
                }
            }
        }

        return $medias_array;
    }
    public function findPageMedia($response)
    {
        $medias_array = [];
        preg_match('/var \$render_data \= (\[\{.*?)<\/script>/ism',$response,$match);
        if(!empty($match) && !empty($match[1])){
            $json = str_replace('[0] || {};','',$match[1]);
            $obj = \GuzzleHttp\json_decode($json);

            if(!empty($obj)){
                //var_dump($obj[0]->status);exit;
                $page_content = $obj[0]->status;
//                $title = $content->status_title;
                $url = $page_content->page_info->media_info->stream_url;
                $ary1 = explode('://',$url);
                $ary2 = explode('?',$ary1[1]);
                $num = strripos($ary2[0],'/');
                $name = substr($ary2[0],$num+1);
//                var_dump($ary1,$ary2,$name);exit;
                $medias_array[$name] = $url;
            }
        }

        return $medias_array;
    }
    public function saveFile($file_url, $save_to)
    {
        $file_content = $this->curl($file_url);
        if ($file_content) {
            $downloaded_file = fopen($save_to, 'w');
            fwrite($downloaded_file, $file_content);
            fclose($downloaded_file);
            return true;
        }
        return false;
    }
}