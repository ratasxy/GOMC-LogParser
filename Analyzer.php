<?php

include("geoiploc.php");

class Analyzer
{
    /** @var Parser */
    private $parser;

    public function __construct($parser)
    {
        $this->parser = $parser;
    }

    public function filterBots($data)
    {
        $ans = array();

        for($i=0;$i<count($data);$i++)
        {
            if(!$this->parser->isBot($data[$i][6])){
                $ans[] = $data[$i];
            }
        }

        return $ans;
    }

    public function orderByPage($data)
    {
        $ans = array();

        for($i=0;$i<count($data);$i++)
        {
            $uri = $this->parser->removePageNumber($data[$i][4]);
            if(!$this->parser->isCSSorJSorImage($uri))
            {
                if(isset($ans[$uri])){
                    $ans[$uri]++;
                }else{
                    $ans[$uri] = 1;
                }
            }
        }

        arsort($ans);
        return $ans;
    }

    public function countryStatistics($data, $bool = false)
    {
        $ans = array();
        $n = count($data);

        for($i=0;$i<count($data);$i++)
        {
            $ip = $data[$i][1];

            $country = getCountryFromIP($ip, " NamE ");

            if(isset($ans[$country])){
                $ans[$country]++;
            }else{
                $ans[$country] = 1;
            }
        }

        if($bool)
        {
            foreach($ans as $country => $views)
            {
                $ans[$country] = ($views/$n)*100;
            }
        }

        arsort($ans);
        return $ans;
    }

    public function deviceStatics($data)
    {
        $ans = array(
            "mobile" => 0,
            "pcs" => 0
        );

        for($i=0;$i<count($data);$i++)
        {
            $userAgent = $this->parser->removePageNumber($data[$i][6]);
            if($this->parser->isMobile($userAgent))
            {
                $ans['mobile']++;
            }else{
                $ans['pcs']++;
            }
        }

        arsort($ans);
        return $ans;
    }
}