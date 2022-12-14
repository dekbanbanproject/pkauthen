<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="{{asset('js/plugins/select2/css/select2.min.css')}}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Edu VIC WA NT Beginner', cursive;
        }
    
        body {
            width: 100%;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)),
                url(/pkclaim/public/sky16/images/bgPK00.jpg)no-repeat 50%; 
            background-size: cover;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
        }
    
        .container {
            position: relative;
        }
    
        
        &::hover {
            background: aliceblue;
            color: gray;
            font-weight: 500;
        }
    
        .circle1 {
            position: absolute;
            width: 290px;
            height: 290px;
            background: rgba(240, 248, 255, 0.1);
            border-radius: 50%;
            top: 70%;
            left: 95%;
            z-index: -1;
            animation: float 2s 0.5s ease-in-out infinite;
        }
    
        .circle2 {
            position: absolute;
            width: 190px;
            height: 190px;
            background: rgba(240, 248, 255, 0.1);
            border-radius: 50%;
            top: -15%;
            right: 25%;
            z-index: -1;
            animation: float 2s ease-in-out infinite;
        }
    
        .circle3 {
            position: absolute;
            width: 230px;
            height: 230px;
            background: rgba(240, 248, 255, 0.1);
            border-radius: 50%;
            top: 50%;
            right: 95%;
            z-index: -1;
            animation: float 2s 0.7s ease-in-out infinite;
        }
    
        @keyframes float {
            0% {
                transform: translateY(0);
            }
    
            50% {
                transform: translateY(-20px);
            }
    
            100% {
                transform: translateY(0);
            }
        }
    </style>
</head>

