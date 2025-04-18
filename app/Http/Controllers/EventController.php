<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\RosterParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    protected $rosterParser;

    public function __construct(RosterParserService $rosterParser)
    {
        $this->rosterParser = $rosterParser;
    }

    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('start_time', [
                Carbon::parse($request->start_date),
                Carbon::parse($request->end_date)
            ]);
        }

        return response()->json($query->get());
    }

    public function upcomingFlights()
    {
        $nextWeek = Carbon::parse('2022-01-14')->addWeek();

        $flights = Event::where('type', 'FLT')
            ->where('start_time', '>=', '2022-01-14')
            ->where('start_time', '<=', $nextWeek)
            ->get();

        return response()->json($flights);
    }

    public function upcomingStandby()
    {
        $nextWeek = Carbon::parse('2022-01-14')->addWeek();

        $standby = Event::where('type', 'SBY')
            ->where('start_time', '>=', '2022-01-14')
            ->where('start_time', '<=', $nextWeek)
            ->get();

        return response()->json($standby);
    }

    public function flightsFromLocation(Request $request)
    {
        $location = $request->input('location');

        $flights = Event::where('type', 'FLT')
            ->where('departure_airport', $location)
            ->get();

        return response()->json($flights);
    }

    public function uploadRoster(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'format' => 'required|string|in:pdf,excel,txt,html,webcal'
        ]);

        $file = $request->file('file');
        $content = file_get_contents($file->getPathname());

        $events = $this->rosterParser->parseRoster($content, $request->format);

        foreach ($events as $event) {
            Event::create($event);
        }

        return response()->json(['message' => 'Roster uploaded and processed successfully']);
    }
}
