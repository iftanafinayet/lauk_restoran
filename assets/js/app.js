// Restaurant App JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    // Auto-hide alerts after 5 seconds
    autoHideAlerts();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize image previews
    initializeImagePreviews();
    
    // Initialize smooth scrolling
    initializeSmoothScrolling();
}

function autoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.transition = 'all 0.5s ease';
                alert.style.opacity = '0';
                alert.style.maxHeight = '0';
                alert.style.margin = '0';
                alert.style.padding = '0';
                alert.style.overflow = 'hidden';
                
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, 5000);
    });
}

function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    showFieldError(field, 'Field ini wajib diisi.');
                } else {
                    clearFieldError(field);
                }
            });

            if (!isValid) {
                e.preventDefault();
                showToast('Harap lengkapi semua field yang wajib.', 'warning');
            }
        });
    });
}

function initializeImagePreviews() {
    document.querySelectorAll('input[type="file"][accept^="image"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                previewImage(this, file);
            }
        });
    });
}

function previewImage(input, file) {
    const reader = new FileReader();
    const previewId = input.id + '-preview';
    let preview = document.getElementById(previewId);
    
    if (!preview) {
        preview = document.createElement('div');
        preview.id = previewId;
        preview.className = 'image-preview mt-2';
        input.parentNode.appendChild(preview);
    }

    reader.onload = function(e) {
        preview.innerHTML = `
            <div class="position-relative d-inline-block">
                <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">
                <button type="button" class="btn-close position-absolute top-0 end-0 bg-white" 
                        onclick="this.parentElement.remove()"></button>
            </div>
        `;
    };
    
    reader.readAsDataURL(file);
}

function initializeSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

function showFieldError(field, message) {
    field.classList.add('is-invalid');
    field.classList.remove('is-valid');
    
    let feedback = field.parentNode.querySelector('.invalid-feedback');
    if (!feedback) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        field.parentNode.appendChild(feedback);
    }
    feedback.textContent = message;
}

function clearFieldError(field) {
    field.classList.remove('is-invalid');
    field.classList.add('is-valid');
    
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.remove();
    }
}

function showToast(message, type = 'info') {
    // Remove existing toasts
    document.querySelectorAll('.custom-toast').forEach(toast => toast.remove());

    const toast = document.createElement('div');
    toast.className = `alert alert-${type} custom-toast position-fixed`;
    toast.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    toast.innerHTML = `
        <div class="d-flex justify-content-between align-items-center">
            <span>${message}</span>
            <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}

// Global functions
function confirmAction(message = 'Apakah Anda yakin?') {
    return confirm(message);
}

function orderMenu(menuId, menuName) {
    const phoneNumber = '6281380304519';
    const message = `Halo Lauk Resto, saya ingin memesan:\n\n*${menuName}*\n\nBisa info harga dan ketersediaannya?`;
    const encodedMessage = encodeURIComponent(message);
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    
    window.open(whatsappUrl, '_blank');
}