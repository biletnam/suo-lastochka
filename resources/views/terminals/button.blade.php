                    <button id="create-ticket-{{ $room->id }}" class="btn suo-terminal-button" onclick="createTicket({{ $room->id }}); return false;">
                        {{ $room->description }}
                    </button>
