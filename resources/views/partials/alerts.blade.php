@if ($errors->isNotEmpty())
  <div class="alert alert-danger alert-dismissible">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      <div class="alert-title">
        Error!
      </div>
      <ul class="list-unstyled">
        @foreach ($errors->all() as $error)
          <li>{{ Str::ucfirst($error) }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif

@if (session()->has('success'))
  <div class="alert alert-success alert-dismissible">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      <div class="alert-title">
        Success!
      </div>
      @if (is_array(session()->get('success')))
        <ul class="list-unstyled">
          @foreach (session()->get('success') as $success)
            <li>{{ Str::ucfirst($success) }}</li>
          @endforeach
        </ul>
      @else
        {{ session()->get('success') }}
      @endif
    </div>
  </div>
@endif

@if (session()->has('warning'))
  <div class="alert alert-warning alert-dismissible">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      <div class="alert-title">
        Warning!
      </div>
      @if (is_array(session()->get('warning')))
        <ul class="list-unstyled">
          @foreach (session()->get('warning') as $warning)
            <li>{{ Str::ucfirst($warning) }}</li>
          @endforeach
        </ul>
      @else
        {{ session()->get('warning') }}
      @endif
    </div>
  </div>
@endif


@if (session()->has('error'))
  <div class="alert alert-danger alert-dismissible">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      <div class="alert-title">
        Error!
      </div>
      @if (is_array(session()->get('error')))
        <ul class="list-unstyled">
          @foreach (session()->get('error') as $error)
            <li>{{ Str::ucfirst($error) }}</li>
          @endforeach
        </ul>
      @else
        {{ session()->get('error') }}
      @endif
    </div>
  </div>
@endif
