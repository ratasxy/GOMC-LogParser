<?php

class File{

    private $filename;
    private $handler;

    public function __construct($filename)
    {
        if(!is_readable($filename))die("The file is not readable.\n");

        $this->filename =  $filename;
        $this->handler = fopen($this->filename, "r");
    }

    public function __destruct(){
        fclose($this->handler);
    }

    public function read()
    {
        return fread($this->handler, filesize($this->filename));
    }
}