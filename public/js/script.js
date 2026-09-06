const imageInput = document.getElementById("imageInput");
const previewImage = document.getElementById("previewImage");
const dropArea = document.getElementById("dropArea");

// Inisialisasi Bootstrap tooltip (dipakai oleh ikon info di label Confidence)
document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach((el) => new bootstrap.Tooltip(el));
});


const openCamera = document.getElementById("openCamera");
const cameraSection = document.getElementById("cameraSection");
const camera = document.getElementById("camera");
const captureImage = document.getElementById("captureImage");
const canvas = document.getElementById("canvas");

const predictForm = document.getElementById("predictForm");
const predictBtn = document.getElementById("predictBtn");
const predictBtnIcon = document.getElementById("predictBtnIcon");
const predictBtnText = document.getElementById("predictBtnText");
const predictAlert = document.getElementById("predictAlert");
const predictProgress = document.getElementById("predictProgress");
const resetPredictBtn = document.getElementById("resetPredictBtn");
const weightInput = predictForm ? predictForm.querySelector('input[name="weight"]') : null;

const DEFAULT_PREVIEW_IMAGE = "https://placehold.co/700x500?text=Preview+Image";

let stream = null;

/* ===========================
   Preview Upload
=========================== */

if (imageInput) {

    imageInput.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) return;

        previewImage.src = URL.createObjectURL(file);

        // Jika upload file, hapus hasil kamera
        const cameraInput = document.getElementById("cameraImage");

        if (cameraInput) {
            cameraInput.value = "";
        }

    });

}

/* ===========================
   Drag & Drop
=========================== */

if (dropArea) {

    dropArea.addEventListener("dragover", function (e) {

        e.preventDefault();

        dropArea.classList.add("bg-light");

    });

    dropArea.addEventListener("dragleave", function () {

        dropArea.classList.remove("bg-light");

    });

    dropArea.addEventListener("drop", function (e) {

        e.preventDefault();

        dropArea.classList.remove("bg-light");

        const file = e.dataTransfer.files[0];

        if (!file) return;

        const dataTransfer = new DataTransfer();

        dataTransfer.items.add(file);

        imageInput.files = dataTransfer.files;

        previewImage.src = URL.createObjectURL(file);

        const cameraInput = document.getElementById("cameraImage");

        if (cameraInput) {
            cameraInput.value = "";
        }

    });

}

/* ===========================
   Open Camera
=========================== */

if (openCamera) {

    openCamera.addEventListener("click", async () => {

        if (!window.isSecureContext) {
            alert("Kamera hanya bisa diakses lewat koneksi HTTPS (atau localhost). Silakan buka website ini menggunakan https://, atau gunakan fitur upload gambar sebagai alternatif.");
            return;
        }

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            alert("Browser ini tidak mendukung akses kamera. Silakan gunakan fitur upload gambar sebagai alternatif.");
            return;
        }

        try {

            stream = await navigator.mediaDevices.getUserMedia({

                video: true

            });

            camera.srcObject = stream;

            cameraSection.classList.remove("d-none");

        }

        catch (error) {

            if (error && (error.name === "NotAllowedError" || error.name === "PermissionDeniedError")) {
                alert("Akses kamera ditolak. Izinkan akses kamera di pengaturan browser untuk menggunakan fitur ini.");
            } else if (error && error.name === "NotFoundError") {
                alert("Tidak ditemukan kamera pada perangkat ini.");
            } else {
                alert("Tidak dapat mengakses kamera. Silakan gunakan fitur upload gambar sebagai alternatif.");
            }

        }

    });

}

/* ===========================
   Capture Camera
=========================== */

if (captureImage) {

    captureImage.addEventListener("click", () => {

        const context = canvas.getContext("2d");

        canvas.width = camera.videoWidth;

        canvas.height = camera.videoHeight;

        context.drawImage(

            camera,

            0,

            0,

            canvas.width,

            canvas.height

        );

        const imageData = canvas.toDataURL("image/png");

        previewImage.src = imageData;

        // Simpan base64 ke hidden input
        const cameraInput = document.getElementById("cameraImage");

        if (cameraInput) {

            cameraInput.value = imageData;

        }

        // Kosongkan file upload
        imageInput.value = "";

        // Tutup kamera
        if (stream) {

            stream.getTracks().forEach(track => track.stop());

        }

        cameraSection.classList.add("d-none");

    });

}

