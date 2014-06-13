<?php

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
}