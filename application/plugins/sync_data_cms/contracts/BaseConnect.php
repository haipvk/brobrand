<?php
namespace SyncDataCms\Contracts;
use SyncDataCms\Libs\Curl;
use SyncDataCms\Models\HaravanAccount;
abstract class BaseConnect
{
    private $curl;
    protected $url;
    protected $headers = ['Content-Type: application/x-www-form-urlencoded'];
    protected $method = \SyncDataCms\Constants\ConnectMethod::POST;
    protected $account;
    public function setAccount(HaravanAccount $account)
    {
        $this->account = $account;
    }
    public function addHeader($item)
    {
        $this->headers[] = $item;
    }
    public function setHeaders($items)
    {
        $this->headers = $items;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    public function setMethod($method)
    {
        $this->method = $method;
    }
    public function getMethod()
    {
        return $this->method;
    }
    public function __construct(HaravanAccount $account, $url)
    {
        $this->account = $account;
        $this->url = $url;
        $this->curl = new Curl($this->url);
        $this->curl->option(CURLOPT_FAILONERROR, false);
    }
    public function reInit()
    {
        $this->curl = new Curl($this->url);
        $this->curl->option(CURLOPT_FAILONERROR, false);
    }
    public function debug()
    {
        $this->curl->debug();
    }
    protected function _execute($dataPost)
    {
        $func = $this->method;
        $this->curl->$func($dataPost, [CURLOPT_HTTPHEADER => $this->headers]);
        $result = $this->curl->execute();
        return $result;
    }
}

