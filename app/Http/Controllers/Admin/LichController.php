<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\SapXepController;
use App\Http\Controllers\Controller;
use App\Model\DoiBong;
use App\Model\MuaGiai;
use App\Model\SanVanDong;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class LichController extends Controller
{
    protected $sapxep;

    public function __construct(SapXepController $sapxep)
    {
        $this->sapxep = $sapxep;
    }

    public function index()
    {
        return view('admin.index.index');
    }

    public function run(Request $request)
    {
        if ($this->sapxep->isWeekend($request->date) == 2) {
            $request->session()->flash('msg', 'Please choose date of weekend !');
            return redirect()->route('admin.calendar.index');
        }

        $teams = DoiBong::where('active', 1)->groupBy(['id', 'name'])->orderBy('id', 'ASC')->get(['name'])
            ->pluck('name')
            ->toArray();
        $this->sapxep->teams = $teams;

        $stadiums = DoiBong::groupBy(['id', 'sanvandong_id'])->orderBy('id', 'ASC')->get(['sanvandong_id'])
            ->pluck('sanvandong_id')
            ->toArray();

        $result = array_combine($teams, $stadiums);

        $this->sapxep->createMatches();

        if ($this->sapxep->finished) {
            $round = $this->sapxep->matches;
        }
        // dd($round);
        $matches_home = [];
        $matches_away = [];
        $football = [];
        //0 san nha
        foreach ($round as $key => $value) {
            foreach ($value as $k) {
                shuffle($k); //doi vitri 0 1 cua cac doi bong .random san nha san khach
                array_push($football, $k);
                $matches_home[] = [
                    'doi_nha' => $k[0],
                    'doi_khach' => $k[1],
                    'sanvandong_id' => $result[$k[0]],
                ];
            }
        }
        //1 san nha
        shuffle($round);
        $key = 0;
        foreach ($round as $k => $value) {
            foreach ($value as $val) {
                $matches_away[] = [
                    'doi_khach' => $football[$key][0],
                    'doi_nha' => $football[$key][1],
                    'sanvandong_id' => $result[$football[$key][1]],
                ];
                $key = $key + 1;
            }
        }

        $matches = array_merge($matches_home, $matches_away);

        $date = $request->date;

        $matches = $this->sapxep->setDates($matches, $date);
        MuaGiai::truncate();
        DB::table('muagiai')->insert($matches);

        $muaGiai = MuaGiai::with('sanvandong')->orderBy('date', 'ASC')->orderBy('time', 'ASC')->get();

        return redirect()->route('admin.calendar.show');
    }

    public function export(Request $request)
    {
        $muaGiai = MuaGiai::with('sanvandong')->orderBy('date', 'ASC')->orderBy('time', 'ASC')->get();
        $tot_record_found = 0;
        if (count($muaGiai) > 0) {
            $tot_record_found = 1;
            //First Methos
            $export_data = "Round,Date,Time,Home_Team,Away_Team,Stadiums\n";
            foreach ($muaGiai as $value) {
                $export_data .= $value->vongdau . ',' . Carbon::parse($value->date)->format('Y-m-d') . ',' . Carbon::parse($value->time)->format('H:i') .
                ',' . $value->doi_nha . ',' . $value->doi_khach . ',' . $value->sanvandong->name . "\n";
            }
            return response($export_data)
                ->header('Content-Type', 'application/csv')
                ->header('Content-Disposition', 'attachment; filename="calendar.csv"')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }
        die();
    }

    public function show()
    {
        $teams = DoiBong::where('active', 1)->groupBy(['id', 'name'])->orderBy('id', 'ASC')->get(['name'])
            ->pluck('name')
            ->toArray();
        $this->sapxep->teams = $teams;

        $stadiums = DoiBong::groupBy(['id', 'sanvandong_id'])->orderBy('id', 'ASC')->get(['sanvandong_id'])
            ->pluck('sanvandong_id')
            ->toArray();

        $result = array_combine($teams, $stadiums);

        $muaGiai = MuaGiai::with('sanvandong')->orderBy('date', 'ASC')->orderBy('time', 'ASC')->get();

        return view('admin.index.show', compact('muaGiai', 'result'));
    }
}
