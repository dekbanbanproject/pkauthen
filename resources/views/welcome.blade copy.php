<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>รพ.ภูเขียว</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo150.ico') }}">

    <link href="{{ asset('bt52/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Plugin css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body >
<br><br> 
  
    <div class="container">
        <div class="flex justify-center">    
          <div class="row"> 
              <div class="col"></div> 
              <div class="col-md-8">&nbsp;&nbsp;
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <img src="{{ asset('images/spsch.jpg') }}" alt="Image" class="img-thumbnail shadow-lg me-4" width="600px" height="130px">
                        {{-- <img src="{{ asset('images/dataaudit.jpg') }}" alt="Image" class="img-thumbnail shadow-lg" width="135px" height="135px"> --}}
                        <img src="{{ asset('images/logo150.png') }}" alt="Image" class="img-thumbnail" width="135px" height="135px">
                    </div>
                    <div class="card-body"> 
                        <div class="row"> 
                            <div class="col"></div> 
                            <div class="col-md-3">&nbsp;&nbsp;
                              {{-- &nbsp;&nbsp;&nbsp;   --}}
                              {{-- <img src="{{ asset('images/dataaudit.jpg') }}" alt="Image" class="img-thumbnail shadow-lg" width="200px" height="135px"> --}}
                              {{-- <img src="{{ asset('images/logo150.png') }}" alt="Image" class="img-thumbnail" width="250px" height="135px"> --}}
                            </div>  
                            <div class="col"></div>
                        </div>
                        <div class="row"> 
                            <div class="col"></div>
                            <div class="col-md-8 text-center">
                                <div class="mb-3"> 
                                {{-- {{$output}} --}}
                                    {{-- <br>  --}}
                                  {{-- @foreach ($output as $item)
                                    
                                  <label for="pid" class="form-label" style="color: rgb(11, 11, 11);font-size:30px">เครื่องอ่าน SmartCard :  {{$item['terminalName']}}</label>
                                  @endforeach --}}
                                  <br><br>
                                  
                                @if ($smartcard == 'NO_CONNECT' )
                                    <img src="http://localhost:8189/assets/images/smartcard-connected.png" alt="" width="250px"><br> <br>
                                    <label for="pid" class="form-label" style="color: rgb(197, 8, 33);font-size:30px">ไม่พบเครื่องอ่านบัตร</label> <br>
                                  @else
                                        @if ($smartcardcon != 'CID_OK')
                                        <img src="{{ asset('images/card1.jpg') }}" alt="Image" class="img-thumbnail shadow-lg me-4" width="250px">
                                        <br><br>
                                        <label for="pid" class="form-label" style="color: rgb(197, 8, 33);font-size:30px">กรุณาเสียบบัตรประชาชน</label> <br>
                                        @else
                                        <a href="{{url('authen_index')}}" class="btn btn-primary shadow-lg mb-4"> <i class="fa-brands fa-medrt me-2"></i> ออก Authen </a>
                                        @endif
                                  
                                  @endif  
                              
                                    <br>  
                                    
                                    <a href="{{url('authen_cid')}}" class="btn btn-warning shadow-lg">
                                      <i class="fa-regular fa-id-card me-2"></i>
                                          กรณีลืมบัตรประชาชน </a>
                                </div>
                            </div>                       
                            <div class="col"></div>
                        </div> 
                    </div>  
                </div> 
              </div> 
              <div class="col"></div> 
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
            window.setTimeout( function() {
                window.location.reload();
            }, 5000);

            $(document).ready(function () {
                $('#insert_AuthencodeForm').on('submit',function(e){
                  e.preventDefault();              
                  var form = this;
                  $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){
                      $(form).find('span.error-text').text('');
                    },
                    success:function(data){
                      if (data.status == 0 ) {
                        
                      } else {          
                        Swal.fire({
                          title: 'ออก Authen Code สำเร็จ',
                          text: "You Get Authen Code success",
                          icon: 'success',
                          showCancelButton: false,
                          confirmButtonColor: '#06D177',
                          // cancelButtonColor: '#d33',
                          confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                          if (result.isConfirmed) {         
                            window.location.reload();  
                          }
                        })      
                      }
                    }
                  });
            });
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });
                // $('#AuthenCode').click(function() {
                // var pid = $('#pid').val();
                // var claimType = $('#claimType').val();
                // var correlationId = $('#correlationId').val();
                // var hcode = $('#hcode').val(); 
 
                // $.ajax({
                //     url: "{{ route('authencode') }}",
                //     type: "POST",
                //     dataType: 'json',
                //     data: {
                //         pid,
                //         claimType,
                //         correlationId,
                //         hcode
                //     },
                //     success: function(data) {
                //         if (data.status == 200) {
                //             Swal.fire({
                //                 title: 'ออก Authen Code สำเร็จ',
                //                 text: "You Get Authen Code success",
                //                 icon: 'success',
                //                 showCancelButton: false,
                //                 confirmButtonColor: '#06D177',
                //                 confirmButtonText: 'เรียบร้อย'
                //             }).then((result) => {
                //                 if (result
                //                     .isConfirmed) {
                //                     console.log(
                //                         data);
                //                     window.location.reload();
                //                 }
                //             })
                //         } else {

                //         }

                //     },
                // });
            });
            // });
           
    </script>

</body>

</html>
