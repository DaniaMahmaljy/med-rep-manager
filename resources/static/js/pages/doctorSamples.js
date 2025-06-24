const repSelect = document.getElementById('representative_id');
const repVisitsBtnWrapper = document.getElementById('rep-visits-button');
const repVisitsBtn = document.getElementById('view-rep-visits-btn');

repSelect.addEventListener('change', function () {
    const repId = this.value;

    if (repId) {
        repVisitsBtn.href = `${window.APP_BASE_URL || ''}/representatives/${repId}/visits`;

        repVisitsBtnWrapper.style.visibility = 'visible';
    } else {
        repVisitsBtnWrapper.style.visibility = 'hidden';
    }
});





document.addEventListener('DOMContentLoaded', function () {
    const doctorSelect = document.getElementById('doctor_id');
    const container = document.getElementById('samples-container');
    const form = document.querySelector('#visit-form');

    doctorSelect.addEventListener('change', async function () {
        const doctorId = this.value;

        if (!doctorId) {
            container.innerHTML = `<div class="alert alert-info">Please select a doctor</div>`;
            return;
        }

        container.innerHTML = `<div class="text-center py-3"><div class="spinner-border" role="status"></div></div>`;

        try {
            const response = await fetch(`${window.APP_BASE_URL || ''}/samples/by-doctor/${doctorId}`, {
            headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
            }

            });

            if (!response.ok) throw new Error('Failed to fetch samples');

            const samples = await response.json();

            if (!samples.length) {
                container.innerHTML = `<div class="alert alert-warning">No matching samples found for this doctor’s specialty.</div>`;
                return;
            }

            container.innerHTML = `
                <div class="row g-3">
                    ${samples.map(sample => `
                        <div class="col-md-6">
                            <div class="card h-100 ${isExpired(sample.expiration_date) ? 'border-danger' : ''}">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input sample-checkbox"
                                               type="checkbox"
                                               data-id="${sample.id}"
                                               id="sample_${sample.id}"
                                               ${sample.quantity_available <= 0 ? 'disabled' : ''}>
                                        <label class="form-check-label" for="sample_${sample.id}">
                                            <strong>${sample.name}</strong>
                                            <div class="text-muted small mt-1">
                                                <span class="d-block"><i class="bi bi-box-seam"></i>
                                                    ${sample.quantity_available} ${sample.unit_label || ''}</span>
                                                ${sample.expiration_date ? `
                                                <span class="d-block ${isExpired(sample.expiration_date) ? 'text-danger' : ''}">
                                                    <i class="bi bi-calendar-x"></i> ${formatDate(sample.expiration_date)}
                                                </span>` : ''}
                                            </div>
                                        </label>
                                        <input type="number"
                                               class="form-control  form-control-sm  mt-2 sample-quantity-input"
                                               placeholder="Quantity"
                                               min="1"
                                               max="${sample.quantity_available}"
                                               data-sample-id="${sample.id}"
                                               style="display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;

            attachCheckboxEvents();

        } catch (error) {
            container.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i> ${error.message}
                </div>
            `;
        }
    });

    function attachCheckboxEvents() {
        document.querySelectorAll('.sample-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const id = this.dataset.id;
                const input = document.querySelector(`.sample-quantity-input[data-sample-id="${id}"]`);
                if (this.checked) {
                    input.style.display = 'block';
                    input.required = true;
                } else {
                    input.style.display = 'none';
                    input.required = false;
                    input.value = '';
                    const errorEl = input.nextElementSibling;
                    if (errorEl && errorEl.classList.contains('text-danger')) {
                        errorEl.remove();
                    }
                }
            });
        });
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        console.log('Form submit intercepted');

        document.querySelectorAll('.text-danger.small').forEach(el => el.remove());

        const formData = new FormData(form);

        const samples = [];
        let invalidQuantity = false;

        document.querySelectorAll('.sample-checkbox:checked').forEach(checkbox => {
            const id = checkbox.dataset.id;
            const quantityInput = document.querySelector(`.sample-quantity-input[data-sample-id="${id}"]`);
            const quantity = parseInt(quantityInput.value, 10);

            if (!quantity || quantity < 1) {
                invalidQuantity = true;
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('text-danger', 'small');
                errorDiv.textContent = 'Please enter a valid quantity for the selected sample.';
                quantityInput.insertAdjacentElement('afterend', errorDiv);
                return;
            }

            samples.push({ id, quantity_assigned: quantity });
        });

        if (invalidQuantity) return;

        const payload = {
            doctor_id: formData.get('doctor_id'),
            representative_id: formData.get('representative_id'),
            scheduled_at: formData.get('scheduled_at'),
            notes: formData.get('notes'),
            samples
        };

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            });

            const text = await response.text();

            try {
                const result = JSON.parse(text);

                if (response.ok) {
                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                    }
                } else if (response.status === 422) {
                    console.log('Validation errors:', result.errors);

                    const errors = result.errors;
                    for (const field in errors) {
                        const message = errors[field][0];

                        if (field.startsWith('samples')) {
                            const generalError = document.createElement('div');
                            generalError.classList.add('text-danger', 'small');
                            generalError.textContent = message;
                            container.insertAdjacentElement('beforebegin', generalError);
                        } else {
                            let input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                const errorDiv = document.createElement('div');
                                errorDiv.classList.add('text-danger', 'small');
                                errorDiv.textContent = message;
                                input.insertAdjacentElement('afterend', errorDiv);
                            }
                        }
                    }
                } else {
                    throw new Error(result.message || 'Unknown error');
                }
            } catch (jsonParseError) {
                console.error('Failed to parse JSON:', jsonParseError, 'Response text:', text);
                alert('Server returned invalid response. Check console for details.');
            }

        } catch (error) {
            console.error(error);
            alert('Something went wrong: ' + error.message);
        }
    });

    function isExpired(dateString) {
        return dateString && new Date(dateString) < new Date();
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString();
    }
});
