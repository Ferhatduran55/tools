<?php

interface ChatOpenAI_interface
{
    public function connect();
    public function toggleDebug();
    public function debugInfo(mixed $info);
    public function debugBacktrace(mixed ...$args);
    public function apiTemplate(string $name, $value);
}

class ChatOpenAI implements ChatOpenAI_interface
{
    private $data = array();
    private $temp;
    private $api;
    private $openAI;
    private $debug;
    public function __construct(){
        $this->api = 'XXX';
        $this->openAI = 'https://api.openai.com/v1/completions';
        $this->debug = true;
        $this->temp = array(
            "model" => "text-davinci-003",
            "prompt" => "",
            "temperature" => 1,
            "max_tokens" => 2048,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0.6,
            "stop" => array(
                " Human:",
                " AI:"
            )
        );
    }

    public function __set(string $name, mixed $value)
    {
        $this->debugInfo("Setting '$name' to '$value'\n");
        $this->data[$name] = $value;
    }

    public function __get(string $name)
    {
        $this->debugInfo("Getting '$name'\n");
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $this->debugBacktrace($name);
        return null;
    }

    public function __isset(string $name)
    {
        $this->debugInfo("Is '$name' set?\n");
        return isset($this->data[$name]);
    }

    public function __unset(string $name)
    {
        $this->debugInfo("Unsetting '$name'\n");
        unset($this->data[$name]);
    }

    public function __call(string $name, array $arguments)
    {
        $this->debugInfo("Calling object method '$name' " . implode(', ', $arguments). "\n");
    }

    public function connect($json = true)
    {
        $curl = curl_init($this->openAI);
        curl_setopt($curl, CURLOPT_URL, $this->openAI);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $this->api",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = $this->apiTemplate();

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $this->debug || false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->debug || false);

        $resp = curl_exec($curl);
        curl_close($curl);
        if($json){
            return json_decode($resp,true);
        }else{
            return $resp;
        }
    }
    public function toggleDebug(){
        $this->debug = !$this->debug;
    }
    public function debugInfo(mixed $info){
        if($this->debug && $info) echo $info;
    }
    public function debugBacktrace(mixed ...$args){
        if(!extract($args) && !$this->debug)return;
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
    }
    public function apiTemplate(string $name = null, $value = null){
        if($name && $value){
            if (array_key_exists($name, $this->temp)) {
                $strvals = array("model","prompt");
                $intvals = array("temperature", "max_tokens", "top_p", "frequency_penalty", "presence_penalty");
                if(in_array($name,$strvals)){
                    $value = strval($value);
                }elseif(in_array($name,$intvals)){
                    $value = intval($value);
                }
                $this->debugInfo("Setting 'template->$name' to '$value'\n");
                $this->temp[$name] = $value;
            }
            return;
        }
        return json_encode($this->temp);
    }
}
