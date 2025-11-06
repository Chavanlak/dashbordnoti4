<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Responsive Table</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }
    /* Sidebar */
    .sidebar {
      height: 100vh;
      background-color: #343a40;
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      padding-top: 60px;
    }
    .sidebar a {
      color: #adb5bd;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #495057;
      color: #fff;
    }

    /* Content */
    /* Content */
.content {
  margin-left: 240px;
  padding: 20px;
  padding-top: 80px; /* ✅ เพิ่มระยะห่างจาก Navbar */
}

/* Mobile adjustments */
@media (max-width: 768px) {
  .sidebar {
    display: none;
  }
  .content {
    margin-left: 0;
    padding-top: 80px; /* ✅ ให้เว้นระยะใน mobile ด้วย */
  }
}


    /* Card hover */
    .card {
      border-radius: 10px;
      transition: all 0.3s ease;
    }
    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>

  <!-- 🔹 Navbar -->
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
        ☰
      </button>
      <a class="navbar-brand ms-2" href="#">My Dashboard</a>
    </div>
  </nav>

  <!-- 🔹 Sidebar (Desktop) -->
  <div class="sidebar d-none d-md-block">
    <a href="#" class="active">🏠 Dashboard</a>
    <a href="#">👤 Members</a>
    <a href="#">📅 Bookings</a>
    <a href="#">📊 Reports</a>
    <a href="#">⚙️ Settings</a>
  </div>

  <!-- 🔹 Sidebar (Mobile Offcanvas) -->
  <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menu</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <a href="#" class="d-block text-white mb-2">🏠 Dashboard</a>
      <a href="#" class="d-block text-white mb-2">👤 Members</a>
      <a href="#" class="d-block text-white mb-2">📅 Bookings</a>
      <a href="#" class="d-block text-white mb-2">📊 Reports</a>
      <a href="#" class="d-block text-white mb-2">⚙️ Settings</a>
    </div>
  </div>

  <!-- 🔹 Content -->
  <div class="content mt-4">
    <div class="container-fluid">
      <h4 class="mb-4">Repair List</h4>

      <!-- 🖥️ Table (Desktop/Tablet) -->
      <div class="table-responsive d-none d-md-block">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>JobID</th>
              <th>Name</th>
              <th>dateReceiveFromBranch (วันรับของ)</th>
              {{-- <th>dateSenttoSubplier</th> --}}
              <th>เเจ้ง Supplier(ส่งซ่อม)</th>
              <th>Supplier ดำเนินการซ่อมเเล้ว (date update)</th>
              {{-- <th>status Technicial</th> --}}
              <th>สถานะการปิดงาน</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>001</td>
              <td>John Doe</td>
              <td>2025-10-19</td>
              <td>2025-10-20</td>
              <td>2025-10-20</td>             
               {{-- <td>กำลังดำเนินการ</td> --}}
              <td class="text-success">ปิดงานเล้ว</td>
            </tr>
            <tr>
              <td>002</td>
              <td>Jane Smith</td>
              <td>2025-10-19</td>
              <td>2025-10-19</td>
              <td>2025-10-20</td>    
              {{-- <td>ยังไม่ซ่อม</td> --}}
              <td class="text-danger">ยังไม่ปิดงาน</td>
            </tr>
            <tr>
              <td>003</td>
              <td>Alex Johnson</td>
              <td>2025-10-19</td>
              <td>2025-10-18</td>
              <td>2025-10-20</td>    
              {{-- <td>ยังไม่ซ่อม</td> --}}
              <td class="text-danger">ยังไม่ปิดงาน</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- 📱 Card (Mobile) -->
      <div class="d-block d-md-none">
        <div class="card mb-3 shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-1">John Doe</h5>
            <p class="card-text mb-1"><strong>JobID:</strong> 001</p>
            <p class="card-text mb-1"><strong>Room:</strong> 101</p>
            <p class="card-text"><small class="text-muted">Created: 2025-10-20</small></p>
          </div>
        </div>

        <div class="card mb-3 shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-1">Jane Smith</h5>
            <p class="card-text mb-1"><strong>ID:</strong> 002</p>
            <p class="card-text mb-1"><strong>Room:</strong> 203</p>
            <p class="card-text"><small class="text-muted">Created: 2025-10-19</small></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
