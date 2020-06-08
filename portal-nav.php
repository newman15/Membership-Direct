
<style>
    #banner { 
        width:100%;
    }

    /* Mobile padding s*/
    @media only screen and (min-width: 0px) { 
        #banner {
            padding: 0;
        }
    }

    @media only screen and (min-width: 801px) { 
        #banner {
            padding: 0 15% 0 15%;
        }
    }

    @media only screen and (min-width: 1401px) { 
        #banner {
            padding: 0 25% 0 25%;
        }
    }

</style>

<center>
    <img id="banner" src="img/banner_1.jpg" alt="banner_unavail">
</center>
    
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="member-portal.php" data-toggle="tooltip" title="Home">
            <img src="img/mdLogo_dark.jpg" alt="logo" style="width:50px;">
        </a>
  
        <!-- Creates Responsive Nav bar that collapses when resized to mobile dimensions -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav" style="list-style-type:none">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="policy.php">Policy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="billing.php">Billing</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="account.php">Account</a>
                </li>
                <div style="position: absolute; right: 50;">
                    <form action="logout.php" method="POST">
                        <button class="btn btn-outline-secondary" style="float:right" type="submit" name="logout-btn">Logout</button>
                    </form>
                </div>
            </ul>
        </div>
    </nav>