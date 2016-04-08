    <table class="table suo-table table-no-border">
        <tbody>
            @php($index = 0)
            @if (count($rooms) <= 5)
                @each('terminals.button1column', $rooms, 'room')
                @php($index = 1)
                @include('terminals.buttonmore')
            @else
                @foreach($rooms as $room)
                    @if(($index % 2) == 0)

            <tr>
                    @endif

                <td>

                    @include('terminals.button')
                </td>
                    @if(($index % 2) != 0)

            </tr>
                    @endif
                    @php(++ $index)
                @endforeach
                @include('terminals.buttonmore')
            @endif

        </tbody>
    </table>
