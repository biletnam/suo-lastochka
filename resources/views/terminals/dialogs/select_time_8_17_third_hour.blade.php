
                @php($index = 0)
                @for ($row = 0; $row < 4; $row++)
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row">
                    @for ($col = 0; $col < 6; $col++)
                    @php($time = $times[$index]['caption'])
                    @php($disabled = $times[$index]['disabled'])
                    @php($class = ('true' != $disabled) ? '' : ' suo-terminal-record-button-disabled')
                    <div class="col-md-2">
                        <div class="suo-terminal-record-button{{ $class }}" onclick="onClickTime( '{{ $time }}', {{ $disabled }} ); return false;">
                            <p class="suo-terminal-record-button-on-middle">{{ $time }}</p>
                        </div>
                    </div>

                    @php($index++)
                    @endfor
                </div>

                @endfor
