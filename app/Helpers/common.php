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

if (!function_exists('winScore')) {
    function winScore($club_id)
    {
        $score = App\Model\KetQua::where('doibong_id', $club_id)->sum('banthang');

        return $score;
    }
}

if (!function_exists('lostScore')) {
    function lostScore($club_id)
    {
        $score = App\Model\KetQua::where('doibong_id', $club_id)->sum('banthua');

        return $score;
    }
}

if (!function_exists('numberMatch')) {
    function numberMatch($club_id)
    {
        $number = App\Model\KetQua::where('doibong_id', $club_id)->count();

        return $number;
    }
}

if (!function_exists('getNameClub')) {
    function getNameClub($club_id)
    {
        $club = App\Model\DoiBong::where('id', $club_id)->first();

        return $club->name;
    }
}

if (!function_exists('getImageClub')) {
    function getImageClub($club_id)
    {
        $club = App\Model\DoiBong::where('id', $club_id)->first();

        return $club->hinhanh;
    }
}
