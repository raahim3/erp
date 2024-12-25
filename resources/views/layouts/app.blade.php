@php( $setting = \App\Models\General::where('company_id',auth()->user()->company_id)->first() )
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ $setting->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ $setting->description }}" name="description" />
    <meta content="Themesbrand" name="author" />
    @if($setting->favicon)
        <link rel="shortcut icon" href="{{ asset('uploads/logos'.'/'.$setting->favicon) }}">
    @else
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    @endif
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css" rel="stylesheet">
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <style>
        .dropify-wrapper .dropify-message span.file-icon{
            font-size: 30px !important;
        }
    </style>
    @include('partials.color')   
</head>
    <body data-sidebar="dark">

        <div id="layout-wrapper">

            @include('partials.header')

            @include('partials.sidebar')
            
            <div class="main-content">
                <div class="page-content">
                    @yield('content') 
                </div>
            </div>
            @include('partials.footer')
        </div>


        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

        <!--Morris Chart-->
        <script src="{{ asset('assets/libs/morris.js/morris.min.js') }}"></script>
        <script src="{{ asset('assets/libs/raphael/raphael.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

        @yield('script')
        <script>
            @if(session('success'))
                $.toast({ 
                    text : "<h5>{{ session('success') }}</h5>", 
                    showHideTransition : 'slide',  
                    bgColor : '#00BFA5',            
                    textColor : '#fff',       
                    allowToastClose : true,      
                    hideAfter : 5000,             
                    stack : 5,                    
                    textAlign : 'left',           
                    position : 'top-right'     
                })
            @endif
            @if(session('error'))
                $.toast({ 
                    text : "<h5>{{ session('error') }}</h5>", 
                    showHideTransition : 'slide',  
                    bgColor : '#ff0000',            
                    textColor : '#fff',       
                    allowToastClose : true,      
                    hideAfter : 5000,             
                    stack : 5,                    
                    textAlign : 'left',           
                    position : 'top-right'     
                })
            @endif
            $(document).ready(function(){
                $('.dropify').dropify();

                $('#punch_in_out').on('click', function() {
                $(this).prop('disabled', true);
                $(this).html('<i class="mdi mdi-spin mdi-loading"></i> Processing...');
                var _this = $(this);
                var status = $(this).data('id');
                $.ajax({
                    url: "{{ route('punch.in') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            _this.prop('disabled', false);
                            if(status == 1) {
                                _this.html('Punch Out');
                                _this.removeClass('btn-success').addClass('btn-warning');
                                _this.data('id', 0);
                            }else{
                                _this.html('Punch In');
                                _this.removeClass('btn-warning').addClass('btn-success');
                                _this.data('id', 1);
                            }
                        }
                        else{
                            _this.prop('disabled', false);
                            _this.html('Punch In');
                            _this.removeClass('btn-warning').addClass('btn-success');
                            alert(response.error);
                        }
                    },
                    error:function(response){
                        _this.prop('disabled', false);
                        _this.html('Punch In');
                        _this.removeClass('btn-warning').addClass('btn-success');
                        alert(response.error);
                    }   
                });
            });
            });
        </script>
    </body>
</html>