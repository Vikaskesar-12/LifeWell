@extends('backend.layouts.master')
@section('title', 'LifeWell || Add Product Variant')
@section('main-content')

<div class="card">
<div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Edit Product Variant</h6>
      <a href="{{route('product-variant',request()->segment(4))}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"> Product List</a>
    </div>
    <div class="card-body">
    @if(session('error'))
                
                        <div class="alert alert-danger" id="error-alert">
                {{session('error')}}
            </div>
                        @endif
      <form method="post" action="{{route('variant.update')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        
        <div class="product-variant col-md-12" id="product-variant">
          <!-- <div class="add-button col-md-12 offset-11">
              <button class="btn btn-success ms-auto" id="add_variant" type="button">Add Variant</button>
          </div> -->
            <input type="hidden" name="product_id" value="{{request()->segment(4)}}">
            <input type="hidden" name="variant_id" value="{{request()->segment(5)}}">
          <div class="row">
            <div class="form-group col-md-4">
              <label for="price" class="col-form-label">Variant Title <span class="text-danger">*</span></label>
              <input id="variant_title" type="text" name="title" placeholder="Enter old price"  value="{{old('title',$variant->title)}}" class="form-control">
              @error('variant_title')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="form-group col-md-4">
              <label for="discount" class="col-form-label">Discount(%)</label>
              <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount"  value="{{old('discount',$variant->discount)}}" class="form-control">
              @error('discount')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="form-group col-md-4">
              <label for="collection">Collection</label>
              <select name="collection" class="form-control">
                  <option value="">--Select Condition--</option>
                  <option value="default" {{$variant->collection == "default" ? 'selected' : '' }}>Default</option>
                  <option value="new" {{$variant->collection == "new" ? 'selected' : '' }}>New</option>
                  <option value="hot" {{$variant->collection == "hot" ? 'selected' : '' }}>Hot</option>
              </select>
              @error('collection')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-4">
              <label for="price" class="col-form-label">Old Price(NRS) <span class="text-danger">*</span></label>
              <input id="base_price" type="number" name="base_price" placeholder="Enter old price"  value="{{old('base_price',$variant->base_price)}}" class="form-control">
              @error('base_price')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="form-group col-md-4">
              <label for="price" class="col-form-label">Price(NRS) <span class="text-danger">*</span></label>
              <input id="price" type="number" name="price" placeholder="Enter price"  value="{{old('price',$variant->price)}}" class="form-control">
              @error('price')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="form-group col-md-4">
              <label for="stock">Quantity <span class="text-danger">*</span></label>
              <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"  value="{{old('stock',$variant->stock)}}" class="form-control">
              @error('stock')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          @foreach($variant->productSpecification as $key => $specification)
                @if ($key % 3 === 0) 
                    @if ($key !== 0) 
                       <div>
                    @endif
                    <div class="row">
                @endif
                <div class="col-md-4"> <!-- One column -->
                    <div class="form-group">
                        <label for="">{{$specification->name}}</label>
                        <input type="hidden" name="specification[]" value="{{$specification->name}}">
                        <input type="text" name="{{$specification->name}}" value="{{$specification->type}}" required class="form-control">
                    </div>
                </div>
                
            @endforeach
            </div>
         
          <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo (Max size: 1MB, dimensions: 800x1000 min, 1600x2000 max, formats: JPG, JPEG)  <span class="text-danger">*</span></label>
          <div class="input-group">
          <input class="form-control" type="file" name="photo[]" accept="image/*" multiple id="imageInput">
        </div>
        <div id="privew">
       @foreach($variant->productImages as $image)
          <div id="deleteId-{{ $image->id }}" style="position: relative; display: inline-block; margin-right: 10px;">
            <img src="{{ asset($image->image) }}" alt="" style="width: 100px; height: auto;">
            <span class="delete-icon" data-id="{{json_encode($image)}}" style="position: absolute; top: 0px; right: 0px; color: red; cursor: pointer; font-size: 15px; background: white; border-radius: 50%; padding: 1px;">x</span>
          </div>
          @endforeach
       </div>
        <div id="previewContainer" style="margin-top: 10px;">
            <!-- Image previews will be displayed here -->
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
        @foreach ($errors->get('photo.*') as $key => $error)
            <span class="text-danger">{{ $error[0] }}</span>
        @endforeach
        </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
            <select name="variant_status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            @error('status')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      $('.specification').empty();
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            // alert(data);
            var data=response.data;
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
          
        }
      });

      
    }
    else{
    }
    
  })
</script>
<script>
$(document).ready(function() {
    let selectedFiles = [];

    $('#imageInput').on('change', function(event) {
        const previewContainer = $('#previewContainer');
        previewContainer.empty(); // Clear previous previews

        const files = Array.from(event.target.files);
        selectedFiles = files; // Store selected files in an array

        renderPreviews(selectedFiles, previewContainer);
    });

    function renderPreviews(files, container) {
        container.empty(); // Clear previous previews

        $.each(files, function(index, file) {
            // Ensure the file is an image
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = $('<div>').css({ position: 'relative', display: 'inline-block', marginRight: '10px' });
                    const img = $('<img>')
                        .attr('src', e.target.result)
                        .css({
                            'width': '100px', // Adjust as needed
                            'height': 'auto',  // Maintain aspect ratio
                        });
                    
                    const removeIcon = $('<span>&times;</span>') // Cross icon (×)
                        .css({
                            position: 'absolute',
                            top: '0',
                            right: '0',
                            color: 'red',
                            cursor: 'pointer',
                            fontSize: '15px',
                            background: 'white',
                            borderRadius: '50%',
                            padding: '1px',
                        })
                        .data('fileIndex', index) // Store the index of the file
                        .on('click', function() {
                            const fileIndex = $(this).data('fileIndex');
                            selectedFiles.splice(fileIndex, 1); // Remove from array
                            previewDiv.remove(); // Remove image from preview

                            // Update the input's files
                            updateInputFiles();
                        });

                    previewDiv.append(img).append(removeIcon);
                    container.append(previewDiv);
                }
                reader.readAsDataURL(file);
            }
        });
    }

    function updateInputFiles() {
        const newFileList = new DataTransfer(); // Create a new DataTransfer object
        selectedFiles.forEach(file => newFileList.items.add(file)); // Add remaining files
        $('#imageInput')[0].files = newFileList.files; // Update the input's files

        // Re-render previews to update the displayed index
        renderPreviews(selectedFiles, $('#previewContainer'));
    }
});

$(document).on('click', '.delete-icon', function() {
        var data = $(this).data('id');
        id       = data.id;
        console.log(id);
        
        $.ajax({
            url: "{{ route('delete.image') }}",
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#deleteId-' + id).hide();
                } else {
                   
                }
            },
            error: function(xhr, status, error) {
                var response = xhr.responseJSON;
                if (response && response.errors) {
                    $('.category-validate').html(response.errors.category);
                } else {
                    // Handle other types of errors
                    console.error('Unexpected error:', error);
                }
            }
        });
    });
</script>
<script>
  $(document).on('change','#is_featured',function() {
          var status = $(this).is(':checked') ? 1 : 0;
          $(this).val(status);
        });
  $(document).on('change','#top_rated',function() {
    var status = $(this).is(':checked') ? 1 : 0;
    $(this).val(status);
  });
  $(document).on('change','#best_seller',function() {
    var status = $(this).is(':checked') ? 1 : 0;
    $(this).val(status);
  });

</script>
@endpush