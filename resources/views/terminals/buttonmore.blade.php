                @if(0 != $rooms->suoNextPage)
                    @if(($index % 2) == 0)

            <tr>
                <td>
                </td>
                    @endif

                <td>

                    <button class="btn suo-terminal-button" onclick="onClickNextPage({{ $rooms->suoNextPage }}); return false;">
                        Другие
                    </button>
                </td>
            </tr>
                @elseif(($index % 2) != 0)

                <td>
                </td>
                @endif

                @if(($index % 2) != 0)

            </tr>
                @endif
