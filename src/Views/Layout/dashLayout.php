<!DOCTYPE html>
<html lang="en"> 

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="css/adminlte.css">
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/2.1.6/js/dataTables.min.js"></script>
    
    <!--Swal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> 
    <div class="app-wrapper"> 
        <nav class="app-header navbar navbar-expand bg-body"> 
            <div class="container-fluid"> 
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
                </ul>
                <ul class="navbar-nav ms-auto"> 

                    <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <img src="/img/person-circle.svg" class="user-image rounded-circle shadow" alt="User Image"> <span class="d-none d-md-inline">Administrator</span> </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg animate__animated animate__fadeIn">
                            <li class="dropdown-header text-center">
                              <img src="/img/person-circle.svg" class="img-fluid rounded-circle mb-2" alt="User Image" style="width: 60px; height: 60px;">
                              <p class="mb-1 fw-bold">Administrator</p>
                              <small class="text-muted">admin@example.com</small>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                              <a href="#" class="dropdown-item">
                                <i class="fas fa-user me-2"></i> Profile
                              </a>
                            </li>
                            <li>
                              <a href="#" class="dropdown-item">
                                <i class="fas fa-cog me-2"></i> Settings
                              </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                              <a href="/logout" class="dropdown-item mb-3">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                              </a>
                            </li>
                          </ul>
                    </li> 
                </ul> 
            </div> 
        </nav> 
        
        
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="" class="brand-link"> 
                    <!-- <img src="" alt="Img Logo" class="brand-image opacity-75 shadow">  -->
                    <span class="brand-text fw-light">PK-Gas Abdullah</span> 
                </a> 
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2"> 
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-header">Menu</li>
                        <li class="nav-item"> <a href="dashboard" class="nav-link"> <i class="bi bi-activity"></i></i>
                            <p>Dashboard</p>
                        </a> </li>
                       
                        <li class="nav-item"> <a href="/data-gas" class="nav-link"> <i class="bi bi-clipboard-data"></i>
                            <p>Data Gas</p>
                        </a> </li>

                        <li class="nav-item"> <a href="/data-customer" class="nav-link"> <i class="bi bi-people"></i>
                            <p>Data Customer</p>
                        </a> </li>
                      
                    </ul>
                </nav>
            </div> 
        </aside> 

        <main class="app-main">
           <?php echo $content; ?>
        </main> 
        <footer class="app-footer">
            <strong>PK-Gas Abdullah</strong> 
        </footer> 
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="js/adminlte.js"></script>
    <script src="/js/pklelpijiabdullahsec.js"></script>
</body>
</html>