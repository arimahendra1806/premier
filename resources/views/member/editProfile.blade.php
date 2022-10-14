@extends('layouts.index')
<!-- Section untuk title -->
@section('title', 'Edit Profile Member')<!-- 
<?php $subtitle=" Edit Profile Member"; ?> -->

<!-- Section untuk content -->
@section('content')
<div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Edit Profile Member</h2>
          </div>
        </div>
  	  <section class="no-padding-top">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <div class="messages-block block">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-8">
                        <div class="title"><strong class="d-block">Edit Detail Profil Member</strong></div>
                      </div>
                    </div>
                    @foreach ($data as $ndata)
                    <form action="/member/updateProfile/{{$ndata->id_member}}" method="POST">
                    @csrf
                      <div class="row">
                        <div class="col-lg-12">
                          <label class="form-control-label">Nama</label>
                          <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control mb-3" placeholder="" value="{{$ndata->nama_lengkap}}">
                        </div>
                      </div>
                      <input type="text" id="id_user" name="id_user" class="form-control" value="{{$ndata->id_user}}" hidden="">
                      <div class="row">
                        <div class="col-lg-12">
                          <label class="form-control-label">Alamat</label>
                          <input type="text" id="alamat" name="alamat" class="form-control mb-3" placeholder="" value="{{$ndata->alamat}}">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <label class="form-control-label">No. Telepon</label>
                          <input type="text" id="no_hp" name="no_hp" class="form-control mb-3" placeholder="" value="{{$ndata->no_hp}}">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <label class="form-control-label">Password Baru</label>
                          <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password Baru" value="" onkeyup="check()">
                            <div class="input-group-append">
                              <span class="input-group-text">
                                <div>
                                  <svg style="cursor:pointer" width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="myFunction()">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 7C0.555556 4.66667 3.33333 0 10 0C16.6667 0 19.4444 4.66667 20 7C19.4444 9.52778 16.6667 14 10 14C3.31853 14 0.555556 9.13889 0 7ZM10 5C8.89543 5 8 5.89543 8 7C8 8.10457 8.89543 9 10 9C11.1046 9 12 8.10457 12 7C12 6.90536 11.9934 6.81226 11.9807 6.72113C12.2792 6.89828 12.6277 7 13 7C13.3608 7 13.6993 6.90447 13.9915 6.73732C13.9971 6.82415 14 6.91174 14 7C14 9.20914 12.2091 11 10 11C7.79086 11 6 9.20914 6 7C6 4.79086 7.79086 3 10 3C10.6389 3 11.2428 3.14979 11.7786 3.41618C11.305 3.78193 11 4.35535 11 5C11 5.09464 11.0066 5.18773 11.0193 5.27887C10.7208 5.10171 10.3723 5 10 5Z" fill="#4E4B62"/>
                                  </svg>
                                </div>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <label class="form-control-label">Konfirmasi Password Baru</label>
                          <div class="input-group">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password Baru" value="" onkeyup="check()">
                            <div class="input-group-append">
                              <span class="input-group-text">
                                <div>
                                  <svg style="cursor:pointer" width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="myFunction2()">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 7C0.555556 4.66667 3.33333 0 10 0C16.6667 0 19.4444 4.66667 20 7C19.4444 9.52778 16.6667 14 10 14C3.31853 14 0.555556 9.13889 0 7ZM10 5C8.89543 5 8 5.89543 8 7C8 8.10457 8.89543 9 10 9C11.1046 9 12 8.10457 12 7C12 6.90536 11.9934 6.81226 11.9807 6.72113C12.2792 6.89828 12.6277 7 13 7C13.3608 7 13.6993 6.90447 13.9915 6.73732C13.9971 6.82415 14 6.91174 14 7C14 9.20914 12.2091 11 10 11C7.79086 11 6 9.20914 6 7C6 4.79086 7.79086 3 10 3C10.6389 3 11.2428 3.14979 11.7786 3.41618C11.305 3.78193 11 4.35535 11 5C11 5.09464 11.0066 5.18773 11.0193 5.27887C10.7208 5.10171 10.3723 5 10 5Z" fill="#4E4B62"/>
                                  </svg>
                                </div>
                              </span>
                            </div>
                          </div>
                          <span id='message'></span>
                        </div>
                      </div><br>
                    <div class="row">
                      <div class="col-lg-12">
                        <button type="submit" class="btn btn-warning float-right">Simpan</button>
                      </div>
                    </div>
                    @endforeach
                  </form>
                  </div>
                </div>
              </div>
             </div>
           </div>
      </section>
@endsection

@push('js')
  <script>
    var check = function() {
      if (document.getElementById('password').value ==
        document.getElementById('confirm_password').value) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = '*Sesuai';
      } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = '*Tidak sesuai';
      }
    }
  </script>
  <script>
		function myFunction() {
		  var x = document.getElementById("password");
		  if (x.type === "password") {
		    x.type = "text";
		  } else {
		    x.type = "password";
		  }
		}
	</script>
  <script>
    function myFunction2() {
      var x = document.getElementById("confirm_password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
@endpush
