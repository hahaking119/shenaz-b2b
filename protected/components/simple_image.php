<?php

/**
 * SimpleImage, image manipulation
 *
 * Higher level image manipulation than provided with PHP
 * @author dirk
 * @version 1.1
 * @package dirkdirk
 *
 */
class simple_image {

    /**
     * Holds the reference to the current image file
     *
     * @var image reference
     */
    var $image;

    /**
     * Image file type, IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG
     *
     * @var unknown_type
     */
    var $image_type;

    /**
     * Loads an image
     *
     * @param string $filename Filename of image to load
     */
    function __construct($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG || $this->image_type == 2) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF || $this->image_type == 1) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG || $this->image_type == 3) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 100, $permissions = null) {
        if (!empty($this->image_type)) {
            $image_type = $this->image_type;
        }
        if ($image_type == IMAGETYPE_JPEG || $this->image_type == 2) {
            $filename = str_replace(".jpg", "", $filename);
            imagejpeg($this->image, $filename . ".jpg", $compression);
            $filename_new = $filename . ".jpg";
        } elseif ($image_type == IMAGETYPE_GIF || $this->image_type == 1) {
            $filename = str_replace(".gif", "", $filename);
            imagegif($this->image, $filename . ".gif");
            $filename_new = $filename . ".gif";
        } elseif ($image_type == IMAGETYPE_PNG || $this->image_type == 3) {
            $filename = str_replace(".png", "", $filename);
            imagepng($this->image, $filename . ".png");
            $filename_new = $filename . ".png";
        } else {
            imagepng($this->image, $filename);
            $filename_new = $filename;
        }
        if ($permissions != null) {
            chmod($filename_new, $permissions);
        }

        return $filename_new;
    }

    function output($image_type = IMAGETYPE_JPEG) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    function getWidth() {
        return imagesx($this->image);
    }

    function getHeight() {
        return imagesy($this->image);
    }

    function getRatio() {
        return $this->getWidth() / $this->getHeight();
    }

    public function crop($width, $height, $sel_width = '0', $sel_height = '0', $top = '0', $left = '0') {
        $percent = 100;
        if ($this->getWidth() > $width)
            $percent = floor(($width * 100) / $this->getWidth());
        if (floor(($this->getHeight() * $percent) / 100) > $height)
            $percent = (($height * 100) / $this->getHeight());
        if ($this->getWidth() > $this->getHeight()) {
            $sel_width = $width;
            $sel_height = round(($this->getHeight() * $percent) / 100);
        } else {
            $sel_width = round(($this->getWidth() * $percent) / 100);
            $sel_height = $height;
        }
        $new_image = imagecreatetruecolor($sel_width, $sel_height);
        imagecopyresized($new_image, $this->image, 0, 0, 0, 0, $sel_width, $sel_height, $this->getWidth(), $this->getHeight());
        $this->resize($sel_width, $sel_height);
    }

    function resizeToHeight($width, $height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    function resizeToWidth($width, $height = "") {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }

    function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    function resize($width, $height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }

    function optimizedResize($optimumWidth, $optimumheight) {
        if ($this->getWidth() > $this->getHeight() || $this->getWidth() == $this->getHeight()) {
            if ($this->getWidth() > $optimumWidth) {
                $width = $optimumWidth;
            } else {
                $width = $this->getWidth();
            }
            $this->resizeToWidth($width);
        } else if ($this->getHeight() > $this->getWidth()) {
            if ($this->getHeight() > $optimumheight) {
                $height = $optimumheight;
            } else {
                $height = $this->getHeight();
            }
            $this->resizeToHeight("", $height);
        }
    }

    function resizeClip($width, $height) {
        $new_image = imagecreatetruecolor($width, $height);
        $ratio = $this->getRatio();
        if ($width / $height > $ratio) {
// Taller
// Clip top and bottom
            $new_height_big = $this->getWidth() * $height / $width;
// Y coord for clipping
            $src_y = ($this->getHeight() - $new_height_big) / 2;
            if ($src_y < 0)
                $src_y = $src_y * -1;

// Resize
            //echo "$new_image, $this->image, 0, 0, 0, $src_y, $width, $height, " . $this->getWidth() . ", $new_height_big";
            imagecopyresampled($new_image, $this->image, 0, 0, 0, $src_y, $width, $height, $this->getWidth(), $new_height_big);
            $this->image = $new_image;
        }
        elseif ($width / $height < $ratio) {
// Wider
// Clip sides
            $new_width_big = $width * $this->getHeight() / $height;
// X coord for clipping
            $src_x = ($this->getWidth() - $new_width_big) / 2;
            if ($src_x < 0)
                $src_x = $src_x * -1;
// Resize
            imagecopyresampled($new_image, $this->image, 0, 0, $src_x, 0, $width, $height, $new_width_big, $this->getHeight());
            $this->image = $new_image;
        }
        else {
// Exact proportions
            $this->resize($width, $height);
        }
    }

    public function resizeToHeightClip($width, $height) {
        $this->resizeToHeight($width, $height);
        $this->resizeClip($width, $height);
    }

}

?>