<body >
{{-- <br><br>  --}}
 
    <div class="container">
        <div class="circle1"> </div>
        <div class="circle2"> </div>
        <div class="circle3"> </div>
        <div class="flex justify-center">  
            <div class="row"> 
                <div class="col"></div> 
                <div class="col-md-11">
                    <div class="card shadow-lg"> 
                        <div class="card-header text-center">
                            <img src="{{ asset('images/spsch.jpg') }}" alt="Image" class="img-thumbnail" width="600px" height="130px">
                            {{-- <img src="{{ asset('images/dataaudit.jpg') }}" alt="Image" class="img-thumbnail" width="135px" height="135px"> --}}
                            <img src="{{ asset('images/logo150.png') }}" alt="Image" class="img-thumbnail" width="135px" height="135px">
                        </div>
                        <div class="card-body">
                            <form action="{{ route('authencode') }}" method="POST" id="insert_AuthencodeForm">
                                @csrf
        
                            <input type="hidden" class="form-control" id="pid" name="pid" value="{{ $collection1 }}">
                            <input type="hidden" class="form-control" id="fname" value="{{ $collection2 }}">
                            <input type="hidden" class="form-control" id="lname" value="{{ $collection3 }}">
                            <input type="hidden" class="form-control" id="mainInscl" value="{{ $collection6 }}">
                            <input type="hidden" class="form-control" id="subInscl" value="{{ $collection7 }}"> 
                            <input type="hidden" class="form-control" id="birthDate" value="{{ $collection4 }}">
                            <input type="hidden" class="form-control" id="transDate" value="{{ $collection5 }}">
                            <input type="hidden" class="form-control" id="checkDate" value="{{ $collection11 }}">

                            <input type="hidden" class="form-control" id="person_id" name="person_id" value="{{$person_id}}"> 
                        <input type="hidden" class="form-control" id="hos_guid" name="hos_guid" value="{{$hos_guid}}">  
                        {{-- <input type="hidden" class="form-control" id="ovst_key" name="ovst_key" value="{{$getovst_key}}">  --}}
                        <input type="hidden" class="form-control" id="transDate" name="transDate" value="{{$collection5}}">
                        <input type="hidden" class="form-control" id="checkDate" value="{{ $collection11 }}">

                            {{-- @if ($collection12 == '') --}}
                            {{-- <input type="text" class="form-control" id="hcode" name="hcode" > --}}
                            {{-- @else --}}
                                {{-- <label for="hcode" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection12 }}</label> --}}
                                {{-- <input type="hidden" class="form-control" id="hcode" name="hcode" value="{{$collection12}}"> --}}
                            {{-- @endif  --}}
                        
                            <div class="row mt-4">
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label">เลขบัตรประชาชน :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label" style="color: rgb(197, 8, 33)">{{$collection1}} </label>                     
                                    </div>
                                </div> 
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label">ชื่อ-นามสกุล  :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label" style="color: rgb(197, 8, 33)">{{$fname}}  {{$lname}}</label>     
                                        {{-- {{$birthday}}  --}}
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label">สิทธิหลัก :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label" style="color: rgb(197, 8, 33)">({{$maininscl}}) {{$maininscl_name}}</label>                     
                                    </div>
                                </div> 
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label">สิทธิ์ย่อย :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="fname" class="form-label" style="color: rgb(197, 8, 33)">{{$subinscl}}  {{$subinscl_name}}</label>                     
                                    </div>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="birthDate" class="form-label">วันเกิด :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3"> 
                                        <label for="birthDate" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection4 }}</label>
                                        <input type="hidden" class="form-control" id="birthDate" value="{{ $collection4 }}">
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="checkDate" class="form-label">อายุ :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3"> 
                                        <label for="checkDate" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection8 }}</label>
                                        <input type="hidden" class="form-control" id="checkDate" value="{{ $collection8 }}"> 
                                    </div>
                                </div>                                
                            </div>                            
                            <hr>
                            @foreach ($patient as $item)  
                            <?php
                            if ($collection1 != '') {
                                $datapatient = DB::table('patient')->where('cid','=',$collection1)->first();
                                $cid = $datapatient->hometel; 
                                } else {
                                    $cid = '';
                                } 
                                
                                if ($datapatient->hn != null) {
                                    $hn = $datapatient->hn;
                                } else {
                                    $hn = '';
                                }  
                                if ($datapatient->hcode != null) {
                                    $hcode = $datapatient->hcode;
                                } else {
                                    $hcode = '';
                                }                                                     
                            ?>
                            @endforeach
                           

                            <div class="row">
                                <div class="col-md-2 text-end">
                                    <div class="mb-3"> 
                                        <label for="claimType" class="form-label">ประเภทเข้ารับบริการ :</label>   
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3"> 
                                        <input class="form-check-input me-3" type="radio" name="claimType" id="claimType" value="PG0060001" checked> 
                                            <label class="form-check-label" for="claimType">
                                                เข้ารับบริการรักษาทั่วไป (OPD/ IPD/ PP) 
                                            </label> 
                                    </div>
                                </div>  
                                <div class="col-md-2 text-end">
                                    <div class="mb-3"> 
                                        <label for="claimType" class="form-label">HN :</label>   
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="mb-3"> 
                                        @if ($hn == '')
                                            <input type="text" class="form-control" id="hn" name="hn">
                                        @else
                                            <label for="hn" class="form-label" style="color: rgb(197, 8, 33)">{{ $hn }}</label>
                                            <input type="hidden" class="form-control" id="hn" name="hn" value="{{$hn}}">
                                        @endif
                                    </div>
                                </div>                                                                        
                            </div>
                            <div class="row">
                                <div class="col-md-2 text-end">
                                    <div class="mb-3"> 
                                        <label for="claimType" class="form-label"> </label>   
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3"> 
                                        <input class="form-check-input me-3" type="radio" name="claimType" id="claimType2" value="PG0120001"> 
                                            <label class="form-check-label" for="claimType2">
                                                UCEP PLUS (ผู้ป่วยกลุ่มอาการสีเหลืองและสีแดง) 
                                            </label>                                
                                    </div>
                                </div>  
                                <div class="col-md-2 text-end">
                                    <div class="mb-3"> 
                                        <label for="claimType" class="form-label">hmain :</label>   
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="mb-3"> 
                                        <label for="hmain" class="form-label" style="color: rgb(197, 8, 33)">{{ $hmain }}</label>
                                        <input type="hidden" class="form-control" id="hmain" name="hmain" value="{{$hmain}}"> 
                                    </div>
                                </div>    
                                <div class="col-md-1 text-end">
                                    <div class="mb-3"> 
                                        <label for="claimType" class="form-label">hsub :</label>   
                                    </div>
                                </div>
                                <div class="col-md-1 ">
                                    <div class="mb-3"> 
                                        <label for="hsub" class="form-label" style="color: rgb(197, 8, 33)">{{ $hsub }}</label>
                                        <input type="hidden" class="form-control" id="hsub" name="hsub" value="{{$hsub}}"> 
                                    </div>
                                </div>                                                                           
                            </div>
                            <div class="row">
                                <div class="col-md-2 text-end">
                                    <div class="mb-3"> 
                                        <label for="claimType" class="form-label"> </label>   
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3"> 
                                        <input class="form-check-input me-3" type="radio" name="claimType" id="claimType3" value="PG0130001"> 
                                            <label class="form-check-label" for="claimType3">
                                                บริการฟอกเลือดด้วยเครื่องไตเทียม (HD) 
                                            </label>                          
                                    </div>
                                </div>  
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="transDate" class="form-label">pttype no :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-2 ">
                                    <div class="mb-3">  
                                        <label for="pttypeno" class="form-label" style="color: rgb(197, 8, 33)">{{ $cardid }}</label>
                                        <input type="hidden" class="form-control" id="pttypeno" name="pttypeno" value="{{$cardid}}"> 
                                    </div>  
                                </div>  
                                <div class="col-md-1 text-end">
                                    <div class="mb-3">
                                        <label for="pttype" class="form-label">pttype :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mb-3"> 
                                        <label for="pttype" class="form-label" style="color: rgb(197, 8, 33)">{{ $subinscl }}</label>
                                        <input type="hidden" class="form-control" id="pttype" name="pttype" value="{{$subinscl}}">   
                                    </div>
                                </div>           
                                
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="correlationId" class="form-label">correlationId :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3"> 
                                        <label for="correlationId" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection10 }}</label>
                                        <input type="hidden" class="form-control" id="correlationId" name="correlationId" value="{{ $collection10 }}">
                                    </div>
                                </div>  
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="expire_date" class="form-label">วันที่หมดสิทธิย่อย :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3"> 
                                        <label for="expire_date" class="form-label" style="color: rgb(197, 8, 33)">{{ $expire_date }}</label>
                                        <input type="hidden" class="form-control" id="expire_date" name="expire_date" value="{{$expire_date}}">   
                                    </div>
                                </div>  
                                {{-- <div class="col-md-1 text-end">
                                    <div class="mb-3">
                                        <label for="transDate" class="form-label">transDate :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3"> 
                                        <label for="transDate" class="form-label" style="color: rgb(197, 8, 33)">{{ $collection5 }}</label>
                                       
                                    </div>
                                </div> --}}
                            </div>

                           
                            <div class="row">
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="mobile" class="form-label">ยืนยันเบอร์โทรศัพท์ :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">  
                                        @if ($cid == '')
                                            <input type="text" class="form-control" id="mobile" name="mobile" required>
                                        @else
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{$hometel}}">
                                        @endif
                                        
                                    </div>
                                </div>   
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                        <label for="spclty2" class="form-label">แผนก :</label>                           
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3"> 
                                        
                                        <select id="spclty" name="spclty" class="form-select form-select-lg" style="width: 100%"> 
                                            @foreach ($get_spclty as $getspc)
                                                <option value="{{ $getspc->spclty }}"> {{ $getspc->name }} </option>
                                            @endforeach
                                    </select>
                                    </div>
                                </div>                                                                              
                            </div>
                        </div>
                            <div class="card-footer">
                                <div class="col-md-12 text-end">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary shadow-lg me-2"><i class="fa-brands fa-medrt me-2"></i> 
                                            ออก Authen Code Only
                                        </button>
                                        <button type="button" class="btn btn-success shadow-lg me-2" id="authencodeVisit"><i class="fa-brands fa-medrt me-2"></i> 
                                            ออก Authen Code + Visit
                                        </button>
                                       
                                        <a href="{{url('/')}}" class="btn btn-danger shadow-lg"><i class="fa-solid fa-circle-arrow-left me-2"></i>ย้อนกลับ</a> 
                                    </div>
                                </div>
                            </div>
 

                        </div>
                
                        </form> 
                    </div> 
                </div> 
                <div class="col"></div> 
        </div>
    </div>
    {{-- <button type="button" id="Saveauthen">Saveauthen</button> --}}

    <script src="{{asset('js/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#spclty').select2({
                    placeholder: "--เลือก--",
                    allowClear: true
                });

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
                                // window.location.reload();  
                                window.location="{{url('/')}}"; 
                            }
                            })      
                        }
                        }
                });
            });
                // $('#Saveauthen').click(function() {
                //     var hsub = $('#hsub').val();
                //     alert(hsub);
                // });   

                $('#authencodeVisit').click(function() {
                    var pid = $('#pid').val();
                    var hn = $('#hn').val();
                    var hcode = $('#hcode').val();
                    var hos_guid = $('#hos_guid').val();                
                    var claimType = $('#claimType').val();
                    var correlationId = $('#correlationId').val();
                    var ovst_key = $('#ovst_key').val(); 
                    var mobile = $('#mobile').val(); 
                    var spclty = $('#spclty').val(); 
                    var pttype = $('#pttype').val(); 
                    var pttypeno = $('#pttypeno').val(); 

                    var expire_date = $('#expire_date').val();
                    var hmain = $('#hmain').val();
                    var hsub = $('#hsub').val();
                    alert(hsub);
                    $.ajax({
                        url: "{{ route('a.authen_save') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            pid,hn,hcode,hos_guid,spclty,pttype,pttypeno,expire_date,hmain,hsub,
                            claimType,correlationId,ovst_key,mobile
                        },
                        success: function(data) {
                            if (data.status == 200) {
                                Swal.fire({
                                    title: 'ออก Authen Code + Visit สำเร็จ',
                                    text: "You Get Authen Code success",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#06D177',
                                    confirmButtonText: 'เรียบร้อย'
                                }).then((result) => {
                                    if (result
                                        .isConfirmed) {
                                        console.log(
                                            data);
                                        window.location="{{url('/')}}";  
                                    }
                                })
                            } else {
                            }
                        },
                    });
                });
            });
      
    </script>

</body>

</html>
