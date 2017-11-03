<?php namespace App\Libraries\GoogleDirectory;
use Wongpinter\GoogleClient\Client;

/**
 * Created By: Sugeng
 * Date: 11/3/17
 * Time: 11:20
 */
class Directory
{
    protected $directory;

    public function __construct()
    {
        $this->directory = new \Google_Service_Directory((new Client(config('google')))->client());
    }
}