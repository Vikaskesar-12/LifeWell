@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Specification</h5>
    <div class="card-body">
      <form method="post" action="{{route('specification.update',$specification->id)}}">
        {{csrf_field()}}
        @method('PATCH')
        <div class="form-group" id='parent_cat_div'>
          <label for="parent_id">Category</label>
          <select name="category_id" class="form-control">
              <option value="">--Select any category--</option>
              @foreach($parent_cats as $key=>$parent_cat)
                  <option value='{{$parent_cat->id}}' {{ old('category', $specification->category_id) == $parent_cat->id ? 'selected' : '' }}>{{$parent_cat->title}}</option>
              @endforeach
          </select>
        </div>
        @php
        $types = explode(',',$specification->type);
        @endphp
        <div id="dynamic-fields">
            <div class="title-section" data-index="0">
             
                <div class="form-group">
                    <label for="inputTitle1" class="col-form-label">Specification Name <span class="text-danger">*</span></label>
                    <input id="inputTitle1" type="text" name="name" placeholder="Enter specification Name" value="{{old('titles',$specification->name)}}" class="form-control">
                    @error('titles.0')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
             
                <div class="type-fields">
                    @foreach($types as $key => $type)
                      <div class="form-group">
                          @if($key == 0)
                            <label for="inputSubtitle1" class="col-form-label">Specification Type</label>
                          @endif
                          <div class="input-group">
                              <input id="inputSubtitle1" type="text" name="type[]" placeholder="Enter specification types" value="{{old('subtitles.0',$type)}}" class="form-control">
                              <div class="input-group-append">
                                  <button type="button" class="btn btn-success add-type"><i class="fas fa-plus"></i></button>
                              </div>
                          </div>
                          @error('subtitles.0')
                          <span class="text-danger">{{$message}}</span>
                          @enderror
                      </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="form-group mb-3">
          <!-- <button type="reset" class="btn btn-warning">Reset</button> -->
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 120
      });
    });
</script>
<script>
  $(document).ready(function() {
    var fieldIndex = $('#dynamic-fields .title-section:last').data('index'); // Start at 1 since the first set is already in the HTML

// Add new specification section


    $(document).on('click', '.add-type', function() {
        // Find the parent title-section and get the fieldIndex from data-index
        var parentSection = $(this).closest('.title-section');
        var typendex = parentSection.data('index'); // Get the index of the parent section
        console.log(fieldIndex);

        // Now use the fieldIndex from the parent section in the new type field
        var newTypeField = `
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="type[${typendex}][]" placeholder="Enter additional specification type" class="form-control">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-type"><i class="fas fa-minus"></i></button>
                </div>
            </div>
        </div>
        `;

        // Append the new type field to the type-fields div inside the same title-section
        parentSection.find('.type-fields').append(newTypeField);
    });

    $(document).on('click', '.remove-type', function() {
        $(this).closest('.form-group').remove();
    });
});


</script>
@endpush