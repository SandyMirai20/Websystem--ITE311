/**
 * Dashboard JavaScript
 * Handles session timeout, activity monitoring, and other dashboard interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Session timeout settings (in milliseconds)
    const SESSION_TIMEOUT = 15 * 60 * 1000; // 15 minutes
    const WARNING_TIME = 2 * 60 * 1000; // Show warning 2 minutes before timeout
    
    let warningTimer;
    let timeoutTimer;
    let countdownInterval;
    
    // Session modal elements
    const sessionModal = new bootstrap.Modal(document.getElementById('sessionTimeoutModal'));
    const countdownElement = document.getElementById('countdown');
    const extendSessionBtn = document.getElementById('extendSession');
    
    // Reset timers on user activity
    const resetTimers = () => {
        clearTimeout(warningTimer);
        clearTimeout(timeoutTimer);
        clearInterval(countdownInterval);
        
        // Set new timers
        warningTimer = setTimeout(showWarning, SESSION_TIMEOUT - WARNING_TIME);
        timeoutTimer = setTimeout(logout, SESSION_TIMEOUT);
    };
    
    // Show warning modal
    const showWarning = () => {
        let timeLeft = WARNING_TIME / 1000; // Convert to seconds
        
        // Update countdown every second
        countdownInterval = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = Math.floor(timeLeft % 60);
            countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
            } else {
                timeLeft--;
            }
        }, 1000);
        
        // Show modal
        sessionModal.show();
    };
    
    // Logout function
    const logout = () => {
        // Close the modal if open
        sessionModal.hide();
        
        // Redirect to logout URL
        window.location.href = '/logout';
    };
    
    // Extend session
    const extendSession = async () => {
        try {
            const response = await fetch('/api/session/refresh', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                credentials: 'same-origin'
            });
            
            if (response.ok) {
                // Reset timers on successful extension
                resetTimers();
                sessionModal.hide();
                
                // Show success message
                showToast('Session extended successfully', 'success');
            } else {
                throw new Error('Failed to extend session');
            }
        } catch (error) {
            console.error('Error extending session:', error);
            showToast('Failed to extend session. Please save your work and refresh the page.', 'danger');
        }
    };
    
    // Show toast notification
    const showToast = (message, type = 'info') => {
        // Check if toast container exists, if not create one
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.style.position = 'fixed';
            toastContainer.style.top = '20px';
            toastContainer.style.right = '20px';
            toastContainer.style.zIndex = '9999';
            document.body.appendChild(toastContainer);
        }
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.role = 'alert';
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        // Add auto-hide after 5 seconds
        const bsToast = new bootstrap.Toast(toast, { delay: 5000 });
        
        // Toast content
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        // Add to container and show
        toastContainer.appendChild(toast);
        bsToast.show();
        
        // Remove from DOM after hiding
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    };
    
    // Event Listeners
    document.addEventListener('mousemove', resetTimers);
    document.addEventListener('keydown', resetTimers);
    document.addEventListener('click', resetTimers);
    document.addEventListener('scroll', resetTimers);
    
    // Extend session button
    if (extendSessionBtn) {
        extendSessionBtn.addEventListener('click', extendSession);
    }
    
    // Logout button in modal
    const logoutBtn = document.querySelector('#sessionTimeoutModal .btn-secondary');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', logout);
    }
    
    // Initialize timers
    resetTimers();
    
    // Check for unread notifications
    checkUnreadNotifications();
});

// Check for unread notifications
async function checkUnreadNotifications() {
    try {
        const response = await fetch('/api/notifications/unread-count', {
            credentials: 'same-origin'
        });
        
        if (response.ok) {
            const data = await response.json();
            if (data.count > 0) {
                updateNotificationBadge(data.count);
            }
        }
    } catch (error) {
        console.error('Error checking notifications:', error);
    }
}

// Update notification badge
function updateNotificationBadge(count) {
    let badge = document.getElementById('notification-badge');
    if (!badge) {
        const bellIcon = document.querySelector('.notification-bell');
        if (bellIcon) {
            badge = document.createElement('span');
            badge.id = 'notification-badge';
            badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
            bellIcon.parentNode.appendChild(badge);
        }
    }
    
    if (badge) {
        badge.textContent = count > 9 ? '9+' : count;
        badge.style.display = 'block';
    }
}

// Initialize tooltips
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Initialize popovers
function initPopovers() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

// Initialize charts
function initCharts() {
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        return;
    }
    
    // Example chart initialization
    const ctx = document.getElementById('progressChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Not Started'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#e9ecef'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${percentage}% (${value})`;
                            }
                        }
                    }
                }
            }
        });
    }
}

// Initialize when DOM is fully loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        initTooltips();
        initPopovers();
        initCharts();
    });
} else {
    initTooltips();
    initPopovers();
    initCharts();
}

// Export functions for use in other modules if needed
window.dashboardUtils = {
    showToast,
    checkUnreadNotifications,
    updateNotificationBadge,
    initTooltips,
    initPopovers,
    initCharts
};
