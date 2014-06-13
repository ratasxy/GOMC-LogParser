<?php

class Parser{
    private $regEx;
    private $regExDetectBot;
    private $regExDetectMobile;
    private $regExDetectCSSorJSorImage;
    private $regExPageNumber;

    public function __construct()
    {
        $this->regEx = '/^(\S+) \S+ \S+ \[([^\]]+)\] "([A-Z]+) (\S+)[^"]*" (\d+) \d+ "[^"]*" "([^"]*)"$/m';
        $this->regExDetectBot = '/Googlebot|DotBot|Baiduspider|AhrefsBot|bingbot|msnbot-media|SEOstats|facebookexternalhit|YandexBot|RU_Bot|NerdyBot/';
        $this->regExDetectMovil = "/Android|iPhone|iPad|BlackBerry/";
        $this->regExDetectCSSorJSorImage = "/\.css|\.js|\.jpg|\.png|\.svg|\.ttf|\.eot|\.woff|\.gif|robots\.txt/i";
        $this->regExPageNumber = "/\?page=.*/i";
    }

    public function parse($txt, &$out)
    {
        return preg_match_all($this->regEx,$txt,$out,PREG_SET_ORDER);
    }

    public function isBot($userAgent)
    {
        return preg_match($this->regExDetectBot, $userAgent);
    }

    public function isMobile($userAgent)
    {
        return preg_match($this->regExDetectMobile, $userAgent);
    }

    public function isCSSorJSorImage($uri)
    {
        return preg_match($this->regExDetectCSSorJSorImage, $uri);
    }

    public function removePageNumber($txt)
    {
        return preg_replace($this->regExPageNumber, '', $txt);
    }
}