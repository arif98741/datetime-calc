### Breakdown and Splitting Time Range

<pre>
    $time = new TimeBreakDown(
        startTime: '11:00', 
        endTime: '12:00'
    );
    $time->setIntervalMinute(30);
    $time->setBreakDuration(2);
    $time->includeBreaks(1);
    $data = $time->getIntervals(
        breakString: 'is_break',
        startTimeFormat: 'H:i:s',
        endTimeFormat: 'H:i:s'
    );
</pre>

``This will print below time split with 30mins breaks in every stage and it has 2mins break als``
<pre>
Array
(
    [0] => Array
        (
            [start] => 11:00:00
            [end] => 11:30:00
        )

    [1] => Array
        (
            [start] => 11:30:00
            [end] => 11:32:00
            [is_break] => 1
        )

    [2] => Array
        (
            [start] => 11:32:00
            [end] => 12:02:00
        )

    [3] => Array
        (
            [start] => 12:02:00
            [end] => 12:04:00
            [is_break] => 1
        )

)
</pre>
