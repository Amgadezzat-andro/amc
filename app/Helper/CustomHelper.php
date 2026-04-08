<?php




if (! function_exists('printAllUrl')) {
    function printAllUrl($url)
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
                $url = url("{$lng}/".$url);
            }
            return " href='{$url}'";
        }

    }

}