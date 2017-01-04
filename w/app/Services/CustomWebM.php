<?php
/**
 * Created by PhpStorm.
 * User: Helda
 * Date: 03/01/2017
 * Time: 19:35
 */

namespace Services;



use FFMpeg\Format\Video\WebM;

class CustomWebM extends WebM
{
    public function getExtraParams()
    {
        return array('-f', 'webm', '-quality', 'good', '-threads', 12, '-qmin', 0, '-qmax', 50, '-cpu-used',12);
    }
}