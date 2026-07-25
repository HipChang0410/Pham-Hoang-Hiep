document.querySelectorAll('.img-input').forEach(function (input) {
    input.addEventListener('change', function () {
        const preview = this.closest('.img-group').querySelector('.img-preview');
        if (!preview) {
            return;
        }

        preview.innerHTML = '';
        Array.from(this.files || []).forEach(function (file) {
            const objectUrl = URL.createObjectURL(file);
            const img = document.createElement('img');
            img.src = objectUrl;
            img.width = 120;
            img.className = 'img-thumbnail me-2 mb-2';
            preview.appendChild(img);
        });
    });
});
