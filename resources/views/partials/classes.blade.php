<section id="classes" class="section bg-white">

    <div class="container">

        <div class="text-center mb-5">

            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                AI Model
            </span>

            <h2 class="fw-bold mt-3">
                Kelas Buah yang Didukung
            </h2>

            <p class="text-secondary col-lg-7 mx-auto">
                Model CNN pada FruitVision AI dilatih untuk mengenali 7 kelas objek berikut.
                Kelas <strong>Non-Fruit</strong> digunakan untuk menolak gambar yang bukan
                merupakan buah target, sehingga sistem tidak memaksakan klasifikasi pada
                objek yang tidak relevan.
            </p>

        </div>

        <div class="d-flex flex-wrap justify-content-center gap-4">

            @php
                $classes = [
                    ['name' => 'Apple', 'label' => 'Apel', 'file' => 'apple.png'],
                    ['name' => 'Banana', 'label' => 'Pisang', 'file' => 'banana.png'],
                    ['name' => 'Mango', 'label' => 'Mangga', 'file' => 'mango.png'],
                    ['name' => 'Orange', 'label' => 'Jeruk', 'file' => 'orange.png'],
                    ['name' => 'Pineapple', 'label' => 'Nanas', 'file' => 'pineapple.png'],
                    ['name' => 'Strawberry', 'label' => 'Stroberi', 'file' => 'strawberry.png'],
                    ['name' => 'Non-Fruit', 'label' => 'Objek bukan buah', 'file' => 'nonfruit.png', 'muted' => true],
                ];
            @endphp

            @foreach ($classes as $class)

                <div class="class-card-col">

                    <div class="card feature-card h-100 text-center {{ ($class['muted'] ?? false) ? 'border-secondary-subtle' : '' }}">

                        <div class="ratio ratio-1x1 bg-light rounded-top overflow-hidden">
                            <img
                                src="{{ file_exists(public_path('images/classes/' . $class['file'])) ? asset('images/classes/' . $class['file']) : 'https://placehold.co/300x300?text=' . urlencode($class['name']) }}"
                                alt="Contoh gambar {{ $class['name'] }}"
                                class="w-100 h-100"
                                style="object-fit: cover; {{ ($class['muted'] ?? false) ? 'filter: grayscale(60%);' : '' }}">
                        </div>

                        <div class="card-body p-3">

                            <h6 class="fw-bold mb-0">
                                {{ $class['name'] }}
                            </h6>

                            <small class="text-secondary">
                                {{ $class['label'] }}
                            </small>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>
