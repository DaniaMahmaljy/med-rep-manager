document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('create-user');
    const sections = {
        supervisor: document.getElementById('supervisor-section'),
        representative: document.getElementById('representative-section')
    };

    function showSection(type) {
        Object.values(sections).forEach(section => {
            if (section) section.classList.add('d-none');
        });

        if (sections[type]) {
            sections[type].classList.remove('d-none');
        }
    }

    document.querySelectorAll('input[name="user_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) showSection(this.id);
        });
    });

    const checkedRadio = document.querySelector('input[name="user_type"]:checked');
    if (checkedRadio) {
        showSection(checkedRadio.id);
    } else {
        const supervisorRadio = document.getElementById('supervisor');
        if (supervisorRadio) {
            supervisorRadio.checked = true;
            showSection('supervisor');
        }
    }

    if (form) {
        const submitButton = form.querySelector('button[type="submit"]');
        form.addEventListener('submit', function() {
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Processing...
                `;
            }
        });
    }
});
