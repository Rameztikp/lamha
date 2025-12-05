// Function to open the profile settings modal
function openProfileModal() {
    // Create modal element if it doesn't exist
    if (!document.getElementById('profileModal')) {
        const modal = document.createElement('div');
        modal.id = 'profileModal';
        modal.className = 'modal';
        modal.style.display = 'none';
        modal.style.position = 'fixed';
        modal.style.zIndex = '1000';
        modal.style.left = '0';
        modal.style.top = '0';
        modal.style.width = '100%';
        modal.style.height = '100%';
        modal.style.overflow = 'auto';
        modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
        
        // Create modal content
        const modalContent = document.createElement('div');
        modalContent.className = 'modal-content';
        modalContent.style.backgroundColor = '#fefefe';
        modalContent.style.margin = '5% auto';
        modalContent.style.padding = '20px';
        modalContent.style.border = '1px solid #888';
        modalContent.style.width = '80%';
        modalContent.style.maxWidth = '700px';
        modalContent.style.borderRadius = '8px';
        modalContent.style.position = 'relative';
        modalContent.style.maxHeight = '90vh';
        modalContent.style.overflowY = 'auto';
        
        // Add close button
        const closeBtn = document.createElement('span');
        closeBtn.innerHTML = '&times;';
        closeBtn.className = 'close';
        closeBtn.style.position = 'absolute';
        closeBtn.style.right = '20px';
        closeBtn.style.top = '10px';
        closeBtn.style.fontSize = '28px';
        closeBtn.style.fontWeight = 'bold';
        closeBtn.style.cursor = 'pointer';
        closeBtn.onclick = closeProfileModal;
        
        // Add content container
        const content = document.createElement('div');
        content.id = 'profileModalContent';
        content.style.padding = '20px';
        
        // Add loading message
        content.innerHTML = '<p>جاري التحميل...</p>';
        
        // Assemble modal
        modalContent.appendChild(closeBtn);
        modalContent.appendChild(content);
        modal.appendChild(modalContent);
        document.body.appendChild(modal);
        
        // Close when clicking outside the modal
        window.onclick = function(event) {
            if (event.target === modal) {
                closeProfileModal();
            }
        };
    }
    
    // Show the modal
    document.getElementById('profileModal').style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Load the profile form via AJAX
    fetch('/profile/settings')
        .then(response => response.text())
        .then(html => {
            // Extract only the form content from the response
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const form = doc.querySelector('form[action*="/profile/update"]');
            
            if (form) {
                // Update the form action to use the modal's form submission
                form.onsubmit = function(e) {
                    e.preventDefault();
                    const formData = new FormData(form);
                    
                    fetch('/profile/update', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else if (data.message) {
                            // Show success message
                            const messageDiv = document.createElement('div');
                            messageDiv.className = 'alert alert-success';
                            messageDiv.textContent = data.message;
                            
                            const content = document.getElementById('profileModalContent');
                            content.insertBefore(messageDiv, content.firstChild);
                            
                            // Remove message after 3 seconds
                            setTimeout(() => {
                                messageDiv.remove();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                };
                
                document.getElementById('profileModalContent').innerHTML = '';
                document.getElementById('profileModalContent').appendChild(form);
            } else {
                document.getElementById('profileModalContent').innerHTML = '<p>حدث خطأ أثناء تحميل النموذج. يرجى تحديث الصفحة والمحاولة مرة أخرى.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading profile form:', error);
            document.getElementById('profileModalContent').innerHTML = '<p>حدث خطأ أثناء تحميل النموذج. يرجى تحديث الصفحة والمحاولة مرة أخرى.</p>';
        });
}

// Function to close the profile settings modal
function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Add event listener for profile settings link
document.addEventListener('DOMContentLoaded', function() {
    const profileLink = document.querySelector('a[href*="profile/settings"]');
    if (profileLink) {
        profileLink.addEventListener('click', function(e) {
            e.preventDefault();
            openProfileModal();
        });
    }
});
