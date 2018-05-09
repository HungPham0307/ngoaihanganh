<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SapXepController extends Controller
{
    public $finished;
    public $error;
    public $teams;
    public $teams1;
    public $teams2;
    public $matches;

    public function __construct()
    {
        $this->finished = false;
        $this->error = '';
        $this->matches = [];
    }

    public function createMatches()
    {
        if (!$this->validTeamArray()) {
            return false;
        }

        $this->matches = [];

        //teams1 10 doi dau
        //teams2 10 doi sau
        $this->teams1 = array_slice($this->teams, 0, count($this->teams) / 2);
        $this->teams2 = array_slice($this->teams, count($this->teams) / 2);

        for ($i = 2; $i < (count($this->teams1) * 2); $i++) {
            $this->saveMatchday();
            $this->rotate();
        }

        $this->saveMatchday();
        $this->finished = true;

        return $this->matches;
    }

    private function saveMatchday()
    {
        for ($i = 0; $i < count($this->teams1); $i++) {
            $matches_tmp[] = [$this->teams1[$i], $this->teams2[$i]];
        }
        $this->matches[] = $matches_tmp;

        return true;
    }

    private function rotate()
    {
        $temp = $this->teams1[1];

        for ($i = 1; $i < (count($this->teams1) - 1); $i++) {
            $this->teams1[$i] = $this->teams1[$i + 1];
        }

        $this->teams1[count($this->teams1) - 1] = end($this->teams2);

        for ($i = (count($this->teams2) - 1); $i > 0; $i--) {
            $this->teams2[$i] = $this->teams2[$i - 1];
        }
        $this->teams2[0] = $temp;

        return true;
    }

    private function validTeamArray()
    {
        if (!is_array($this->teams) || count($this->teams) < 2) {
            $this->error = 'Not enough teams in array => shape passed';
            $this->resetClassState();
            return false;
        }
        return true;
    }

    private function resetClassState()
    {
        $this->finished = false;
        $this->matches = [];
        return true;
    }

    public function setDates($schedule, $startingDate)
    {
        $date = Carbon::parse($startingDate);
        $sum = count($schedule);
        $vongdau = 1;
        $count = 0;

        if (isWeekend($date) == 0) {
            $match = rand(3, 7);

            for ($i = 0; $i < $match; $i++) {
                $schedule[$count]['date'] = $date->format('Y-m-d');
                $schedule[$count]['time'] = Carbon::parse($this->rand_time());
                $schedule[$count]['vongdau'] = $vongdau;
                $count++;
            }

            $date = Carbon::parse($date)->addDay();

            for ($i = 0; $i < (10 - $match); $i++) {
                $schedule[$count]['date'] = $date->format('Y-m-d');
                $schedule[$count]['time'] = Carbon::parse($this->rand_time());
                $schedule[$count]['vongdau'] = $vongdau;
                $count++;
            }

            $sum = $sum - 10;
        }

        if (isWeekend($startingDate) == 1) {
            for ($i = 0; $i < 10; $i++) {
                $schedule[$count]['date'] = $date->format('Y-m-d');
                $schedule[$count]['time'] = Carbon::parse($this->rand_time());
                $schedule[$count]['vongdau'] = $vongdau;
                $count++;
            }

            $sum = $sum - 10;
        }
        while ($sum > 0) {
            $date = Carbon::parse($date)->addDay();

            if (isWeekend($date) == 0) {
                $vongdau++;
                $match = rand(3, 7);

                for ($i = 0; $i < $match; $i++) {
                    $schedule[$count]['date'] = $date->format('Y-m-d');
                    $schedule[$count]['time'] = Carbon::parse($this->rand_time());
                    $schedule[$count]['vongdau'] = $vongdau;
                    $count++;
                }

                $date = Carbon::parse($date)->addDay();

                for ($i = 0; $i < (10 - $match); $i++) {
                    $schedule[$count]['date'] = $date->format('Y-m-d');
                    $schedule[$count]['time'] = Carbon::parse($this->rand_time());
                    $schedule[$count]['vongdau'] = $vongdau;
                    $count++;
                }

                $sum = $sum - 10;
            }
        }

        return $schedule;
    }

    public function rand_time()
    {
        $arrTime = ['7:00', '7:30', '8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30'];
        return $arrTime[array_rand($arrTime)];
    }
}
