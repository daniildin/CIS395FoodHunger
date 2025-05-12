<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meal Prep Logs</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/bootstrap-icons.css" rel="stylesheet">
  <link href="../css/templatemo-kind-heart-charity.css" rel="stylesheet">
  <style>
    .header-bar {
      background-color: #0033a0;
      padding: 0.5rem 1rem;
    }
    .header-contact {
      font-size: 1.05rem;
      color: white;
    }
    .table-container {
      background: white;
      padding: 2rem;
      border-radius: 0.75rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    tr:hover {
      background-color: #e0f7fa;
    }
    footer {
      background-color: #003366;
      padding: 40px 0;
    }
    footer p, footer small {
      color: #ffffff !important;
    }
  </style>
</head>
<body style="background-color: #f5f5f5; font-family: 'Metropolis', sans-serif; min-height: 100vh; display: flex; flex-direction: column;">

  <!-- Header Bar -->
  <div class="header-bar">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-4 text-start text-white">
          <div class="fw-bold">BMCC Food Support</div>
          <div style="color: #ffcc00;">Healthy Food Deficit Project</div>
        </div>
        <div class="col-md-4 text-center">
        <a href="../index.html">
            <img src="../images/header2.png" alt="BMCC Logo" style="max-height: 110px;">
          </a>
        </div>
        <div class="col-md-4 text-end header-contact">
          <div><i class="bi-geo-alt me-1"></i> Borough of Manhattan Community College, NY</div>
          <div><i class="bi-envelope me-1"></i> <a href="mailto:foodbmcc@info.edu" class="text-white">foodbmcc@info.edu</a></div>
          <div><i class="bi-telephone me-1"></i> 212-555-0123</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <main style="flex: 1 0 auto;">
    <section class="section-padding section-bg">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 table-container">
            <h2 class="text-center mb-4">Meal Prep Logs</h2>
            <?php
              include '../db.php';
              $result = $conn->query("SELECT * FROM meal_prep");
              echo "<table class='table'>
                <thead class='table-light'>
                  <tr>
                    <th>Prep ID</th>
                    <th>Meal ID</th>
                    <th>Volunteer ID</th>
                    <th>Prep Date</th>
                  </tr>
                </thead>
                <tbody>";
              while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['prep_id']}</td><td>{$row['meal_id']}</td><td>{$row['volunteer_id']}</td><td>{$row['prep_date']}</td></tr>";
              }
              echo "</tbody></table>";
            ?>
          </div>
        </div>

        <!-- About Card Section -->
        <div class="row justify-content-center mt-5">
          <div class="col-md-10">
            <div class="card shadow-sm border-0">
              <div class="card-header fw-bold text-white py-2 px-3" style="background-color: #0033a0;">
                <i class="bi-info-circle-fill me-2"></i> About This Project
              </div>
              <div class="card-body">
                <p class="mb-0" style="font-size: 1.05rem;">
                  This page displays all logged meal preparation records for the BMCC Healthy Food Deficit Project. Volunteers and meals are tracked to help ensure transparency, efficiency, and food security for students.
                </p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="text-center mt-auto">
    <p class="mb-0">
      Healthy Food Deficit Project — BMCC CIS395 Final Project<br>
      <small>&copy; 2025 Borough of Manhattan Community College. All rights reserved.</small>
    </p>
  </footer>

  <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