/* ===========================
   Helpers
=========================== */

function formatRupiah(number) {

    const value = Number(number) || 0;

    return "Rp " + value.toLocaleString("id-ID", {
        maximumFractionDigits: 0
    });

}

function showAlert(message, type) {

    if (!predictAlert) return;

    predictAlert.className = "alert alert-" + type;

    predictAlert.textContent = message;

    predictAlert.classList.remove("d-none");

}

function hideAlert() {

    if (!predictAlert) return;

    predictAlert.classList.add("d-none");

    predictAlert.textContent = "";

}

function setLoading(isLoading) {

    if (!predictBtn) return;

    predictBtn.disabled = isLoading;

    if (predictBtnIcon) {
        predictBtnIcon.className = isLoading
            ? "spinner-border spinner-border-sm me-2"
            : "bi bi-stars me-2";
    }

    if (predictBtnText) {
        predictBtnText.textContent = isLoading ? "Memproses..." : "Predict Now";
    }

    if (predictProgress) {
        predictProgress.classList.toggle("d-none", !isLoading);
    }

}

function renderResult(data) {

    const confidenceRaw = Number(data.confidence) || 0;

    // Backend may return confidence as a 0-1 fraction or as a 0-100 percentage
    const confidencePct = confidenceRaw <= 1
        ? Math.round(confidenceRaw * 1000) / 10
        : Math.round(confidenceRaw * 10) / 10;

    const fruitLabel = data.fruit || "-";
    const pricePerKgLabel = formatRupiah(data.pricePerKg);
    const totalPriceLabel = formatRupiah(data.totalPrice);

    // Prediction card
    const resultFruit = document.getElementById("resultFruit");
    const resultConfidenceText = document.getElementById("resultConfidenceText");
    const resultConfidenceBar = document.getElementById("resultConfidenceBar");
    const resultPricePerKg = document.getElementById("resultPricePerKg");
    const resultTotalPrice = document.getElementById("resultTotalPrice");

    if (resultFruit) resultFruit.textContent = fruitLabel;

    if (resultConfidenceText) resultConfidenceText.textContent = confidencePct + "%";

    if (resultConfidenceBar) {
        resultConfidenceBar.style.width = confidencePct + "%";
        resultConfidenceBar.textContent = confidencePct + "%";
    }

    if (resultPricePerKg) resultPricePerKg.textContent = pricePerKgLabel;

    if (resultTotalPrice) resultTotalPrice.textContent = totalPriceLabel;

    // "Hasil Prediksi" summary section
    const resultSectionFruit = document.getElementById("resultSectionFruit");
    const resultSectionConfidence = document.getElementById("resultSectionConfidence");
    const resultSectionPrice = document.getElementById("resultSectionPrice");
    const resultSummaryEmpty = document.getElementById("resultSummaryEmpty");
    const resultSummaryFilled = document.getElementById("resultSummaryFilled");

    if (resultSectionFruit) resultSectionFruit.textContent = fruitLabel;

    if (resultSectionConfidence) resultSectionConfidence.textContent = confidencePct + "%";

    if (resultSectionPrice) resultSectionPrice.textContent = totalPriceLabel;

    if (resultSummaryEmpty) resultSummaryEmpty.classList.add("d-none");

    if (resultSummaryFilled) resultSummaryFilled.classList.remove("d-none");

    // Keep showing the image the user already selected/captured.
    // Only fall back to the server-stored image if no preview is showing at all.
    const hasVisiblePreview = previewImage
        && previewImage.src
        && !previewImage.src.includes("placehold.co");

    if (!hasVisiblePreview && data.image && previewImage) {
        previewImage.src = data.image;
    }

    if (resetPredictBtn) {
        resetPredictBtn.classList.remove("d-none");
    }

}

