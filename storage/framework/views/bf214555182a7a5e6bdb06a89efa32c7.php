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
                    <?php if(auth()->guard()->check()): ?>
                        <a class="nav-link" href="<?php echo e(route('admin.prices')); ?>">Admin</a>
                    <?php else: ?>
                        <a class="nav-link" href="<?php echo e(route('login')); ?>">Admin</a>
                    <?php endif; ?>
                </li>

            </ul>

            <a href="/#prediction" class="btn btn-success px-4">
                Try Now
            </a>

        </div>

    </div>

</nav><?php /**PATH C:\Users\Rama\OneDrive\Documents\Semester 8\Skripsi\skripsi-buah2\resources\views/partials/navbar.blade.php ENDPATH**/ ?>