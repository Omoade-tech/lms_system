
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="students.php">Library Management System</a>
                    </li>
                   
                </ul>
             
                <form class="d-flex" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit" data-bs-target="searchBook">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
              

            <!-- Right elements -->
            <div class="d-flex align-items-center ms-3">
                <!-- Avatar -->
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <li><a class="dropdown-item" href="/lms_system/Auth/logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
            <!-- Right elements -->
        </div>
    </nav>
   