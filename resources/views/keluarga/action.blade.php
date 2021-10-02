 <div class="btn-group btn-group-sm">
   @role('rt')
   <a href="{{ route('keluarga.edit', $id) }}" class="btn btn-warning btn-icon">
     <i class="fas fa-pencil-alt"></i>
   </a>
   @endrole
   <a href="{{ route('keluarga.show', $id) }}" class="btn btn-info btn-icon">
     <i class="far fa-eye"></i>
   </a>
   @role('rt')
   <button data-url="{{ route('keluarga.destroy', $id) }}" type="button" class="btn btn-danger btn-icon btn-delete">
     <i class="fas fa-trash-alt"></i>
   </button>
   @endrole
 </div>
