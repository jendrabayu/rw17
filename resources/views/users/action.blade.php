  <div class="btn-group btn-group-sm ">
    <a href="{{ route('users.edit', $id) }}" class="btn btn-warning btn-icon">
      <i class="fas fa-pencil-alt"></i>
    </a>
    <button data-url="{{ route('users.destroy', $id) }}" type="button" class="btn btn-danger btn-icon btn-delete">
      <i class="fas fa-trash-alt"></i>
    </button>
  </div>
