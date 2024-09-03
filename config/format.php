<?php
class Format
{
    public function textShorten($text, $limit)
    {
        if (strlen($text) > $limit) {
            $text = substr($text, 0, $limit);
            $text = substr($text, 0, strrpos($text, ' '));
            $text = $text . "...";
        }
        return $text;
    }
}