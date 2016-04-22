                    @php($time = $times[$index]['caption'])
                    @php($disabled = $times[$index]['disabled'])
                    @php($class = ('true' != $disabled) ? '' : ' suo-reception-record-button-disabled')

                        <div class="suo-reception-record-button{{ $class }}" onclick="onClickTime( '{{ $time }}', {{ $disabled }} ); return false;">
                            <p class="suo-reception-record-button-on-middle">{{ $time }}</p>
                        </div>
