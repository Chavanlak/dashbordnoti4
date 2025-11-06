<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technician Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; font-family: "Prompt", sans-serif; }
    .navbar { z-index: 1030; }
    /* Content */
    .content {
      padding-top: 90px;
      padding-left: 260px;
      transition: all 0.3s ease;
    }
    /* Sidebar Desktop */
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
      border-radius: 6px;
      transition: 0.2s;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #495057;
      color: #fff;
    }
    /* Mobile adjustments */
    @media (max-width: 768px) {
      .sidebar { display: none; }
      .content { padding-left: 0; padding-top: 70px; }
    }
    /* Status box */
    .status-box {
      border-radius: 10px;
      background: white;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      height: 100%;
    }
    .status-btn {
      width: 100%;
      border-radius: 8px;
      font-weight: 500;
    }
    .date-label {
      font-size: 0.9rem;
      color: #6c757d;
    }
    .status-complete { border-left: 5px solid #28a745; }
    .status-pending { border-left: 5px solid #ffc107; }
    .status-fail { border-left: 5px solid #dc3545; }
    /* Offcanvas Mobile Sidebar */
    .offcanvas-start {
      width: 75%;
      max-width: 300px;
      background-color: #343a40 !important;
      padding-top: 20px;
    }
    .offcanvas-body a {
      display: flex;
      align-items: center;
      padding: 10px 15px;
      margin-bottom: 6px;
      border-radius: 8px;
      color: #adb5bd;
      font-weight: 500;
      text-decoration: none;
    }
    .offcanvas-body a:hover {
      background-color: #495057;
      color: #fff;
    }
    .offcanvas-body a.active {
      background-color: #007bff;
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- 🔹 Navbar และ Sidebar (เหมือนเดิม) -->
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
        ☰
      </button>
      <a class="navbar-brand ms-2" href="#">Technician Dashboard</a>
      <div class="dropdown ms-auto">
        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
          👤 Admin
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><a class="dropdown-item" href="#">Login</a></li>
          <li><a class="dropdown-item text-danger" href="#">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- 🔹 Sidebar Desktop / Offcanvas Mobile (เหมือนเดิม) -->
  <div class="sidebar d-none d-md-block">
    <a href="#" class="active">🏠 Dashboard</a>
    <a href="#">👨‍🔧 Technician Jobs</a>
    <a href="#">📦 Supplier</a>
    <a href="#">📊 Reports</a>
    <a href="#">⚙️ Settings</a>
  </div>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title text-white">Menu</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <a href="#" class="active">🏠 Dashboard</a>
      <a href="#">👨‍🔧 Technician Jobs</a>
      <a href="#">📦 Supplier</a>
      <a href="#">📊 Reports</a>
      <a href="#">⚙️ Settings</a>
    </div>
  </div>

  <!-- 🔹 Content -->
  <div class="content container-fluid">
    <h4 class="mb-4 fw-bold">Technician Job Status</h4>
    
    <!-- ⚠️ ข้อมูลสำคัญที่ต้องส่งกลับไป Controller (Hidden Inputs) -->
    <!-- ต้องสมมติว่าคุณได้กำหนดค่า NotirepairId จาก Blade Template (เช่นจาก Loop) -->
    <input type="hidden" id="NotirepairId" value="12345"> <!-- *** โปรดเปลี่ยนค่านี้เป็น NotirepairId จริงๆ *** -->
    <input type="hidden" id="dateReceiveFromBranchInput" name="dateReceiveFromBranch">
    <input type="hidden" id="dateSenttoSubplierInput" name="dateSenttoSubplier">
    <input type="hidden" id="dateReceiveFromSubplierInput" name="dateReceiveFromSubplier">
    <input type="hidden" id="dateJobReturnToBranchInput" name="dateJobReturnToBranch">
    <input type="hidden" id="StatusJobClosedInput" name="StatusJobClosed" value="Pending"> <!-- สมมติค่าเริ่มต้น -->
    <div id="status-message" class="alert d-none mt-3" role="alert"></div>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="status-box status-complete">
          <h5>📦 รับของจากสาขา</h5>
          <button class="btn btn-primary status-btn mt-2" onclick="updateDate('receiveDateDisplay', 'dateReceiveFromBranchInput', this)">กดรับ</button>
          <p class="mt-2 date-label" id="receiveDateDisplay">ยังไม่ได้อัปเดต</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="status-box status-pending">
          <h5>🚚 ส่งของให้ Supplier</h5>
          <button class="btn btn-warning status-btn mt-2" onclick="updateDate('sentDateDisplay', 'dateSenttoSubplierInput', this)">ส่ง Sub</button>
          <p class="mt-2 date-label" id="sentDateDisplay">ยังไม่ได้อัปเดต</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="status-box status-fail">
          <h5>🔧 Supplier ซ่อมเสร็จ</h5>
          <button class="btn btn-success status-btn mt-2" onclick="updateDate('completeDateDisplay', 'dateReceiveFromSubplierInput', this)">เรียบร้อย</button>
          <p class="mt-2 date-label" id="completeDateDisplay">ยังไม่ได้อัปเดต</p>
        </div>
      </div>
    </div>

    <div class="mt-4 text-end">
      <button class="btn btn-primary px-4" onclick="saveJobData()">💾 บันทึกข้อมูล</button>
    </div>
  </div>

  <script>
    // ฟังก์ชันแสดงข้อความแจ้งเตือน (แทน alert)
    function showCustomMessage(message, isSuccess = true) {
        const msgBox = document.getElementById('status-message');
        msgBox.textContent = message;
        msgBox.classList.remove('d-none', 'alert-success', 'alert-danger');
        msgBox.classList.add(isSuccess ? 'alert-success' : 'alert-danger');
        setTimeout(() => msgBox.classList.add('d-none'), 5000);
    }

    /**
     * ฟังก์ชันอัปเดตเวลาและเก็บค่าในรูปแบบ ISO 8601
     * @param {string} displayId - ID ของ <p> สำหรับแสดงผล (พ.ศ.)
     * @param {string} inputId - ID ของ <input type="hidden"> สำหรับส่งข้อมูล (ค.ศ.)
     * @param {HTMLElement} buttonElement - ปุ่มที่ถูกกด เพื่อ disable
     */
    function updateDate(displayId, inputId, buttonElement) {
      const now = new Date();
      
      // 1. ค่าสำหรับแสดงผล (ปฏิทินไทย/พ.ศ.)
      const formattedDisplay = now.toLocaleString('th-TH', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
      });
      document.getElementById(displayId).textContent = "อัปเดตเมื่อ: " + formattedDisplay;
      
      // 2. ค่าสำหรับส่งข้อมูล (ISO 8601 / ค.ศ.)
      // ตัวอย่าง: 2025-10-21T16:03:00.000Z
      const isoFormatted = now.toISOString();
      document.getElementById(inputId).value = isoFormatted; 

      // ปิดปุ่มเมื่อกดแล้ว (ถ้าเป็นปุ่มแรก)
      if (displayId === 'receiveDateDisplay') {
        buttonElement.disabled = true;
      }
    }

    // ฟังก์ชันบันทึกข้อมูล (ใช้ Fetch API ส่งไป Laravel)
    function saveJobData() {
      const dateReceiveFromBranchValue = document.getElementById('dateReceiveFromBranchInput').value;

      // ตรวจสอบว่ามีการกดรับของจากสาขาแล้วหรือยัง (ถือเป็นขั้นตอนแรก)
      if (!dateReceiveFromBranchValue) {
        showCustomMessage("⚠️ กรุณากด 'รับของจากสาขา' ก่อนทำการบันทึก", false);
        return;
      }

      const data = {
        // 🚨 ดึงค่าจาก Hidden Input Fields ทั้งหมด
        NotirepairId: document.getElementById('NotirepairId').value, 
        dateReceiveFromBranch: dateReceiveFromBranchValue,
        dateSenttoSubplier: document.getElementById('dateSenttoSubplierInput').value,
        dateReceiveFromSubplier: document.getElementById('dateReceiveFromSubplierInput').value,
        dateJobReturnToBranch: document.getElementById('dateJobReturnToBranchInput').value,
        StatusJobClosed: document.getElementById('StatusJobClosedInput').value,
      };
      
      // 🚨 แก้ไข URL เป็น '/submit' ตาม Route Configuration
      fetch('/submit', { 
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}' // ใช้กับ Laravel
        },
        body: JSON.stringify(data)
      })
      .then(res => {
          if (!res.ok) {
              // พยายามอ่าน response body หากมี error 
              return res.json().catch(() => { throw new Error(`HTTP error! Status: ${res.status}`); });
          }
          return res.json();
      })
      .then(response => {
        showCustomMessage("✅ บันทึกข้อมูลเรียบร้อยแล้ว!", true);
      })
      .catch(err => {
        console.error('Fetch Error:', err);
        showCustomMessage("❌ เกิดข้อผิดพลาดในการบันทึกข้อมูล: " + (err.message || 'Server Error'), false);
      });
    }

    // ฟังก์ชันสำหรับดึงข้อมูลสถานะงานซ่อมปัจจุบันมาแสดง (ถ้าต้องการโหลดข้อมูลเริ่มต้น)
    // function loadCurrentStatus() { /* ... */ } 
    
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
