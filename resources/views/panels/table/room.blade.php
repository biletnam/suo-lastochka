@php($id = 'room-' . $room->id . '-window')
        <tr>
            <th class="suo-header text-center">{{ $room->description }}</th>
            <td class="suo-current-check text-center">
                @if(1 == $room->window_count)
                <span id="current-{{ $id }}-1">&nbsp;</span>
                @else
                <table class="suo-current-check-with-window">
                    <tbody>
                @for($i = 1; $i <= $room->window_count; $i++)
                <tr>
                    <td>
                    Окно {{ $i }}: <span class="suo-current-check-with-window-check" id="current-{{ $id }}-{{ $i }}">&nbsp;</span>
                    </td>
                </tr>
                @endfor
                    </tbody>
                </table>
                @endif
            </td>
            <td class="suo-next-check text-center"><span id="next-{{ $id }}-1">&nbsp;</span></td>
        </tr>