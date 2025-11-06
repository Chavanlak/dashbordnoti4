<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technician Dashboard</title>
  <!-- Link Font: Prompt (เนื่องจากเป็นภาษาไทย) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* ใช้ Prompt เป็นฟอนต์หลัก */
    body { 
        background-color: #f8f9fa; 
        font-family: "Prompt", sans-serif; 
    }
    .navbar { z-index: 1030; }

    /* Content Area */
    .content {
      padding-top: 90px;
      padding-left: 260px; /* เว้นที่ว่างสำหรับ Sidebar Desktop */
      transition: all 0.3s ease;
    }

    /* Sidebar Desktop */
    .sidebar {
      height: 100vh;
      background-color: #212529; /* Darker tone */
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      padding-top: 60px;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }

    .sidebar a {
      color: #adb5bd;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      border-radius: 6px;
      transition: 0.2s;
      margin: 0 10px;
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

    /* Status box and Cards */
    .status-box {
      border-radius: 12px;
      background: linear-gradient(145deg, #ffffff, #f0f0f0);
      padding: 25px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      height: 100%;
      transition: transform 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .status-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }

    .status-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
    }

    .status-complete::before { background-color: #198754; /* Green */ }
    .status-pending::before { background-color: #ffc107; /* Yellow */ }
    .status-fail::before { background-color: #dc3545; /* Red */ }

    .status-btn {
      width: 100%;
      border-radius: 8px;
      font-weight: 600;
      transition: background-color 0.2s;
    }

    .date-label {
      font-size: 0.95rem;
      color: #495057;
      margin-top: 15px;
      font-style: italic;
    }

    /* Custom Toast Notification (Replacement for alert) */
    #customToast {
      position: fixed;
      top: 20px;
      right: 20px;
      min-width: 250px;
      z-index: 2000;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      display: none;
    }
  </style>
</head>
<body>

  <!-- Custom Toast Notification -->
  <div class="toast align-items-center text-white border-0" id="customToast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body fw-bold" id="toastMessage">
        <!-- Message goes here -->
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

  <!-- 🔹 Navbar -->
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <!-- Mobile Sidebar Toggle -->
      <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
        ☰
      </button>
      <a class="navbar-brand ms-2 fw-bold" href="#">Tech Status Manager</a>

      <div class="dropdown ms-auto">
        <button class="btn btn-outline-light dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          👤 แอดมิน
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">ข้อมูลส่วนตัว</a></li>
          <li><a class="dropdown-item text-danger" href="#">ออกจากระบบ</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- 🔹 Sidebar Desktop -->
  <div class="sidebar d-none d-md-block">
    <a href="#" class="active">🏠 แดชบอร์ด</a>
    <a href="#">👨‍🔧 งานของช่าง</a>
    <a href="#">📦 จัดการ Supplier</a>
    <a href="#">📊 รายงาน</a>
    <a href="#">⚙️ ตั้งค่า</a>
  </div>

  <!-- 🔹 Offcanvas Mobile Sidebar -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title text-white" id="offcanvasSidebarLabel">เมนู</h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <a href="#" class="active">🏠 แดชบอร์ด</a>
      <a href="#">👨‍🔧 งานของช่าง</a>
      <a href="#">📦 จัดการ Supplier</a>
      <a href="#">📊 รายงาน</a>
      <a href="#">⚙️ ตั้งค่า</a>
    </div>
  </div>

  <!-- 🔹 Content -->
  <div class="content container-fluid">
    <h4 class="mb-4 fw-bold text-primary">การติดตามสถานะงานซ่อม</h4>

    <!-- Job Status Cards -->
    <div class="row g-4">
      <!-- 1. รับของจากสาขา (dateReceiveFromBranch) -->
      <div class="col-sm-6 col-lg-4">
        <div class="status-box status-complete">
          <h5 class="fw-bold text-success">1. รับของจากสาขา</h5>
          <p class="text-muted">วันที่รับงานซ่อมจากสาขามาดำเนินการ</p>
          <button class="btn btn-success status-btn mt-2" onclick="updateDate('receiveDate', 'receiveBtn')" id="receiveBtn">✅ กดรับงาน</button>
          <p class="date-label" id="receiveDate">สถานะ: ยังไม่ได้อัปเดต</p>
        </div>
      </div>

      <!-- 2. ส่งของให้ Supplier (dateSenttoSubplier) -->
      <div class="col-sm-6 col-lg-4">
        <div class="status-box status-pending">
          <h5 class="fw-bold text-warning">2. ส่งของให้ Supplier</h5>
          <p class="text-muted">วันที่แจ้งและจัดส่งสินค้าให้ซัพพลายเออร์ซ่อม</p>
          <button class="btn btn-warning status-btn mt-2" onclick="updateDate('sentDate', 'sentBtn')" id="sentBtn">🚚 ส่ง Sub</button>
          <p class="date-label" id="sentDate">สถานะ: ยังไม่ได้อัปเดต</p>
        </div>
      </div>

      <!-- 3. Supplier ซ่อมเสร็จ (dateReceiveFromSubplier) -->
      <div class="col-sm-6 col-lg-4">
        <div class="status-box status-fail">
          <h5 class="fw-bold text-danger">3. Supplier ซ่อมเสร็จ</h5>
          <p class="text-muted">วันที่ซัพพลายเออร์ซ่อมเสร็จและส่งคืนกลับมา</p>
          <button class="btn btn-info status-btn mt-2 text-white" onclick="updateDate('completeDate', 'completeBtn')" id="completeBtn">🔧 เรียบร้อย</button>
          <p class="date-label" id="completeDate">สถานะ: ยังไม่ได้อัปเดต</p>
        </div>
      </div>
    </div>

    <!-- Job Closure Section (dateJobReturnToBranch & StatusJobClosed) -->
    <div class="row mt-5 g-4">
      <div class="col-12">
        <div class="card shadow-sm border-primary">
          <div class="card-header bg-primary text-white fw-bold">
            ปิดงานและส่งคืนสาขา (Job Closure)
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="returnDate" class="form-label fw-bold">วันที่ส่งคืนสาขา (dateJobReturnToBranch)</label>
                <p id="returnDate" class="date-label fs-5">ยังไม่ได้อัปเดต</p>
                <button class="btn btn-outline-primary status-btn mt-2" onclick="updateDate('returnDate', 'returnBtn')" id="returnBtn">📦 ส่งคืนสาขา</button>
              </div>
              <div class="col-md-6 mb-3">
                <label for="statusClose" class="form-label fw-bold">สถานะการปิดงาน (StatusJobClosed)</label>
                <select id="statusClose" class="form-select">
                  <option value="ยังไม่ปิดงาน">ยังไม่ปิดงาน</option>
                  <option value="ปิดงานเรียบร้อย">ปิดงานเรียบร้อย</option>
                  <option value="ส่งเรื่องเคลม">ส่งเรื่องเคลม</option>
                </select>
                <p class="mt-2 text-muted fst-italic">สถานะการปิดงานจะมีผลต่อการบันทึกวันที่ส่งคืนสาขา</p>
              </div>
            </div>
            
            <div class="mt-4 text-center">
                <button class="btn btn-lg btn-success px-5 shadow" onclick="saveJobData()">💾 บันทึกและอัปเดตสถานะทั้งหมด</button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Global variable to store job status
    let jobStatus = {
        receiveDate: "สถานะ: ยังไม่ได้อัปเดต",
        sentDate: "สถานะ: ยังไม่ได้อัปเดต",
        completeDate: "สถานะ: ยังไม่ได้อัปเดต",
        returnDate: "สถานะ: ยังไม่ได้อัปเดต"
    };

    /**
     * Shows a custom toast notification instead of using alert()
     * @param {string} message - The message to display
     * @param {string} type - 'success', 'warning', or 'danger'
     */
    function showMessage(message, type = 'success') {
      const toastEl = document.getElementById('customToast');
      const toastMessageEl = document.getElementById('toastMessage');
      
      // Reset classes
      toastEl.className = 'toast align-items-center text-white border-0';
      
      // Set background color and message
      let bgColorClass = '';
      if (type === 'success') {
        bgColorClass = 'bg-success';
      } else if (type === 'danger') {
        bgColorClass = 'bg-danger';
      } else {
        bgColorClass = 'bg-info';
      }

      toastEl.classList.add(bgColorClass);
      toastMessageEl.textContent = message;

      // Show toast using Bootstrap's API
      const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();
    }

    // ฟังก์ชันอัปเดตเวลา
    function updateDate(id, btnId) {
      const now = new Date();
      const formatted = now.toLocaleString('th-TH', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
      });
      const dateString = "อัปเดตเมื่อ: " + formatted;
      
      document.getElementById(id).textContent = dateString;
      
      // Update global state
      jobStatus[id] = dateString;
      
      // Disable the button to prevent multiple clicks on the same action
      // document.getElementById(btnId).disabled = true;
      showMessage(`✅ อัปเดต ${id} เรียบร้อย!`, 'success');
    }

    // ฟังก์ชันจำลองการบันทึกข้อมูล (แทนที่การ fetch API จริง)
    function saveJobData() {
        const statusClosed = document.getElementById('statusClose').value;
        const returnDateEl = document.getElementById('returnDate');
        let message = "💾 บันทึกข้อมูลสถานะงานเรียบร้อยแล้ว";
        let type = 'success';

        // จําลองการตรวจสอบเงื่อนไขแบบ PHP ที่คุณให้มา
        // if($StatusJobClosed !='ยังไม่ปิดงาน'){ return $dateJobReturnToBranch, $dateReceiveFromSubplier; }
        // ในโค้ดจริง คุณจะส่งค่าเหล่านี้ไปอัปเดตฐานข้อมูล

        if (statusClosed !== 'ยังไม่ปิดงาน') {
            // หากมีการปิดงานแล้ว ให้มั่นใจว่ามีการบันทึกวันที่ส่งคืนสาขาไว้ด้วย
            // ในกรณีนี้ เราจะจำลองการใช้ค่าที่อัปเดตล่าสุด
            
            if (jobStatus.returnDate.includes("ยังไม่ได้อัปเดต")) {
                 // ถ้าสถานะปิดงาน แต่ยังไม่ได้กดบันทึกวันที่ส่งคืนสาขา ให้บังคับอัปเดต
                updateDate('returnDate', 'returnBtn'); 
                message = `✅ งานถูกปิดสถานะเป็น "${statusClosed}" และวันที่ส่งคืนสาขาถูกบันทึกแล้ว!`;
            } else {
                 message = `✅ งานถูกปิดสถานะเป็น "${statusClosed}" และวันที่ส่งคืนสาขาถูกอัปเดตแล้ว!`;
            }
        }

        // ตัวอย่างการแสดงข้อมูลที่ถูก "บันทึก" (ในโลกจริงจะส่งค่าเหล่านี้ไป API)
        const dataToSave = {
            dateReceiveFromBranch: jobStatus.receiveDate,
            dateSenttoSubplier: jobStatus.sentDate,
            dateReceiveFromSubplier: jobStatus.completeDate,
            dateJobReturnToBranch: jobStatus.returnDate,
            StatusJobClosed: statusClosed
        };

        console.log("--- Data Sent to Server (Simulated) ---");
        console.log(dataToSave);
        console.log("----------------------------------------");
        
        showMessage(message, type);
    }
  </script>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
