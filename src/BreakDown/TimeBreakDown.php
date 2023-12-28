<?php

namespace Xenon\DatetimeCalc\BreakDown;

use Carbon\Carbon;

class TimeBreakDown
{
    private string $startTime;
    private string $endTime;
    private int $breakDuration;
    private bool $includeBreakInInerval = false;
    private int $intervalMinute = 5; //default value is 5. you can change this

    /**
     * @param string $startTime
     * @param string $endTime
     * @param int $breakDuration
     */
    public function __construct(string $startTime, string $endTime, int $breakDuration = 0)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->breakDuration = $breakDuration;
    }

    private function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * Start time of the intervals.
     * @param string $stringTime
     * @return void
     */
    public function setStartTime(string $stringTime): void
    {
        $this->startTime = $stringTime;
    }

    private function getEndTime(): string
    {
        return $this->endTime;
    }

    /**
     * End time of the intervals
     * @param string $endTime
     * @return void
     */
    public function setEndTime(string $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * Interval minute will be used for splitting time . Such as for 5 mins it will be
     * 11:00-11:05, 11:05-11:10 , 11:10-11:15 etc.
     * @param int $intervalMinute
     * @return void
     */
    public function setIntervalMinute(int $intervalMinute): void
    {
        $this->intervalMinute = $intervalMinute;
    }

    private function getIntervalMinute(): int
    {
        return $this->intervalMinute;
    }

    private function getBreakDuration(): int
    {
        return $this->breakDuration;
    }

    /**
     * Break duration will be used for taking break for given minute between intervals
     * @param int $breakDuration
     * @return void
     */
    public function setBreakDuration(int $breakDuration): void
    {
        $this->breakDuration = $breakDuration;
    }

    public function isIncludeBreakInInerval(): bool
    {
        return $this->includeBreakInInerval;
    }

    public function includeBreaks(bool $includeBreakInInerval): void
    {
        $this->includeBreakInInerval = $includeBreakInInerval;
    }


    /**
     * @param string $startString
     * @param string $endString
     * @param string $breakString
     * @param string $startTimeFormat
     * @param string $endTimeFormat
     * @return array
     */
    public function getIntervals(string $startString = 'start', string $endString = 'end', string $breakString = 'break', string $startTimeFormat = 'H:i', string $endTimeFormat = 'H:i'): array
    {
        $startTime = Carbon::parse($this->startTime);
        $endTime = Carbon::parse($this->endTime);

        $intervals = [];

        $currentTime = $startTime;
        while ($currentTime->lt($endTime)) {
            $nextTime = $currentTime->copy()->addMinutes($this->intervalMinute);

            $intervals[] = [
                $startString => $currentTime->format($startTimeFormat),
                $endString => $nextTime->format($endTimeFormat)
            ];

            $currentTime = $nextTime->copy()->addMinutes($this->getBreakDuration());

            $breakTime = $nextTime->copy()->addMinutes($this->getBreakDuration());

            if ($this->includeBreakInInerval) {
                $intervals[] = [
                    $startString => $nextTime->format($startTimeFormat),
                    $endString => $breakTime->format($endTimeFormat),
                    $breakString => true
                ];
            }
        }

        return $intervals;
    }
}
