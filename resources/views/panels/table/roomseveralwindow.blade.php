@for($i = 1; $i <= $room->window_count; $i++)
@php($id = 'room-' . $room->id . '-window-' . $i)
        <tr>
            <th class="suo-header text-center">{{ $room->description }} окно {{ $i }}</th>
            <td class="suo-current-check text-center"><span id="current-{{ $id }}">&nbsp;</span></td>
            <td class="suo-next-check text-center"><span id="next-{{ $id }}">&nbsp;</span></td>
        </tr>
@endfor