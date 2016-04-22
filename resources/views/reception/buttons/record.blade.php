
<td>
    @php($dayCount = (!isset($tickets[$room->id][$day['long']])) ? 0 : $tickets[$room->id][$day['long']])
    @php($classDisabled = ($dayCount < $room->max_day_record) ? '' : ' suo-reception-button-disabled')
    <button id="suo-btn-room-date-{{ $room->id }}-{{ $day['long'] }}" class="suo-reception-button{{ $classDisabled }}" onclick="onClickDay( {{ $room->id }}, '{{ $day['long'] }}' ); return false;">
        <p>В очереди <span id="suo-tickets-count-{{ $room->id }}-{{ $day['long'] }}">{{ $dayCount }}</span> из {{ $room->max_day_record }}</p>
    </button>
</td>
