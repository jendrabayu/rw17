 <div class="btn-group btn-group-sm">
   <a href="{{ route('rumah.edit', $id) }}" class="btn btn-warning btn-icon">
     <i class="fas fa-pencil-alt"></i>
   </a>
   <a href="{{ route('rumah.show', $id) }}" class="btn btn-info btn-icon">
     <i class="far fa-eye"></i>
   </a>
   <button data-url="{{ route('rumah.destroy', $id) }}" type="button" class="btn btn-danger btn-icon btn-delete">
     <i class="fas fa-trash-alt"></i>
   </button>
 </div>
