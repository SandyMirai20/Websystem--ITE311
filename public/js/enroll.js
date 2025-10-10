document.addEventListener('DOMContentLoaded', function() {
    // Handle enrollment form submission
    const enrollForms = document.querySelectorAll('.enroll-form');
    
    enrollForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enrolling...';
            
            fetch('/course/enroll', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(formData).toString()
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Failed to enroll');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    showAlert('success', data.message || 'Enrolled successfully!');
                    
                    // Optionally update UI (e.g., change button state)
                    const enrollBtn = form.querySelector('.enroll-btn');
                    if (enrollBtn) {
                        enrollBtn.classList.remove('btn-primary');
                        enrollBtn.classList.add('btn-success');
                        enrollBtn.innerHTML = '<i class="fas fa-check"></i> Enrolled';
                        enrollBtn.disabled = true;
                    }
                    
                    // If there's a redirect URL in the response
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    showAlert('danger', data.message || 'Failed to enroll. Please try again.');
                }
            })
            .catch(error => {
                console.error('Enrollment error:', error);
                showAlert('danger', error.message || 'An error occurred. Please try again.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            });
        });
    });
    
    // Helper function to show alerts
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Find the first alert container or create one at the top of the page
        let alertContainer = document.querySelector('.alert-container');
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.className = 'container mt-3';
            document.body.insertBefore(alertContainer, document.body.firstChild);
        }
        
        // Add the alert to the container
        alertContainer.appendChild(alertDiv);
        
        // Auto-remove alert after 5 seconds
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    }
});