/* ===========================
   Reset (Prediksi Lagi)
=========================== */

function resetPredictionUI() {

    if (predictForm) predictForm.reset();

    if (imageInput) imageInput.value = "";

    const cameraInput = document.getElementById("cameraImage");
    if (cameraInput) cameraInput.value = "";

    if (weightInput) weightInput.value = "";

    if (previewImage) previewImage.src = DEFAULT_PREVIEW_IMAGE;

    if (stream) {
        stream.getTracks().forEach((track) => track.stop());
        stream = null;
    }

    if (cameraSection) cameraSection.classList.add("d-none");

    const resultFruit = document.getElementById("resultFruit");
    const resultConfidenceText = document.getElementById("resultConfidenceText");
    const resultConfidenceBar = document.getElementById("resultConfidenceBar");
    const resultPricePerKg = document.getElementById("resultPricePerKg");
    const resultTotalPrice = document.getElementById("resultTotalPrice");

    if (resultFruit) resultFruit.textContent = "-";
    if (resultConfidenceText) resultConfidenceText.textContent = "0%";
    if (resultConfidenceBar) {
        resultConfidenceBar.style.width = "0%";
        resultConfidenceBar.textContent = "0%";
    }
    if (resultPricePerKg) resultPricePerKg.textContent = "Rp 0";
    if (resultTotalPrice) resultTotalPrice.textContent = "Rp 0";

    const resultSectionFruit = document.getElementById("resultSectionFruit");
    const resultSectionConfidence = document.getElementById("resultSectionConfidence");
    const resultSectionPrice = document.getElementById("resultSectionPrice");
    const resultSummaryEmpty = document.getElementById("resultSummaryEmpty");
    const resultSummaryFilled = document.getElementById("resultSummaryFilled");

    if (resultSectionFruit) resultSectionFruit.textContent = "-";
    if (resultSectionConfidence) resultSectionConfidence.textContent = "-";
    if (resultSectionPrice) resultSectionPrice.textContent = "-";
    if (resultSummaryEmpty) resultSummaryEmpty.classList.remove("d-none");
    if (resultSummaryFilled) resultSummaryFilled.classList.add("d-none");

    hideAlert();

    if (resetPredictBtn) resetPredictBtn.classList.add("d-none");

}

if (resetPredictBtn) {
    resetPredictBtn.addEventListener("click", resetPredictionUI);
}

/* ===========================
   Submit Prediction (AJAX)
=========================== */

if (predictForm) {

    predictForm.addEventListener("submit", async function (e) {

        e.preventDefault();

        hideAlert();

        const hasFile = imageInput && imageInput.files && imageInput.files.length > 0;
        const cameraInput = document.getElementById("cameraImage");
        const hasCameraImage = cameraInput && cameraInput.value;

        if (!hasFile && !hasCameraImage) {
            showAlert("Silakan upload gambar atau gunakan kamera terlebih dahulu.", "danger");
            return;
        }

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : "";

        const formData = new FormData(predictForm);

        setLoading(true);

        try {

            const response = await fetch(predictForm.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: formData
            });

            let data = null;

            try {
                data = await response.json();
            } catch (parseError) {
                data = null;
            }

            if (response.status === 419) {
                showAlert("Sesi Anda telah berakhir. Silakan muat ulang halaman dan coba lagi.", "danger");
                return;
            }

            if (response.status === 422 && data && data.errors) {

                const messages = Object.values(data.errors).flat().join(" ");

                showAlert(messages || "Data yang dikirim tidak valid.", "danger");

                return;

            }

            if (!response.ok || !data || data.success === false) {

                const message = (data && data.message)
                    ? data.message
                    : "Terjadi kesalahan saat memproses prediksi. Silakan coba lagi.";

                showAlert(message, "danger");

                return;

            }

            renderResult(data);

            showAlert("Prediksi berhasil! Lihat hasilnya di bawah.", "success");

        } catch (error) {

            showAlert("Tidak dapat terhubung ke server. Periksa koneksi Anda dan coba lagi.", "danger");

        } finally {

            setLoading(false);

        }

    });

}