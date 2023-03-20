<?php
namespace Ferhatduran55;

interface Loader_interface {
    public function requireClass($class);
    public function requireClasses();
    public function createInstance($className, ...$args);
    public function addFileDirectory($directory);
    public function includeFile($file);
    public function includeFiles();
    public function getLoaded();
    public function getInstances();
}

class Loader implements Loader_interface
{
    private $loaded = ['class' => [], 'file' => []];
    private $classPrefix;
    private $classSuffix = '.class.php';
    private $filePrefix;
    private $fileSuffix = '.php';
    private $classDirectories = ['./'];
    private $fileDirectories = [];
    private $instances = [];

    public function __construct($options = [])
    {
        if (isset($options['classPrefix'])) {
            $this->classPrefix = $options['classPrefix'];
        }
        if (isset($options['classSuffix'])) {
            $this->classSuffix = $options['classSuffix'];
        }
        if (isset($options['filePrefix'])) {
            $this->filePrefix = $options['filePrefix'];
        }
        if (isset($options['fileSuffix'])) {
            $this->fileSuffix = $options['fileSuffix'];
        }
        if (isset($options['classDirectories'])) {
            $this->classDirectories = $options['classDirectories'];
        }
        if (isset($options['fileDirectories'])) {
            $this->fileDirectories = $options['fileDirectories'];
        }
    }

    public function requireClass($class)
    {
        if (in_array($class, $this->loaded['class'])) {
            return;
        }

        $path = $this->getClassPath($class);

        if ($path) {
            require_once $path;
            $this->loaded['class'][] = $class;
        }
    }

    private function requireClassWithArgs($className, $args)
    {
        if (in_array($className, $this->loaded['class'])) {
            return;
        }

        $path = $this->getClassPath($className);

        if ($path) {
            require_once $path;
            $reflectionClass = new \ReflectionClass($className);
            $instance = $reflectionClass->newInstanceArgs($args);
            $this->instances[$className] = $instance;
            $this->loaded['class'][] = $className;
        }
    }

    public function requireClasses()
    {
        $classes = func_get_args();

        foreach ($classes as $class) {
            if (is_array($class)) {
                $className = $class[0];
                $args = isset($class[1]) ? (array)$class[1] : [];
                $this->requireClassWithArgs($className, $args);
            } else {
                $this->requireClass($class);
            }
        }
    }

    private function getClassPath($class)
    {
        $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class);

        if ($this->classPrefix) {
            $filename = $this->classPrefix . DIRECTORY_SEPARATOR . $filename;
        }

        $filename .= $this->classSuffix;

        foreach ($this->classDirectories as $directory) {
            $path = $directory . DIRECTORY_SEPARATOR . $filename;
            if (file_exists($path)) {
                return $path;
            }
        }

        return false;
    }

    public function createInstance($className, ...$args)
    {
        if (in_array($className, $this->loaded['class'])) {
            $reflectionClass = new \ReflectionClass($className);
            return $reflectionClass->newInstanceArgs($args);
        }
        throw new \Exception("Class not found: " . $className);
    }

    public function addFileDirectory($directory)
    {
        $this->fileDirectories[] = $directory;
    }

    public function includeFile($file)
    {
        if (in_array($file, $this->loaded['file'])) {
            return;
        }

        if ($this->filePrefix) {
            $file = $this->filePrefix . DIRECTORY_SEPARATOR . $file;
        }

        $file .= $this->fileSuffix;

        foreach ($this->fileDirectories as $directory) {
            $path = $directory . DIRECTORY_SEPARATOR . $file;
            if (file_exists($path)) {
                include_once $path;
                $this->loaded['file'][] = $path;
                return;
            }
        }

        throw new \Exception("File not found: " . $file);
    }

    public function includeFiles()
    {
        $files = func_get_args();

        foreach ($files as $file) {
            $this->includeFile($file);
        }
    }

    public function getLoaded()
    {
        return $this->loaded;
    }
    
    public function getInstances()
    {
        return $this->instances;
    }
}
