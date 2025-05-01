@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Faq</h5>
    <div class="card-body">
      <form method="post" action="{{route('faq.store')}}">
        {{csrf_field()}}
        

        <div id="dynamic-fields">
            <div class="title-section" data-index="0">
                <div class="form-group">
                    <label for="inputTitle1" class="col-form-label">Question <span class="text-danger">*</span></label>
                    <input id="inputTitle1" type="text" name="question" placeholder="Enter specification Name" value="{{old('question')}}" class="form-control">
                    @error('question')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="summary" class="col-form-label">Answer</label>
                    <textarea class="form-control" id="summary" name="answer">{{old('answer')}}</textarea>
                    @error('answer')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
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
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 120
      });
    });
</script>
@endpush