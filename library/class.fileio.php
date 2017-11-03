<?php

class fileio
{

    static $text = null;
    /**
     * [save text file]
     * @param  [string] $name [name text file]
     */
    static public function save($name)
    {
        file_put_contents(self::getPath(). "/template/" . $name . ".txt", $_POST['text']);
    }

    static public function getPath()
    {
        return realpath(dirname(__FILE__) . '/..');

    }

    static public function open($name)
    {
        self::$text = file_get_contents(self::getPath() . "/template/" . $name);
    }

    /**
     * [search description]
     * @param  [array] $f [List files in folder]
     * @return [array]    [List files with .txt extenstion]
     */
    static public function search(  )
    {
        $dir = self::getPath() . "/template/";
        $f = scandir($dir);
        $n = 0;
        $csvFiles = null;
        foreach ($f as $file)
        {
            if (preg_match('/\.(txt)/', $file))
            {
                $csvFiles[$n] = $file;
                $n++;
            }
        }
        return $csvFiles;
    }
}

?>