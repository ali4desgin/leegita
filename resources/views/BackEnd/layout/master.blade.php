<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield("title")</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="{{ url('public/BackEnd/assets/css/bootstrap.css') }}" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="{{ url('public/BackEnd/assets/css/font-awesome.css') }}" rel="stylesheet" />
     <!-- MORRIS CHART STYLES-->
    <link href="{{ url('public/BackEnd/assets/js/morris/morris-0.4.3.min.css') }}" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="{{ url('public/BackEnd/assets/css/custom.css') }}" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
   <link href="{{ url('public/BackEnd/custom.css') }}" rel="stylesheet" />
</head>
<body>
<div id="wrapper">


@include("BackEnd.layout.sidebar")

        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>@yield("title")</h2>   
                        <h5>@yield("description")</h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                    @yield("content")
                </div>
             <!-- /. PAGE INNER  -->
    </div>
</div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="{{ url('public/BackEnd/assets/js/jquery-1.10.2.js') }}"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{ url('public/BackEnd/assets/js/bootstrap.min.js') }}"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="{{ url('public/BackEnd/assets/js/jquery.metisMenu.js') }}"></script>
     <!-- MORRIS CHART SCRIPTS -->
     <script src="{{ url('public/BackEnd/assets/js/morris/raphael-2.1.0.min.js') }}"></script>
    <script src="{{ url('public/BackEnd/assets/js/morris/morris.js') }}"></script>
      <!-- CUSTOM SCRIPTS -->
      <!-- METISMENU SCRIPTS -->
     <!-- DATA TABLE SCRIPTS -->
    <script src="{{ url('public/BackEnd/assets/js/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ url('public/BackEnd/assets/js/dataTables/dataTables.bootstrap.js') }}"></script>
    <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>



    <script src="{{ url('public/BackEnd/assets/js/custom.js') }}"></script>
    <script src="{{ url('public/BackEnd/custom.js') }}"></script>
   
</body>
</html>
