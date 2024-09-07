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
    public function number($number)
    {
        if ($number <= 0) {
            $number = 0;
        } elseif ($number > 1000) {
            $number = $number / 1000 . 'N';
        } elseif ($number > 1000000) {
            $number = $number / 1000000 . 'Tr';
        } elseif ($number > 1000000000) {
            $number = $number / 1000000000 . 'T';
        }
    }
}