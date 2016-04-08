                <tr>
                    <td class="table-text">{{ $terminal->ip_address }}</td>
                    <td class="table-text">{{ $terminal->name }}</td>
                    <td>{{ $terminal->description }}</td>
                    <td>
                        <form action="{{ url('terminal/select') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="terminal" value="{{ $terminal->id }}">
                            <button type="submit" id="select-terminal-{{ $terminal->id }}" class="btn btn-warning">
                                Выбрать
                            </button>
                        </form>
                    </td>
                </tr>
