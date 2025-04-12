document.addEventListener('DOMContentLoaded', function () {
    const sections = {
        admin: null,
        supervisor: document.getElementById('supervisor-section'),
        representative: document.getElementById('representative-section'),
    };

    const radios = document.querySelectorAll('input[name="user_type"]');
    const form = document.getElementById('create-user');
    let submitButton;

    if (form) {
        submitButton = form.querySelector('button[type="submit"]');

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

    function showSection(type) {
        Object.values(sections).forEach(section => {
            if (section) section.classList.add('d-none');
        });

        if (sections[type]) {
            sections[type].classList.remove('d-none');
            const requiredFields = sections[type].querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.required = true;
            });
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) showSection(this.id);
        });
    });

    const checkedRadio = document.querySelector('input[name="user_type"]:checked');
    const oldUserType = '{{ old("user_type") }}';

    if (checkedRadio) {
        showSection(checkedRadio.id);
    }
    else if (oldUserType) {
        const typeToId = {
            '{{ App\Enums\UserTypeEnum::ADMIN->value }}': 'admin',
            '{{ App\Enums\UserTypeEnum::SUPERVISOR->value }}': 'supervisor',
            '{{ App\Enums\UserTypeEnum::REPRESENTATIVE->value }}': 'representative'
        };

        const sectionId = typeToId[oldUserType];
        if (sectionId) {
            const radio = document.getElementById(sectionId);
            if (radio) {
                radio.checked = true;
                showSection(sectionId);
            }
        }
    }
});
