    @if (isset($messages))
        <div class="alert alert-{{ $alert }}">
            <ul>
                @foreach ($messages as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
            </ul>
        </div>
    @endif
