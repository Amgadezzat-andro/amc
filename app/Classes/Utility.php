<?php

namespace App\Classes;

use App\Filament\Resources\Blog\Model\Blog;
use App\Filament\Resources\Doctor\Model\Doctor;
use App\Filament\Resources\Hospital\Model\Hospital;
use App\Filament\Resources\News\Model\News;
use App\Filament\Resources\Page\Model\Page;
use App\Filament\Resources\SpecializedCenter\Model\SpecializedCenter;
use App\Mail\BaseEmail;
use App\Models\ApiLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;



class Utility
{

    public static function sendEmailToAdmin($subject,$mailData, $emailList)
    {
        if(gettype($emailList)=="string")//if type string explode to array
        {
            $emailList = explode(',', $emailList);
            if($emailList[0]=="")
            {
                array_shift($emailList);
            }
        }

        // Email sending is temporarily disabled while local SMTP/mailpit is unavailable.
        return;

        if($emailList)
        {
            //use queue to prevent error if we have error with smtp
            if( Mail::to($emailList)->send(new BaseEmail($subject, $mailData))) //use send instead of queue to work without queue
            {
                //notify admin of error in seding email
            }
        }
    }


    function highlightWords($text, $word)
    {
        $text = preg_replace('#'. preg_quote($word) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
        return $text;
    }

    public static function printAllUrl($url)
    {
        $lng = app()->getLocale();

        if (is_string($url) && strpos($url, 'http') !== false)
        {
            return " target='blank' rel='noopener noreferrer nofollow' href='$url' ";
        }
        else if (is_string($url) && strpos($url, 'mailto:') !== false)
        {
            return " href='mailto:" . $url . "'";
        }
        else if (is_string($url) && strpos($url, "#") === 0)
        {
            return " href='$url'";
        }
        else
        {

            if($url =="" || $url== null || !$url)
            {
                $url = "javascript:void(0);";
            }
            else
            {
                $url = url("{$lng}".$url);
            }
            return " href='{$url}'";
        }

    }


    public static function getModelList($model)
    {
        $items = $model::getDb()->cache(function ($db) use($model) {
            return $model::find()
                    ->orderBy(['id' => SORT_DESC])
                    ->all();

        }, 3600);

        return ArrayHelper::map($items,"id","title");
    }

    public static function getActiveModelList($model, $key = 'id')
    {
        $items = $model::getDb()->cache(function ($db) use($model) {
            return $model::find()
                    ->andWhere(['status'=>true])
                    ->orderBy(['id' => SORT_DESC])
                    ->all();

        }, 3600);

        return ArrayHelper::map($items, $key, "title");
    }


    public static function sanitize(array $input, array $fields = array(), $utf8_encode = true)
    {
        $magic_quotes = false;

        if (empty($fields)) {
            $fields = array_keys($input);
        }

        $return = array();

        foreach ($fields as $field) {
            if (!isset($input[$field])) {
                continue;
            } else {
                $value = $input[$field];
                if (is_array($value)) {
                    $value = null;
                }
                if (is_string($value)) {
                    if ($magic_quotes === true) {
                        $value = stripslashes($value);
                    }

                    if (strpos($value, "\r") !== false) {
                        $value = trim($value);
                    }

                    if (function_exists('iconv') && function_exists('mb_detect_encoding') && $utf8_encode) {
                        $current_encoding = mb_detect_encoding($value);

                        if ($current_encoding != 'UTF-8' && $current_encoding != 'UTF-16') {
                            $value = iconv($current_encoding, 'UTF-8', $value);
                        }
                    }


                    $value = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $value = strip_tags($value);

                    //$value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES); // not supported in php 8

                    //TODO: in 7.2 this return null because it not exist
                    $value = filter_var($value, FILTER_SANITIZE_ADD_SLASHES);
                    //$value = filter_var($value, FILTER_SANITIZE_MAGIC_QUOTES);
                }

                $return[$field] = $value;
            }
        }

        return $return;
    }

    public static function newSearchIncludingFilters($availableAttributeNamesAtFront, $any)
    {

        $params = null;
        $searchparams = $any;

        if ($searchparams) {
            $searchparams = explode("/", $searchparams);
            $searchparams = Utility::sanitize($searchparams);
            $params = [];
            for ($key = 0; $key < count($searchparams); $key++) {
                if (in_array($searchparams[$key], array_keys($availableAttributeNamesAtFront))) {
                    $valueKey = $key + 1;
                    if (isset($searchparams[$valueKey])) {
                        $params[$availableAttributeNamesAtFront[$searchparams[$key]]] = $searchparams[$valueKey];
                        ++$key;
                    }
                }
            }
        }

        //var_dump($params);exit;

        return $params;
    }



    public static function getSearchModels()
    {
        return
        [


            [
                "model" => Page::class,
                "title" => __("site.PAGE"),
                "extra_search"=>[],
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image_id",
                "is_slug_url"=>true,
                "main_item_url"=>null,
                "item_url"=>"page-view",
                "pagination_name" => "page",
            ],
            [
                "model" => News::class,
                "title" => __("site.NEWS"),
                "extra_search"=>[],
                "item_title"=> "title",
                "item_brief"=>"brief",
                "item_img"=>"image_id",
                "is_slug_url"=>true,
                "main_item_url"=>null,
                "item_url"=>"news-view",
                "pagination_name" => "news",
            ],

        ];
    }



    public static function addApiLog($url, $fields, $currentUser = null)
    {
        // Log to file (change path as needed)
        $apiLogFile = storage_path('logs/api.log');
        $logData = [
            self::getClientIpAddress(),
            now()->format('Y-d-m h:i:s A'),
            $url,
            print_r($fields, true)
        ];
        File::append($apiLogFile, implode("\n", $logData) . "\n");

        // Save to database
        $log = new ApiLog();
        $log->ip_address = self::getClientIpAddress();
        $log->end_point = $url;
        $log->parameters = json_encode($fields); // Prefer JSON over print_r
        if ($currentUser) {
            $log->user_id = $currentUser->id;
            $log->auth_key = $currentUser->auth_key;
        }
        $log->save();
    }

    private static function getClientIpAddress()
    {
        return request()->ip();
    }


}
