<nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            <!-- Navbar Header--><a href="index.html" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Premier</strong><strong>Futsal</strong></div>
              <div class="brand-text brand-sm"><strong class="text-primary">P</strong><strong>F</strong></div></a>
            <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>
          @if(Auth::check() && Auth::user()->role == "admin")
          <div class="right-menu list-inline no-margin-bottom">    
            <!-- <div class="list-inline-item"><a href="#" class="search-open nav-link"><i class="icon-magnifying-glass-browser"></i></a></div> -->
            <!-- {{ Auth::user()->name }} -->
            <!-- Tasks-->
            <div class="list-inline-item dropdown"><a id="navbarDropdownMenuLink2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link tasks-toggle" onClick="btnNotif();"><i class="icon-new-file"></i><span class="badge dashbg-3">@stack('notif')</span></a>
            </div>
            <!-- Log out               -->
            <div class="list-inline-item logout"><a id="logout" href="/logout" class="nav-link"> <span class="d-none d-sm-inline">Logout </span><i class="icon-logout"></i></a></div>
            @else
            <div class="list-inline-item logout"><a id="logout" href="/logout" class="nav-link"> <span class="d-none d-sm-inline">Logout </span><i class="icon-logout"></i></a></div>
            @endif
          </div>
        </div>
      </nav>
    </header>