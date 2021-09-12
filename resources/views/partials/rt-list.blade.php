@role('rw')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-pills">
          @php
            $all_requests = request()->all();
            unset($all_requests['rt']);
          @endphp
          <li class="nav-item">
            <a class="nav-link {{ !request()->has('rt') ? 'active' : '' }}"
              href="{{ route('penduduk.index', $all_requests) }}">Semua RT</a>
          </li>
          @foreach ($rt as $id => $nomor)
            <li class="nav-item">
              <a class="nav-link {{ request()->get('rt') == $id ? 'active' : '' }}"
                href="{{ route('penduduk.index', array_merge(['rt' => $id], $all_requests)) }}">RT
                {{ $nomor }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
@endrole
