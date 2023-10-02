@if(session('success'))
    <div class="error_callout callout callout-success mt-4">
        <span><i class="fas fa-window-close text-lg text-success"></i></span>
        <p>{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="error_callout callout callout-danger mt-4">
        <span><i class="fas fa-window-close text-lg text-danger"></i></span>
        <p>{{ session('error') }}</p>
    </div>
@endif

@if($errors->any())
    <div class="error_callout callout callout-danger mt-4">
        <span><i class="fas fa-window-close text-lg text-danger"></i></span>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
