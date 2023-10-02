@if(session('success'))
    <div class="border border-success error_callout">
        <span><i class="fas fa-window-close text-success"></i></span>
        <p class="checkbox text-success">{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="border border-danger error_callout">
        <span><i class="fas fa-window-close text-danger"></i></span>
        <p class="checkbox text-danger">{{ session('error') }}</p>
    </div>
@endif

@if($errors->any())
    <div class="border border-danger error_callout">
        <span><i class="fas fa-window-close text-danger"></i></span>
        @foreach ($errors->all() as $error)
            <p class="checkbox text-danger">{{ $error }}</p>
        @endforeach
    </div>
@endif
