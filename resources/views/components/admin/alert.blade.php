@props(['errors' => null, 'message' => null, 'type' => 'danger'])

@if($errors && $errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($message)
    <div class="alert alert-{{ $type }}">{{ $message }}</div>
@endif
