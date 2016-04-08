                            <tr>
                                <td class="table-text">
                                    <div>{{ $terminal->ip_address }}</div>
                                </td>

                                <td class="table-text">
                                    <div>{{ $terminal->name }}</div>
                                </td>

                                <td>
                                    <div>{{ $terminal->description }}</div>
                                </td>

                                <td>
                                    <form action="{{ url('terminal/select') }}" method="POST">
                                        {!! csrf_field() !!}

                                        <input type="hidden" name="terminal" value="{{ $terminal->id }}">
                                        <button type="submit" id="select-terminal-{{ $terminal->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Выбрать
                                        </button>
                                    </form>
                                </td>
                            </tr>
