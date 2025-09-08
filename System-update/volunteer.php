<?php
session_start();

// ✅ Only allow volunteers
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Volunteer') {
    header("Location: index.php");
    exit();
}

// Optional: fetch user info for display
$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Volunteer Dashboard</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .dashboard {
      display: grid;
      grid-template-columns: 1fr 3fr;
      gap: 20px;
      margin-top: 20px;
    }

  .dashboard-header {
  background: white;
  padding: 15px 0;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  margin-bottom: 20px;
}

.header-flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header-flex h1 {
  margin-left: 20px;   /* extra gap from left */
  font-size: 1.8rem;
  color: var(--primary);
}

.header-flex a {
  margin-right: 20px;  /* push logout away from edge */
}



    .sidebar {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .notifications {
      margin-top: 20px;
    }
    .notification {
      background: #f1f9f1;
      border: 1px solid #4CAF50;
      padding: 10px;
      border-radius: 6px;
      margin-bottom: 10px;
      font-size: 0.9rem;
    }
    .events-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
  </style>
</head>
<body>
  <header class="dashboard-header">
  <div class="container header-flex">
   <a href="index.php"> <h1>Welcome Volunteer!</h1></a>
   <div> <a href="index.php" class="btn btn-secondary">Logout</a>
    <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
    <a href="delete_profile.php" class="btn btn-primary">Delete Profile</a>
  <a href="profile.php" class="btn btn-primary">View Profile</a>
  
  </div></div>
</header>

<script>
    const updateBtn = document.getElementById('updateProfileBtn');
    const updateForm = document.getElementById('updateFormContainer');

    updateBtn.addEventListener('click', () => {
        if (updateForm.style.display === 'none') {
            updateForm.style.display = 'block';
        } else {
            updateForm.style.display = 'none';
        }
    });
</script>

  <section class="dashboard container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h3>Your Preferences</h3>
      <label for="categorySelect">Choose Volunteering Category:</label>
      <select id="categorySelect">
        <option>Education</option>
        <option>Environment</option>
        <option>Healthcare</option>
        <option>Community Development</option>
        <option>Animal Welfare</option>
      </select>

      <div class="notifications">
        <h3>Notifications</h3>
        <div id="notificationsList"></div>
      </div>
      <div>
          <a href="submit_impact.php" class="btn btn-secondary">Submit Event Impact</a>
  </div>
    </aside>


    <!-- Main Content -->
    <div>
      <h2>All Ongoing Volunteer Programs</h2>
      <div class="events-container" id="volunteerEvents"></div>
    </div>
  </section>

  <script src="script_volunteer.js"></script>
  <script>
    // Add categories to sample events
    events.forEach((e, i) => {
      const categories = ["Environment","Healthcare","Education"];
      e.category = categories[i % categories.length];
    });

    const container = document.getElementById('volunteerEvents');
    const categorySelect = document.getElementById('categorySelect');
    const notificationsList = document.getElementById('notificationsList');

    // Load saved category
    const savedCategory = localStorage.getItem('volunteerCategory');
    if (savedCategory) {
      categorySelect.value = savedCategory;
    }

    // Render events
    function renderEvents() {
      container.innerHTML = '';
      events.forEach(ev => {
        const card = document.createElement('div');
        card.classList.add('event-card');
        card.innerHTML = `
          <div class="event-image" style="background-image: url('${ev.image}');"></div>
          <div class="event-details">
            <h3>${ev.title}</h3>
            <p><strong>Category:</strong> ${ev.category}</p>
            <p>${ev.description}</p>
            <form method="POST" action="event_register.php">
      <input type="hidden" name="event_id" value="${ev.id}">
      <button type="submit" class="btn">Apply</button>
    </form>
          </div>
        `;
        container.appendChild(card);
      });

      document.querySelectorAll('.apply-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          alert("Your application for this event has been sent!");
          console.log("Volunteer applied for event ID:", btn.dataset.id);
        });
      });
    }

    // Render notifications
   function renderNotifications() {
  notificationsList.innerHTML = '';
  const category = categorySelect.value;
  const filtered = events.filter(e => e.category === category);

  if (filtered.length === 0) {
    notificationsList.innerHTML = '<p>No new events in your category.</p>';
  } else {
    filtered.forEach(ev => {
      const note = document.createElement('div');
      note.classList.add('notification');
      note.innerHTML = `
        New ${category} event: <strong>${ev.title}</strong>
        <button class="btn btn-sm apply-note-btn" data-id="${ev.id}" style="margin-left:10px;">Apply</button>
      `;
      notificationsList.appendChild(note);
    });
  }

  // Add click functionality for notification apply buttons
  document.querySelectorAll('.apply-note-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      alert("Your application for this event has been sent!");
      console.log("Volunteer applied via notification for event ID:", btn.dataset.id);
    });
  });
}

    // Save preference & refresh notifications
    categorySelect.addEventListener('change', () => {
      localStorage.setItem('volunteerCategory', categorySelect.value);
      renderNotifications();
    });

    // Initial load
    renderEvents();
    renderNotifications();
  </script>
</body>
</html>