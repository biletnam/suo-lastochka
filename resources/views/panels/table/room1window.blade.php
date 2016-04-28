@php($id = 'room-' . $room->id . '-window-1')
        <tr>
            <th class="suo-header text-center">{{ $room->description }}</th>
            <td class="suo-current-check text-center"><span id="current-{{ $id }}">&nbsp;</span></td>
            <td class="suo-next-check text-center"><span id="next-{{ $id }}">&nbsp;</span></td>
        </tr>
