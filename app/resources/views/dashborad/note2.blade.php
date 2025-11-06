<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Technician Job Status</title>
  <!-- Tailwind CSS CDN for clean, utility-first styling -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;700&display=swap" rel="stylesheet">

  <style>
    :root {
      font-family: 'Prompt', sans-serif;
    }
    .status-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .status-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    .date-label.empty {
        color: #ef4444; /* text-red-500 */
        font-style: italic;
    }
  </style>

  <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    'primary': '#1d4ed8', // blue-700
                    'secondary': '#f97316', // orange-600
                }
            }
        }
    }

    /**
     * คลาสสำหรับจัดการสถานะงานซ่อมและ UI (Clean Code - Single Responsibility)
     * นี่คือส่วนที่ถูกแยกออกมาเป็น 'Frontend Package' ใน Monorepo
     */
    class JobStatusDashboard {
        constructor(jobId = 'JOB-001') {
            this.jobId = jobId;
            this.jobStatus = {
                dateReceiveFromBranch: null,
                dateSenttoSubplier: null,
                dateReceiveFromSubplier: null,
                dateJobReturnToBranch: null,
            };
            this.EMPTY_STATUS_TEXT = "สถานะ: ยังไม่ได้อัปเดต";
            this.initEventListeners();
            this.renderStatus();
        }

        /**
         * แปลง Date Object เป็น ISO String YYYY-MM-DD HH:MM:SS สำหรับ Backend
         * @param {Date} date
         * @returns {string}
         */
        formatISO(date) {
            const pad = (n) => String(n).padStart(2, '0');
            // สร้าง String ในรูปแบบ YYYY-MM-DD HH:MM:SS (พร้อม Timezone/Z) ซึ่งเป็นรูปแบบที่ Carbon/DB ชอบ
            const year = date.getFullYear();
            const month = pad(date.getMonth() + 1);
            const day = pad(date.getDate());
            const hours = pad(date.getHours());
            const minutes = pad(date.getMinutes());
            const seconds = pad(date.getSeconds());
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
        
        /**
         * แปลง Date Object เป็น Thai Format สำหรับแสดงผล
         * @param {Date} date
         * @returns {string}
         */
        formatThaiDisplay(date) {
            return date.toLocaleString('th-TH', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        /**
         * แสดง Toast Notification
         */
        showToast(message, type = 'success') {
            const toastEl = document.getElementById('customToast');
            const toastMessageEl = document.getElementById('toastMessage');
            
            toastEl.className = 'fixed top-4 right-4 p-4 rounded-lg shadow-xl text-white font-medium transition-opacity duration-300 ease-in-out';
            
            let bgColorClass = '';
            if (type === 'success') {
                bgColorClass = 'bg-green-600';
            } else if (type === 'danger') {
                bgColorClass = 'bg-red-600';
            } else {
                bgColorClass = 'bg-blue-600';
            }

            toastEl.classList.add(bgColorClass);
            toastMessageEl.textContent = message;
            toastEl.style.display = 'block';
            
            setTimeout(() => {
                toastEl.style.display = 'none';
            }, 3000);
        }

        /**
         * อัปเดตวันที่สำหรับสถานะใดสถานะหนึ่ง (นี่คือฟังก์ชันหลักในการแสดงเวลา)
         * @param {string} dateKey - ชื่อคีย์ใน this.jobStatus (เช่น 'dateReceiveFromBranch')
         */
        updateDate(dateKey) {
            // สร้าง Date object จากเวลาปัจจุบัน
            const now = new Date();
            
            // 1. เตรียมค่าสำหรับ Backend (ISO Format)
            const isoDateString = this.formatISO(now); 
            
            // 2. เตรียมค่าสำหรับ UI (Thai Format)
            const thaiDisplayDate = this.formatThaiDisplay(now); 

            // 3. อัปเดต State
            this.jobStatus[dateKey] = isoDateString;

            // 4. อัปเดต UI (แสดงวันที่ในหน้าจอ)
            const dateEl = document.getElementById(dateKey);
            if (dateEl) {
                dateEl.textContent = `อัปเดต: ${thaiDisplayDate}`; // แสดงเวลาปัจจุบัน
                dateEl.classList.remove('empty');
                
                // ตรวจสอบเพื่อปิดปุ่ม "กดรับงาน" ไม่ให้กดซ้ำ
                if (dateKey === 'dateReceiveFromBranch') {
                    document.getElementById('receiveBtn').disabled = true;
                    document.getElementById('receiveBtn').textContent = '✅ รับงานแล้ว';
                }

                this.showToast(`✅ อัปเดตสถานะ ${dateKey} เรียบร้อย`, 'success');
            }
        }
        
        /**
         * Render สถานะเริ่มต้น (ใช้เมื่อโหลดข้อมูลจาก API ในโลกจริง)
         */
        renderStatus() {
            // ในการเริ่มต้น หากไม่มีข้อมูล จะแสดงสถานะเริ่มต้นเป็น 'ยังไม่ได้อัปเดต'
            Object.keys(this.jobStatus).forEach(key => {
                const dateEl = document.getElementById(key);
                if (dateEl) {
                    dateEl.textContent = this.EMPTY_STATUS_TEXT;
                    dateEl.classList.add('empty');
                    // ถ้าเป็นงานที่ถูกโหลดมาแล้วและมีวันที่ (ในโลกจริง) จะทำการ enable/disable ปุ่ม
                }
            });
        }

        /**
         * กำหนด Event Listeners
         */
        initEventListeners() {
            // ปุ่มที่คุณต้องการ (dateReceiveFromBranch)
            document.getElementById('receiveBtn').onclick = () => this.updateDate('dateReceiveFromBranch');
            
            // ปุ่มอื่นๆ
            document.getElementById('sentBtn').onclick = () => this.updateDate('dateSenttoSubplier');
            document.getElementById('completeBtn').onclick = () => this.updateDate('dateReceiveFromSubplier');
            document.getElementById('returnBtn').onclick = () => this.updateDate('dateJobReturnToBranch');
            document.getElementById('saveJobBtn').onclick = () => this.saveJobData();
        }

        /**
         * ฟังก์ชันจำลองการส่งข้อมูลไป Backend (API Call)
         */
        saveJobData() {
            const statusClosed = document.getElementById('statusClose').value;
            let message = "💾 บันทึกข้อมูลสถานะงานเรียบร้อยแล้ว";
            
            // ข้อมูลที่เตรียมส่งไปยัง JobStatusController.php
            const dataToSave = {
                jobId: this.jobId,
                StatusJobClosed: statusClosed,
                // ส่งค่าวันที่ที่อาจเป็น null หรือเป็น ISO String (YYYY-MM-DD HH:MM:SS)
                dateReceiveFromBranch: this.jobStatus.dateReceiveFromBranch,
                dateSenttoSubplier: this.jobStatus.dateSenttoSubplier,
                dateReceiveFromSubplier: this.jobStatus.dateReceiveFromSubplier,
                dateJobReturnToBranch: this.jobStatus.dateJobReturnToBranch
            };

            console.log("--- API Request Payload (Simulated) ---");
            console.log("This data will be sent to JobApiController.php via POST/PUT request:");
            console.log(dataToSave);
            console.log("----------------------------------------");
            
            // *** ในโค้ดจริง คุณจะใช้ fetch() ไปยัง Laravel API endpoint ***

            if (statusClosed !== 'ยังไม่ปิดงาน') {
                this.showToast(`✅ งานถูกปิดสถานะเป็น "${statusClosed}" และบันทึกข้อมูลแล้ว!`, 'success');
            } else {
                this.showToast(message, 'info');
            }
        }
    }

    // เริ่มต้น Dashboard เมื่อหน้าเว็บโหลดเสร็จ
    document.addEventListener('DOMContentLoaded', () => {
        // ให้ค่า jobId เป็น null เพื่อจำลองการสร้างงานใหม่ หากต้องการ
        new JobStatusDashboard('JOB-001'); 
    });
  </script>
</head>
<body class="bg-gray-50 min-h-screen">

  <!-- Custom Toast Notification -->
  <div id="customToast" class="hidden">
    <div class="flex items-center justify-between">
      <div id="toastMessage" class="flex-grow"></div>
      <button onclick="document.getElementById('customToast').style.display='none';" class="text-white opacity-75 hover:opacity-100 ml-4">
        &times;
      </button>
    </div>
  </div>

  <!-- Main Layout -->
  <div class="flex flex-col md:flex-row">

    <!-- Sidebar (Simplified for Monorepo Concept) -->
    <div class="md:w-64 w-full bg-gray-900 md:h-screen p-4 flex-shrink-0">
        <h1 class="text-xl font-bold text-white mb-6">Tech Manager</h1>
        <nav class="space-y-2">
            <a href="#" class="block p-3 rounded-lg text-white bg-blue-700/80 hover:bg-blue-700 font-medium">
                🏠 Dashboard
            </a>
            <a href="#" class="block p-3 rounded-lg text-gray-300 hover:bg-gray-700">
                👨‍🔧 Job List
            </a>
            <a href="#" class="block p-3 rounded-lg text-gray-300 hover:bg-gray-700">
                📦 Suppliers
            </a>
        </nav>
    </div>

    <!-- Content Area -->
    <div class="flex-grow p-4 md:p-8">
      <header class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-800">การติดตามสถานะงานซ่อม</h2>
        <p class="text-gray-500">JOB ID: <span class="font-mono text-primary">JOB-001</span></p>
      </header>

      <!-- Status Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <!-- 1. รับของจากสาขา (dateReceiveFromBranch) -->
        <div class="status-card bg-white p-6 rounded-xl border-t-4 border-green-500 shadow-lg">
          <h5 class="text-xl font-bold text-green-600 mb-2">1. รับของจากสาขา</h5>
          <p class="text-gray-500 text-sm">วันที่รับงานซ่อมจากสาขามาดำเนินการ</p>
          <!-- ปุ่มที่คุณต้องการให้ทำงาน -->
          <button id="receiveBtn" class="mt-4 w-full py-2 px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition duration-150">
            ✅ กดรับงาน
          </button>
          <!-- ตำแหน่งแสดงวันที่ (id: dateReceiveFromBranch) -->
          <p id="dateReceiveFromBranch" class="date-label text-sm mt-3 empty"></p>
        </div>

        <!-- 2. ส่งของให้ Supplier (dateSenttoSubplier) -->
        <div class="status-card bg-white p-6 rounded-xl border-t-4 border-amber-500 shadow-lg">
          <h5 class="text-xl font-bold text-amber-600 mb-2">2. ส่งของให้ Supplier</h5>
          <p class="text-gray-500 text-sm">วันที่แจ้งและจัดส่งสินค้าให้ซัพพลายเออร์ซ่อม</p>
          <button id="sentBtn" class="mt-4 w-full py-2 px-4 bg-amber-500 text-white rounded-lg font-semibold hover:bg-amber-600 transition duration-150">
            🚚 ส่ง Sub
          </button>
          <p id="dateSenttoSubplier" class="date-label text-sm mt-3 empty"></p>
        </div>

        <!-- 3. Supplier ซ่อมเสร็จ (dateReceiveFromSubplier) -->
        <div class="status-card bg-white p-6 rounded-xl border-t-4 border-sky-500 shadow-lg">
          <h5 class="text-xl font-bold text-sky-600 mb-2">3. Supplier ซ่อมเสร็จ</h5>
          <p class="text-gray-500 text-sm">วันที่ซัพพลายเออร์ซ่อมเสร็จและส่งคืนกลับมา</p>
          <button id="completeBtn" class="mt-4 w-full py-2 px-4 bg-sky-500 text-white rounded-lg font-semibold hover:bg-sky-600 transition duration-150">
            🔧 เรียบร้อย
          </button>
          <p id="dateReceiveFromSubplier" class="date-label text-sm mt-3 empty"></p>
        </div>
        
         <!-- 4. ส่งคืนสาขา (dateJobReturnToBranch) -->
        <div class="status-card bg-white p-6 rounded-xl border-t-4 border-primary shadow-lg">
          <h5 class="text-xl font-bold text-primary mb-2">4. ส่งคืนสาขา</h5>
          <p class="text-gray-500 text-sm">วันที่จัดส่งสินค้าคืนให้สาขา (พร้อมปิดงาน)</p>
          <button id="returnBtn" class="mt-4 w-full py-2 px-4 bg-primary text-white rounded-lg font-semibold hover:bg-blue-800 transition duration-150">
            📦 ส่งคืนสาขา
          </button>
          <p id="dateJobReturnToBranch" class="date-label text-sm mt-3 empty"></p>
        </div>

      </div>

      <!-- Job Closure Section -->
      <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
        <h3 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">สถานะการปิดงาน</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="statusClose" class="block text-gray-700 font-medium mb-2">
                    เลือกสถานะการปิดงาน (StatusJobClosed)
                </label>
                <select id="statusClose" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                  <option value="ยังไม่ปิดงาน">ยังไม่ปิดงาน</option>
                  <option value="ปิดงานเรียบร้อย">ปิดงานเรียบร้อย</option>
                  <option value="ส่งเรื่องเคลม">ส่งเรื่องเคลม (แจ้งคืนสาขาแล้ว)</option>
                </select>
                <p class="mt-2 text-sm text-gray-500">
                    *หากเลือก "ปิดงาน" และยังไม่ได้กดปุ่ม "ส่งคืนสาขา" ระบบจะบันทึกวันที่สุดท้ายให้อัตโนมัติ
                </p>
            </div>
            
            <div class="flex items-center justify-center md:justify-end">
                <button id="saveJobBtn" class="w-full md:w-auto mt-6 md:mt-0 py-3 px-8 bg-secondary text-white font-bold rounded-full shadow-lg hover:bg-orange-700 transition duration-150">
                    💾 บันทึกและอัปเดตข้อมูลทั้งหมด
                </button>
            </div>
        </div>
        
      </div>

    </div>
  </div>
</body>
</html>
