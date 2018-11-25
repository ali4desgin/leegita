<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('admin/dashboard') }}">Binary admin</a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> Last access : 30 May 2014 &nbsp; <a href="{{ url('admin/logout') }}" class="confirm btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="{{ url('public/BackEnd/assets/img/find_user.png') }}" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <a class="active-menu"  href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                     <li>
                        <a  href="{{ url('admin/categories') }}"><i class="fa fa-desktop"></i> Categories <span class="pull-right">320</span></a>
                    </li>
                    <li  >
                        <a   href="{{ url('admin/customers') }}"><i class="fa fa-bar-chart-o"></i> Customers <span class="pull-right">100</span></a>
                    </li>
                    <li  >
                        <a   href="{{ url('admin/merchants') }}"><i class="fa fa-bar-chart-o"></i> Merchants <span class="pull-right">3200</span></a>
                    </li>


                    <li>
                        <a  href="{{ url('admin/orders') }}"><i class="fa fa-bars"></i> Orders <span class="pull-right">3200</span> </a>
                    </li>
                    <li>
                        <a  href="{{ url('admin/settings') }}"><i class="fa fa-bars"></i> Settings</a>
                    </li>
					                   
                    <!--<li>
                        <a href="#"><i class="fa fa-sitemap"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link</a>
                            </li>
                            <li>
                                <a href="#">Second Level Link<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Link</a>
                                    </li>

                                </ul>
                               
                            </li>
                        </ul>
                      </li>  
                  <li  >
                        <a  href="blank.html"><i class="fa fa-square-o"></i> Blank Page</a>
                    </li>	-->
                </ul>
               
            </div>
            
        </nav>  