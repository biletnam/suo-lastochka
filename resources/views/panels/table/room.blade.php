@if($room->window_count > 1)
@include('panels.table.roomseveralwindow')
@else
@include('panels.table.room1window')
@endif
