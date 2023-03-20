<?php
if (!class_exists('OpenAI')) {
    interface OpenAI_interface
    {
        public function load(string $type, string $handle, array $options);
        public function connect();
        public function prepare(array $options);
        public function disconnect();
        public function toggleDebug();
        public function debugInfo(mixed $info);
        public function debugBacktrace(mixed ...$args);
        public function apiTemplate(string $name, $value);
    }

    class OpenAI implements OpenAI_interface
    {
        private $engine;
        private $tools;
        private $connection;
        private $data = array();
        private $temp;
        private $options;
        private $presets;
        private $models;
        private $defaults;
        private $headers;
        private $api;
        private $openAI;
        private $debug;
        public function __construct($api)
        {
            $this->engine = new OpenAI_engine();
            $this->options = [
                "prompt" => "",
                //"history" => [],
                "temperature" => 0.5,
                "top_p" => 1,
                "best_of" => 3,
                "frequency_penalty" => 1,
                "presence_penalty" => 1
            ];
            $this->presets = $this->engine->presets();
            $this->models = $this->engine->models();
            $this->api = $api;
            $this->openAI = 'https://api.openai.com/v1/completions';
            $this->debug = false;
            $this->load("model", "gpt-3.davinci.003", $this->options);
            $this->defaults = [
                "str" => ["model", "prompt"],
                "arr" => ["history"],
                "int" => ["temperature", "max_tokens", "top_p", "frequency_penalty", "presence_penalty"]
            ];
            $this->headers = [
                "Content-Type: application/json",
                "Authorization: Bearer $this->api",
            ];
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
            $this->debugInfo("Calling object method '$name' " . implode(', ', $arguments) . "\n");
        }

        public function __debugInfo()
        {
            if ($this->debug) {
                return [
                    "options" => $this->options,
                    "presets" => $this->presets,
                    "models" => $this->models,
                    "api" => $this->api,
                    "openAI" => $this->openAI,
                    "debug" => $this->debug,
                    "temp" => $this->temp,
                    "defaults" => $this->defaults,
                    "headers" => $this->headers,
                ];
            }
            return ["debug is not enabled"];
        }

        public function model(string $model)
        {
            $keys = explode(".", $model);
            $result = $this->models;
            foreach ($keys as $key) {
                if (isset($result[$key])) {
                    $result = $result[$key];
                } else {
                    return null;
                }
            }
            return $result;
        }
        public function preset(string $preset)
        {
            $keys = explode(".", $preset);
            $result = $this->presets;
            foreach ($keys as $key) {
                if (isset($result[$key])) {
                    $result = $result[$key];
                } else {
                    return null;
                }
            }
            return $result;
        }

        public function load(string $type, string $handle, array $options)
        {
            if ($type == 'model') {
                $this->temp = $this->model($handle) + $options;
            } elseif ($type == 'preset') {
                $this->temp = $this->preset($handle);
            }
        }

        public function connect($json = true)
        {
            $this->connection = curl_init($this->openAI);
            $data = $this->apiTemplate();

            $this->prepare([
                CURLOPT_URL => $this->openAI,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $this->headers,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_SSL_VERIFYHOST => $this->debug || false,
                CURLOPT_SSL_VERIFYPEER => $this->debug || false
            ]);

            $resp = curl_exec($this->connection);
            $this->disconnect();
            return ($json) ? json_decode($resp, true) : $resp;
        }

        public function prepare(array $options): bool
        {
            return curl_setopt_array($this->connection, $options);
        }

        public function disconnect(): void
        {
            curl_close($this->connection);
        }

        public function toggleDebug(): void
        {
            $this->debug = !$this->debug;
        }

        public function debugInfo(mixed $info)
        {
            if ($this->debug && $info) echo $info;
        }

        public function debugBacktrace(mixed ...$args)
        {
            if (!extract($args) && !$this->debug) return;
            $trace = debug_backtrace();
            trigger_error("Undefined property via __get(): $name \n in $trace[0]['file'] \n on line  $trace[0]['line']", E_USER_NOTICE);
        }

        public function apiTemplate(string $name = null, $value = null)
        {
            if (($name && $value) && array_key_exists($name, $this->temp)) {
                if (in_array($name, $this->defaults["str"])) $value = strval($value);
                if (in_array($name, $this->defaults["arr"])) $value = (array)$value;
                if (in_array($name, $this->defaults["int"])) $value = intval($value);
                if(!is_array($value)){
                    $this->debugInfo("Setting 'template->$name' to '$value'\n");
                }else{
                    $this->debugInfo("Setting 'template->$name' to 'Array'\n");
                }
                $this->temp[$name] = $value;
                return;
            }
            return json_encode($this->temp);
        }
    }
}
