<div class="container">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-lg-10 col-md-10 col-sm-10">
            <nav class="navbar navbar-expand-lg bg-primary navbar-dark rounded-2 m-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <img src="images/upgates-sign-white.svg" alt="" width="25px">
                        Dochazka
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="/dochazka">Přidat docházku ručně</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">Události</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/calendar">Kalendář</a></li>
                                    <li><a class="dropdown-item" href="/udalost/create">Vytvořit</a></li>
                                    <li><a class="dropdown-item" href="/udalost/moje">Moje</a></li>
                                </ul>
                            </li>
                        </ul>
                        <span class="navbar-text px-3">
                            <a href="/out" class="float-end" style="text-decoration: none;"><?php echo $username ?> - Odhlásit se</a>
                        </span>
                    </div>
                </div>
            </nav>
        </div>
        <div class="col-sm-1"></div>
    </div>
</div>