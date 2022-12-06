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
                        {{-- <div class="card-header text-center"> --}}
                            {{-- <img src="{{ asset('images/spsch.jpg') }}" alt="Image" class="img-thumbnail" width="600px" height="130px"> --}}
                            {{-- <img src="{{ asset('images/dataaudit.jpg') }}" alt="Image" class="img-thumbnail" width="135px" height="135px"> --}}
                            {{-- <img src="{{ asset('images/logo150.png') }}" alt="Image" class="img-thumbnail" width="135px" height="135px"> --}}
                        {{-- </div> --}}
                        <div class="row"> 
                            <div class="col"></div> 
                            <div class="col-md-2">&nbsp;&nbsp; 
                            <img src="{{ asset('images/dataaudit.jpg') }}" alt="Image" class="img-thumbnail shadow-lg mt-2" width="100px" height="100px"> 
                            </div>  
                            {{-- <div class="col"></div> --}}
                        </div>
                        <div class="card-body">
        
                            <form action="{{ route('c.check_sit') }}" method="GET">
                            @csrf

                                <div class="row mt-3">
                                    <div class="col"></div>
                                    <div class="col-md-2 text-end">
                                        <div class="mb-3">
                                            <label for="pid" class="form-label">เลขบัตรประชาชน </label>                           
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="check_cid" name="check_cid" required>                       
                                        </div>
                                    </div> 
                                    <div class="col-md-1 text-end">
                                        <div class="mb-3">
                                            <label for="pid" class="form-label">Token </label>                           
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" id="token" name="token" value="{{$datatotal}}" readonly>                       
                                        </div>
                                    </div>                       
                                    <div class="col"></div>           
                                </div>
                                
                                {{-- <hr> --}}
                                
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col-md-4"> 
                                            <button type="submit" class="btn btn-primary shadow-lg"><i class="fa-brands fa-medrt me-2"></i>Check </button> 
                                            <a href="{{url('/')}}" class="btn btn-danger shadow-lg ms-2"><i class="fa-solid fa-circle-arrow-left me-2"></i>ย้อนกลับ</a>  
                                        
                                    </div> 
                                    {{-- <div class="col"></div> --}}
                                </div>
                            </form>
                            <hr>

                        

                        </div>
                    </div>
                </div>
                <div class="col"></div> 
                  
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
            
           
    </script>

</body>

</html>
