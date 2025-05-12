<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meals List</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/bootstrap-icons.css" rel="stylesheet">
  <link href="../css/templatemo-kind-heart-charity.css" rel="stylesheet">
  <style>
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

    .header-bar {
      background-color: #0033a0;
      padding: 0.5rem 1rem;
    }

    .header-contact {
      font-size: 1.05rem;
      color: white;
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
            <h2 class="text-center mb-4">Meals List</h2>
            <?php
              include '../db.php';
              $result = $conn->query("SELECT * FROM meals");
              echo "<table class='table'>
                <thead class='table-light'>
                  <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Ingredients</th>
                    <th>Day</th>
                    <th>Pickup</th>
                  </tr>
                </thead>
                <tbody>";
              while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['meal_id']}</td><td>{$row['meal_type']}</td><td>{$row['ingredients']}</td><td>{$row['meal_day']}</td><td>{$row['pickup_location']}</td></tr>";
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
                  This table shows all meal records available to BMCC students through the Healthy Food Deficit Project. Meals are categorized by type, day, ingredients, and pickup location to support efficient food distribution and accessibility.
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
