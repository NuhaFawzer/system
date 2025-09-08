// Sample event data
const events = [
    {
        id: 1,
        title: "Central Park Cleanup",
        date: "September 20, 2025 • 9:00 AM - 12:00 PM",
        image: "images/event1.jpg",
        description: "Help keep our beloved Central Park clean and beautiful for everyone to enjoy.",
        volunteersNeeded: 20,
        volunteersSignedUp: 15
    },
    {
        id: 2,
        title: "Food Bank Assistance",
        date: "September 22, 2025 • 10:00 AM - 2:00 PM",
        image: "images/event2.jpg",
        description: "Help sort and package food donations for distribution to families in need.",
        volunteersNeeded: 15,
        volunteersSignedUp: 10
    },
    {
        id: 3,
        title: "After School Tutoring",
        date: "September 25, 2025 • 3:00 PM - 5:00 PM",
        image: "images/event3.jpg",
        description: "Provide academic support and mentorship to elementary school students.",
        volunteersNeeded: 10,
        volunteersSignedUp: 8
    }
];

// DOM Elements
const eventsContainer = document.getElementById('eventsContainer');
const loginBtn = document.getElementById('loginBtn');

const loginModal = document.getElementById('loginModal');

const closeButtons = document.querySelectorAll('.close');
const loginForm = document.getElementById('loginForm');


// Display events on page load
document.addEventListener('DOMContentLoaded', function() {
    displayEvents();
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Display events in the events container
function displayEvents() {
    if (!eventsContainer) {
        throw new Error('eventsContainer element not found in the DOM');
    }
    eventsContainer.innerHTML = '';
    events.forEach(event => {
        const eventCard = document.createElement('div');
        eventCard.classList.add('event-card');
        eventCard.innerHTML = `
            <div class="event-image" style="background-image: url('${event.image}');"></div>
            <div class="event-details">
                <div class="event-date">${event.date}</div>
                <h3>${event.title}</h3>
                <p>${event.description}</p>
                <div class="event-stats">
                    <span>${event.volunteersNeeded} volunteers needed</span>
                    <span>${event.volunteersSignedUp} signed up</span>
                </div>
                <a href="#" class="btn">Apply</a>
            </div>
        `;
        eventsContainer.appendChild(eventCard);
    });
}

// Modal functionality
loginBtn.addEventListener('click', function(e) {
    e.preventDefault();
    loginModal.style.display = 'block';
});



closeButtons.forEach(button => {
    button.addEventListener('click', function() {
        loginModal.style.display = 'none';
       
    });
});

window.addEventListener('click', function(e) {
    if (e.target === loginModal) {
        loginModal.style.display = 'none';
    }
    
});

// Form submissions
// Form submissions
loginForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get the error div
    const errorDiv = document.getElementById('loginError');
    
    // Reset error message
    errorDiv.style.display = 'none';
    errorDiv.textContent = '';
    
    // Gather form data
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const userType = document.getElementById('loginUserType').value;

    // Basic validation
    if (!username || !email || !password || !userType) {
        showError(errorDiv, 'Please fill in all fields.');
        return;
    }

    // Email format validation (simple version)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError(errorDiv, 'Please enter a valid email address.');
        return;
    }

    console.log('Login attempt:', { username, email, password, userType });
    
    // SIMULATION: Replace this with actual API call to your server
    simulateLogin(username, email, password, userType, errorDiv);
});

// Function to simulate a login API call (Replace with real fetch() to your backend)
function simulateLogin(username, email, password, userType, errorDiv) {
    // This is a mock function. In reality, you would send a request to your server.
    
    // Simulate network delay
    setTimeout(() => {
        // Mock successful login for demonstration
        // In a real scenario, success would be determined by the server response
        const isSuccess = true; // Change to false to simulate failed login

        if (isSuccess) {
            // On success - clear form and redirect
            loginForm.reset();
            loginModal.style.display = 'none';
            
            if (userType === 'volunteer') {
                window.location.href = 'volunteer.php';
            } else if (userType === 'organization') {
                window.location.href = 'organization_dashboard.php';
            }
        } else {
            // On failure - show error
            showError(errorDiv, 'Invalid username, email or password. Please try again.');
        }
    }, 1000); // Simulate 1 second network delay
}

// Helper function to display errors
function showError(errorElement, message) {
    errorElement.textContent = message;
    errorElement.style.display = 'block';
}

// Demo button functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn') && e.target.getAttribute('href') === '#') {
        e.preventDefault();
        
    }
});
// Hidden Admin Login Button Functionality
document.querySelector('.copyright').addEventListener('dblclick', function() {
    document.getElementById('adminLoginBtn').style.display = 'block';
});