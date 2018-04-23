<?php

if (!function_exists('homeScore')) {
    function homeScore($home_id, $round)
    {
        $result = App\Model\CapDau::where('vongdau', $round)->where('doinha_id', $home_id)->first();

        if ($result) {
            return $result->doinha_goals;
        } else {
            return null;
        }
    }
}

if (!function_exists('awayScore')) {
    function awayScore($away_id, $round)
    {
        $result = App\Model\CapDau::where('vongdau', $round)->where('doikhach_id', $away_id)->first();

        if ($result) {
            return $result->doikhach_goals;
        } else {
            return null;
        }
    }
}
