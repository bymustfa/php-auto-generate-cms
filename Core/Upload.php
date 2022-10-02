<?php

namespace Core;


class Upload
{
    private static $instance;
    public $upload;
    public $file;

    public function __construct($name)
    {
        if (is_array($name)) {
            $this->upload = new \Verot\Upload\Upload($name, config('LOCALE'));
        } else {
            $this->upload = new \Verot\Upload\Upload($_FILES[$name], config('LOCALE'));
        }
    }

    public static function getInstance($name)
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($name);
        }
        return self::$instance;
    }

    public function rename($name)
    {
        $this->upload->file_new_name_body = $name;
        return $this;
    }

    public function options(array $options)
    {
        foreach ($options as $key => $option) {
            $this->upload->{$key} = $option;
        }
        return $this;
    }

    public function resize($width, $height = null, $crop = true)
    {
        $this->upload->image_resize = true;
        $this->upload->image_x = $width;
        if ($height) {
            $this->upload->image_y = $height;
            $this->upload->image_ratio_crop = $crop;
        } else {
            $this->upload->image_ratio_y = true;
        }
        return $this;
    }

    public function convert($ext)
    {
        $this->upload->image_convert = $ext;
        return $this;
    }

    public function compress($percent = 0)
    {
        $this->upload->png_compression = $percent;
        return $this;
    }

    public function watermark($text = null)
    {
        if ($text) {
            $this->upload->image_unsharp = true;
            $this->upload->image_border = '0 0 16 0';
            $this->upload->image_border_color = '#000000';
            $this->upload->image_text = $text;
            $this->upload->image_text_font = 2;
            $this->upload->image_text_position = 'B';
            $this->upload->image_text_padding_y = 2;
        }
        return $this;
    }

    public function prefix($prefix)
    {
        $this->upload->file_name_body_pre = $prefix . '_';
        return $this;
    }

    public function allowed($mimes)
    {
        $this->upload->allowed = $mimes;
        return $this;
    }

    public function onlyImages()
    {
        $this->upload->allowed = ['image/*'];
        return $this;
    }

    public function to($path)
    {
        if ($this->upload->uploaded) {
            $this->upload->process(dirname(__DIR__) . '/' . $path);
            if ($this->upload->processed) {
                $this->file = $this->upload->file_dst_name;
            }
        }
        return $this;
    }

    public function getFile()
    {
        return $this->upload->file_dst_name;
    }

    public function getFileWithPath()
    {
        return $this->upload->file_dst_pathname;
    }

    public function error()
    {
        $this->upload->process();
        return $this->upload->error;
    }


    public function __destruct()
    {
        $this->upload->clean();
    }

}


?>
