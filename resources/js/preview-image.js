document.addEventListener('DOMContentLoaded', () => {
    const previewInputs = document.querySelectorAll('[data-preview-target]');

    previewInputs.forEach((input) => {
        input.addEventListener('change', (event) => {
            const target = document.querySelector(event.currentTarget.dataset.previewTarget);
            const file = event.currentTarget.files?.[0];

            if (!target || !file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = () => {
                target.src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    });
});
