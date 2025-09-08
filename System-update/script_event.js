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

// DOM element for events container
const eventsContainer = document.getElementById('eventsContainer');

// Display events on page load
document.addEventListener('DOMContentLoaded', function() {
    displayEvents();
});

// Function to display events in the container
function displayEvents() {
    if (!eventsContainer) return;

    eventsContainer.innerHTML = ''; // Clear previous content

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
