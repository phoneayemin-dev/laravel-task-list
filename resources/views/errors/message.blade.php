@if (isset($responseMessage))
    <div class="alert alert-danger">
        <ul>
            @foreach ($responseMessage as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif