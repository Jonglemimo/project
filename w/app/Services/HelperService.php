<?php

namespace Services;

class HelperService
{
    public function create_slug($string){
        $string= $this->replace_accents($string);
        $string=strtolower($string);
        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        $slug=preg_replace('/(-){2,20}/','-',$slug);
        $slug=trim($slug,'-');
        return $slug;
    }

    public function replace_accents($str, $charset='utf-8') {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        return $str;
    }
}