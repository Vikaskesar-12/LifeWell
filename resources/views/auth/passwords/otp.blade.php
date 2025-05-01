<!DOCTYPE html>
<html lang="en">

<head>
@include('backend.layouts.head')

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-otp-image">
              <img src="{{asset('images/logo.svg')}}" alt="Logo" class="img-fluid" style="max-width: 100%; height: auto;">
              </div>
              <div class="col-lg-6">
                <div class="p-5 otp-form">
                  <div class="text-center otp-head">
                    <h1 class="h4 text-gray-900 mb-2">Enter the Otp</h1>
                  </div>
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('confirm.otp') }}">
                        @csrf
                        <div class="form-group otp-block">
                            <input type="hidden" name="email" value="{{ $data->email }}">
                            <div class="otp-verification-input mb-2 d-flex">
                                <input type="text" class="inputs" name="otp[]" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');" onfocus="this.select();" style="width: 40px; height: 40px; text-align: center; margin-right: 5px;" />
                                <input type="text" class="inputs" name="otp[]" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');" onfocus="this.select();" style="width: 40px; height: 40px; text-align: center; margin-right: 5px;" />
                                <input type="text" class="inputs" name="otp[]" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');" onfocus="this.select();" style="width: 40px; height: 40px; text-align: center; margin-right: 5px;" />
                                <input type="text" class="inputs" name="otp[]" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');" onfocus="this.select();" style="width: 40px; height: 40px; text-align: center;" />
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Reset Password
                        </button>
                    </form>
                  <hr>
                  
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
  <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
  <script>
    $(document).ready(function() {
      $('.inputs').on('input', function() {
          if ($(this).val().length >= $(this).attr('maxlength')) {
              $(this).next('.inputs').focus();
          }
        });

        $('.inputs').on('keydown', function(e) {
            // Move to the previous input when backspacing
            if (e.key === 'Backspace' && $(this).val().length === 0) {
                $(this).prev('.inputs').focus();
            }
        });
    });
  </script>

</body>

</html>




