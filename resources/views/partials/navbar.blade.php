<nav class="navbar navbar-expand-lg bg-white bg-opacity-75 backdrop-blur sticky-top border-bottom border-light">

    <div class="container py-2">

        <a class="navbar-brand fw-bold fs-4 text-success" href="/">
            <i class="bi bi-apple"></i>
            FruitVision AI
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#features">Features</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#classes">Classes</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#how-to-use">How to Use</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/#prediction">Prediction</a>
                </li>

                <li class="nav-item">
                    @auth
                        <a class="nav-link" href="{{ route('admin.prices') }}">Admin</a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Admin</a>
                    @endauth
                </li>

            </ul>

            <a href="/#prediction" class="btn btn-success px-4">
                Try Now
            </a>

        </div>

    </div>

</nav>