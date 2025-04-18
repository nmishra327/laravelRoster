<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class RosterParserService
{
    public function parseRoster(string $content, string $format): Collection
    {
        // Basic implementation for now
        return collect([]);
    }

    protected function parseFlightNumber(string $text): ?string
    {
        // Match flight numbers (2 characters followed by numbers)
        if (preg_match('/^[A-Z]{2}\d+$/', $text)) {
            return $text;
        }
        return null;
    }

    protected function determineEventType(string $text): string
    {
        $text = strtoupper(trim($text));

        if ($text === 'DO') return 'DO';
        if ($text === 'SBY') return 'SBY';
        if ($this->parseFlightNumber($text)) return 'FLT';
        if ($text === 'CI') return 'CI';
        if ($text === 'CO') return 'CO';

        return 'UNK';
    }

    protected function parseDateTime(string $date, string $time): Carbon
    {
        // TODO: Implement date/time parsing logic
        // This will need to handle both Zulu and Local time formats
        return Carbon::parse($date . ' ' . $time);
    }
}
