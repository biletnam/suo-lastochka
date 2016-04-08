    <table class="table suo-table table-no-border">
        <tbody>
            @if (count($rooms) <= 5)
                @foreach($rooms as $room)

            <tr>
                <td>

                    @include('terminals.button')
                </td>
            </tr>
                @endforeach
            @else
                @php($index = 0)
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
                @if(0 != $rooms->suoNextPage)
                    @if(($index % 2) == 0)

            <tr>
                <td>
                </td>
                    @endif

                <td>

                    @include('terminals.buttonmore')
                </td>
            </tr>
                    @endif
                @elseif(($index % 2) != 0)

                <td>
                </td>
                @endif

                @if(($index % 2) != 0)

            </tr>
                @endif
            @endif

        </tbody>
    </table>
