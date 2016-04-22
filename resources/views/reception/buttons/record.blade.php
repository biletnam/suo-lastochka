
<td>
    @php($dayCount = (!isset($tickets[$room->id][$day['long']])) ? 0 : $tickets[$room->id][$day['long']])
    @php($classDisabled = ($dayCount < $room->max_day_record) ? '' : ' suo-reception-button-disabled')
    <button class="suo-reception-button{{ $classDisabled }}" onclick="onClickDay( {{ $room->id }}, '{{ $day['long'] }}' ); return false;">
        <p>В очереди {{ $dayCount }} из {{ $room->max_day_record }}</p>
    </button>
</td>
