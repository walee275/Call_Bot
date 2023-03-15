@if (session()->has('success'))
    <div class="alert alert-success bg-green-400 alert-dismissible fade show" role="alert">
        {{ session()->get('success') }}
        <input type="" class="btn-close " data-bs-dismiss="alert" aria-label="Close" style="cursor: pointer;">
    </div>
@elseif (session()->has('error'))
    <div class="alert alert-danger bg-red-600 text-white alert-dismissible fade show" role="alert">
        {{ session()->get('error') }}
        <input type="" class="btn-close " data-bs-dismiss="alert" aria-label="Close" style="cursor: pointer;">
    </div>
@endif
