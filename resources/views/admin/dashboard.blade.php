<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Clinic Flow - Admin CRUD (Local demo)</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <meta name="description" content="Clinic Flow Admin CRUD demo (frontend, LocalStorage)" />
  <style>
    /* small custom tweaks */
    .active-tab { background-color: #68D6EC; color: white; }
    .card { background: white; border-radius: .75rem; box-shadow: 0 6px 18px rgba(15,23,42,0.06); padding: 1rem; }
    .table-fixed-head thead th { position: sticky; top: 0; background: #fff; z-index:10; }
    .truncate-ellipsis { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    /* modal backdrop */
    .modal-backdrop { background: rgba(0,0,0,0.5); }
  </style>
</head>
<body class="bg-gray-100 font-sans text-sm">

  <!-- Layout -->
  <div class="flex min-h-screen">
    <!-- Sidebar (copy style from your dashboard) -->
    <aside class="w-64 bg-white shadow-lg h-screen fixed">
      <div class="p-4 border-b border-gray-200">
        <h1 class="text-2xl font-bold text-[#68D6EC] flex items-center">
          <i data-feather="activity" class="mr-2"></i> Clinic Flow
        </h1>
      </div>
      <nav class="mt-6">
        <div class="mt-3">
          <button data-tab="dashboard" class="w-full flex items-center px-6 py-3 text-gray-600 hover:bg-[#68D6EC]/10 sidebar-item active-route">
            <i data-feather="home" class="sidebar-icon mr-3 text-blue-500"></i>
            <span class="font-medium">Dashboard</span>
          </button>

          <button data-tab="booking" class="w-full flex items-center px-6 py-3 text-gray-600 hover:bg-[#68D6EC]/10 sidebar-item">
            <i data-feather="calendar" class="sidebar-icon mr-3 text-green-500"></i>
            <span class="font-medium">Booking</span>
          </button>

          <button data-tab="doctors" class="w-full flex items-center px-6 py-3 text-gray-600 hover:bg-[#68D6EC]/10 sidebar-item">
            <i data-feather="user" class="sidebar-icon mr-3 text-purple-500"></i>
            <span class="font-medium">Doctors</span>
          </button>

          <button data-tab="users" class="w-full flex items-center px-6 py-3 text-gray-600 hover:bg-[#68D6EC]/10 sidebar-item">
            <i data-feather="users" class="sidebar-icon mr-3 text-red-500"></i>
            <span class="font-medium">Manage Users</span>
          </button>

          <button data-tab="reminders" class="w-full flex items-center px-6 py-3 text-gray-600 hover:bg-[#68D6EC]/10 sidebar-item">
            <i data-feather="bell" class="sidebar-icon mr-3 text-yellow-500"></i>
            <span class="font-medium">Reminders</span>
          </button>

          <button data-tab="schedule" class="w-full flex items-center px-6 py-3 text-gray-600 hover:bg-[#68D6EC]/10 sidebar-item">
            <i data-feather="clock" class="sidebar-icon mr-3 text-indigo-500"></i>
            <span class="font-medium">Schedule</span>
          </button>

          <button data-tab="records" class="w-full flex items-center px-6 py-3 text-gray-600 hover:bg-[#68D6EC]/10 sidebar-item">
            <i data-feather="file-text" class="sidebar-icon mr-3 text-teal-500"></i>
            <span class="font-medium">Records</span>
          </button>
        </div>
      </nav>
    </aside>

    <!-- Main area -->
    <main class="flex-1 ml-64 p-8">
      <!-- Header -->
      <header class="bg-white rounded-lg shadow-sm p-4 mb-6 flex justify-between items-center">
        <h2 id="pageTitle" class="text-xl font-semibold text-gray-800">Dashboard</h2>
        <div class="flex items-center gap-4">
          <div class="relative">
            <i data-feather="search" class="absolute left-3 top-3 text-gray-400"></i>
            <input id="globalSearch" type="text" placeholder="Search current module..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 w-64 focus:ring-2 focus:ring-[#68D6EC]">
          </div>
          <div class="flex items-center gap-3">
            <i data-feather="bell" class="text-gray-500"></i>
            <img src="http://static.photos/people/200x200/1" alt="Admin" class="w-8 h-8 rounded-full">
          </div>
        </div>
      </header>

      <!-- Content for each tab -->
      <section id="contentArea">
        <!-- Dashboard Home -->
        <div data-panel="dashboard">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="card p-6">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-gray-600">Bookings</h3>
                  <p id="statBookings" class="text-2xl font-semibold mt-2">0</p>
                </div>
                <i data-feather="calendar" class="w-10 h-10 text-green-400"></i>
              </div>
            </div>
            <div class="card p-6">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-gray-600">Doctors</h3>
                  <p id="statDoctors" class="text-2xl font-semibold mt-2">0</p>
                </div>
                <i data-feather="user" class="w-10 h-10 text-purple-400"></i>
              </div>
            </div>
            <div class="card p-6">
              <div class="flex items-center justify-between">
                <div>
                  <h3 class="text-gray-600">Users</h3>
                  <p id="statUsers" class="text-2xl font-semibold mt-2">0</p>
                </div>
                <i data-feather="users" class="w-10 h-10 text-red-400"></i>
              </div>
            </div>
          </div>

          <div class="card p-6">
            <h3 class="font-semibold mb-3">Recent Bookings</h3>
            <div id="recentBookingList" class="space-y-2 text-sm text-gray-700"></div>
          </div>
        </div>

        <!-- Generic CRUD Panel template will be cloned for each module -->
        <!-- Booking panel -->
        <div data-panel="booking" class="hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Bookings</h3>
            <div class="flex items-center gap-2">
              <button id="addBookingBtn" class="px-4 py-2 bg-[#68D6EC] text-white rounded-lg">+ Booking</button>
              <button data-action="export" data-entity="bookings" class="px-3 py-2 border rounded-lg">Export CSV</button>
              <label class="px-3 py-2 border rounded-lg cursor-pointer">
                Import
                <input data-import="bookings" type="file" accept=".csv" class="hidden">
              </label>
            </div>
          </div>
          <div class="card">
            <div class="overflow-x-auto">
              <table class="w-full table-auto text-sm" id="bookingsTable">
                <thead class="text-left text-gray-600">
                  <tr>
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2 cursor-pointer" data-sort="patient">Patient</th>
                    <th class="px-3 py-2 cursor-pointer" data-sort="doctor">Doctor</th>
                    <th class="px-3 py-2 cursor-pointer" data-sort="date">Date</th>
                    <th class="px-3 py-2">Time</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody class="divide-y" id="bookingsTbody"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Doctors -->
        <div data-panel="doctors" class="hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Doctors</h3>
            <div class="flex items-center gap-2">
              <button id="addDoctorBtn" class="px-4 py-2 bg-[#68D6EC] text-white rounded-lg">+ Doctor</button>
              <button data-action="export" data-entity="doctors" class="px-3 py-2 border rounded-lg">Export CSV</button>
              <label class="px-3 py-2 border rounded-lg cursor-pointer">
                Import
                <input data-import="doctors" type="file" accept=".csv" class="hidden">
              </label>
            </div>
          </div>
          <div class="card">
            <div class="overflow-x-auto">
              <table class="w-full table-auto text-sm" id="doctorsTable">
                <thead class="text-left text-gray-600">
                  <tr>
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2">Name</th>
                    <th class="px-3 py-2">Specialty</th>
                    <th class="px-3 py-2">Phone</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody id="doctorsTbody" class="divide-y"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Users -->
        <div data-panel="users" class="hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Manage Users</h3>
            <div class="flex items-center gap-2">
              <button id="addUserBtn" class="px-4 py-2 bg-[#68D6EC] text-white rounded-lg">+ User</button>
              <button data-action="export" data-entity="users" class="px-3 py-2 border rounded-lg">Export CSV</button>
              <label class="px-3 py-2 border rounded-lg cursor-pointer">
                Import
                <input data-import="users" type="file" accept=".csv" class="hidden">
              </label>
            </div>
          </div>
          <div class="card">
            <div class="overflow-x-auto">
              <table class="w-full table-auto text-sm" id="usersTable">
                <thead class="text-left text-gray-600">
                  <tr>
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2">Name</th>
                    <th class="px-3 py-2">Email</th>
                    <th class="px-3 py-2">Role</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody id="usersTbody" class="divide-y"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Reminders -->
        <div data-panel="reminders" class="hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Reminders</h3>
            <div class="flex items-center gap-2">
              <button id="addReminderBtn" class="px-4 py-2 bg-[#68D6EC] text-white rounded-lg">+ Reminder</button>
              <button data-action="export" data-entity="reminders" class="px-3 py-2 border rounded-lg">Export CSV</button>
              <label class="px-3 py-2 border rounded-lg cursor-pointer">
                Import
                <input data-import="reminders" type="file" accept=".csv" class="hidden">
              </label>
            </div>
          </div>
          <div class="card">
            <div class="overflow-x-auto">
              <table class="w-full table-auto text-sm" id="remindersTable">
                <thead class="text-left text-gray-600">
                  <tr>
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2">Title</th>
                    <th class="px-3 py-2">Due Date</th>
                    <th class="px-3 py-2">Notes</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody id="remindersTbody" class="divide-y"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Schedule -->
        <div data-panel="schedule" class="hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Schedule</h3>
            <div class="flex items-center gap-2">
              <button id="addScheduleBtn" class="px-4 py-2 bg-[#68D6EC] text-white rounded-lg">+ Schedule</button>
              <button data-action="export" data-entity="schedules" class="px-3 py-2 border rounded-lg">Export CSV</button>
              <label class="px-3 py-2 border rounded-lg cursor-pointer">
                Import
                <input data-import="schedules" type="file" accept=".csv" class="hidden">
              </label>
            </div>
          </div>
          <div class="card">
            <div class="overflow-x-auto">
              <table class="w-full table-auto text-sm" id="scheduleTable">
                <thead class="text-left text-gray-600">
                  <tr>
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2">Doctor</th>
                    <th class="px-3 py-2">Day</th>
                    <th class="px-3 py-2">From</th>
                    <th class="px-3 py-2">To</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody id="scheduleTbody" class="divide-y"></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Records -->
        <div data-panel="records" class="hidden">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Records</h3>
            <div class="flex items-center gap-2">
              <button id="addRecordBtn" class="px-4 py-2 bg-[#68D6EC] text-white rounded-lg">+ Record</button>
              <button data-action="export" data-entity="records" class="px-3 py-2 border rounded-lg">Export CSV</button>
              <label class="px-3 py-2 border rounded-lg cursor-pointer">
                Import
                <input data-import="records" type="file" accept=".csv" class="hidden">
              </label>
            </div>
          </div>
          <div class="card">
            <div class="overflow-x-auto">
              <table class="w-full table-auto text-sm" id="recordsTable">
                <thead class="text-left text-gray-600">
                  <tr>
                    <th class="px-3 py-2">#</th>
                    <th class="px-3 py-2">Patient</th>
                    <th class="px-3 py-2">Type</th>
                    <th class="px-3 py-2">Date</th>
                    <th class="px-3 py-2">Notes</th>
                    <th class="px-3 py-2">Actions</th>
                  </tr>
                </thead>
                <tbody id="recordsTbody" class="divide-y"></tbody>
              </table>
            </div>
          </div>
        </div>

      </section>
    </main>
  </div>

  <!-- Modal: Generic add/edit (we will re-use fields for each entity) -->
  <div id="modalBackdrop" class="fixed inset-0 hidden items-center justify-center modal-backdrop z-50">
    <div class="bg-white rounded-lg w-full max-w-2xl mx-4 overflow-hidden">
      <div class="p-4 border-b flex justify-between items-center">
        <h4 id="modalTitle" class="font-semibold">Modal</h4>
        <button id="modalClose" class="px-2 py-1 text-gray-600 hover:text-gray-900">✕</button>
      </div>
      <div id="modalBody" class="p-6 max-h-[70vh] overflow-auto"></div>
      <div class="p-4 border-t flex justify-end gap-3">
        <button id="modalCancel" class="px-4 py-2 border rounded">Cancel</button>
        <button id="modalSave" class="px-4 py-2 bg-[#68D6EC] text-white rounded">Save</button>
      </div>
    </div>
  </div>

  <!-- Confirm Delete -->
  <div id="confirmBackdrop" class="fixed inset-0 hidden items-center justify-center modal-backdrop z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
      <h4 class="font-semibold mb-2">Confirm Delete</h4>
      <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete this item? This action cannot be undone.</p>
      <div class="flex justify-end gap-3">
        <button id="confirmCancel" class="px-3 py-2 border rounded">Cancel</button>
        <button id="confirmDelete" class="px-3 py-2 bg-red-600 text-white rounded">Delete</button>
      </div>
    </div>
  </div>

  <script>
    /***********************************************
     * Clinic Flow - Frontend CRUD (LocalStorage)
     * - Single file demo
     * - Entities: bookings, doctors, users, reminders, schedules, records
     ***********************************************/

    // Utilities
    const uid = () => Date.now().toString(36) + Math.random().toString(36).slice(2,8);
    const qs = s => document.querySelector(s);
    const qsa = s => document.querySelectorAll(s);

    // Entity storage helper
    const Storage = {
      get(entity) {
        const raw = localStorage.getItem('cf.' + entity);
        return raw ? JSON.parse(raw) : [];
      },
      set(entity, arr) {
        localStorage.setItem('cf.' + entity, JSON.stringify(arr));
        renderStats();
      },
      reset(entity, arr) { this.set(entity, arr || []); }
    };

    // Seed sample data if empty
    function seedData() {
      if (!localStorage.getItem('cf.seeded')) {
        Storage.set('doctors', [
          { id: uid(), name: 'Dr. Arafat', specialty: 'Cardiology', phone: '012-345-6789' },
          { id: uid(), name: 'Dr. Lim', specialty: 'General', phone: '012-111-2222' }
        ]);
        Storage.set('users', [
          { id: uid(), name: 'Admin', email: 'admin@clinic.com', role: 'admin' },
          { id: uid(), name: 'Reception', email: 'reception@clinic.com', role: 'staff' }
        ]);
        Storage.set('bookings', [
          { id: uid(), patient: 'Ali', doctor: 'Dr. Lim', date: '2025-10-20', time:'09:00', status:'confirmed' },
          { id: uid(), patient: 'Siti', doctor: 'Dr. Arafat', date: '2025-10-21', time:'10:30', status:'pending' }
        ]);
        Storage.set('reminders', [
          { id: uid(), title: 'Monthly Meeting', due: '2025-10-25', notes:'Staff meeting 10am' }
        ]);
        Storage.set('schedules', [
          { id: uid(), doctor: 'Dr. Lim', day: 'Monday', from: '09:00', to: '12:00' }
        ]);
        Storage.set('records', [
          { id: uid(), patient: 'Ali', type: 'X-Ray', date: '2025-09-01', notes: 'Normal' }
        ]);
        localStorage.setItem('cf.seeded', '1');
      }
    }

    // Modal helpers
    const modalBackdrop = qs('#modalBackdrop');
    const modalTitle = qs('#modalTitle');
    const modalBody = qs('#modalBody');
    const modalSave = qs('#modalSave');
    const modalClose = qs('#modalClose');
    const modalCancel = qs('#modalCancel');

    const confirmBackdrop = qs('#confirmBackdrop');
    const confirmDelete = qs('#confirmDelete');
    const confirmCancel = qs('#confirmCancel');

    let currentEntity = null;
    let editingId = null;
    let pendingDelete = null;

    function openModal(title, bodyHTML, onSave) {
      modalTitle.textContent = title;
      modalBody.innerHTML = bodyHTML;
      modalBackdrop.classList.remove('hidden');
      modalBackdrop.style.display = 'flex';
      modalSave.onclick = () => {
        onSave();
        closeModal();
      };
    }
    function closeModal() {
      modalBackdrop.classList.add('hidden');
      modalBackdrop.style.display = 'none';
      modalBody.innerHTML = '';
      editingId = null;
      currentEntity = null;
    }

    modalClose.addEventListener('click', closeModal);
    modalCancel.addEventListener('click', closeModal);
    modalBackdrop.addEventListener('click', (e) => {
      if (e.target === modalBackdrop) closeModal();
    });

    function openConfirm(onConfirm) {
      confirmBackdrop.classList.remove('hidden');
      confirmBackdrop.style.display = 'flex';
      confirmDelete.onclick = () => { onConfirm(); closeConfirm(); };
      confirmCancel.onclick = closeConfirm;
      confirmBackdrop.addEventListener('click', (e) => { if (e.target===confirmBackdrop) closeConfirm(); });
    }
    function closeConfirm() {
      confirmBackdrop.classList.add('hidden');
      confirmBackdrop.style.display = 'none';
      pendingDelete = null;
    }

    // Render helpers for each entity
    function renderStats() {
      qs('#statBookings').textContent = Storage.get('bookings').length;
      qs('#statDoctors').textContent = Storage.get('doctors').length;
      qs('#statUsers').textContent = Storage.get('users').length;

      // recent bookings list
      const rec = qs('#recentBookingList');
      const bookings = Storage.get('bookings').slice(-5).reverse();
      rec.innerHTML = bookings.length ? bookings.map(b => `<div class="flex justify-between"><div>${b.patient} — ${b.doctor}</div><div class="text-xs text-gray-500">${b.date} ${b.time}</div></div>`).join('') : '<div class="text-gray-500">No bookings yet</div>';
    }

    function renderBookings(filter='') {
      const tbody = qs('#bookingsTbody');
      const arr = Storage.get('bookings').filter(b => JSON.stringify(b).toLowerCase().includes(filter.toLowerCase()));
      tbody.innerHTML = arr.map((b,i) => `
        <tr>
          <td class="px-3 py-2">${i+1}</td>
          <td class="px-3 py-2">${escapeHtml(b.patient)}</td>
          <td class="px-3 py-2">${escapeHtml(b.doctor)}</td>
          <td class="px-3 py-2">${b.date}</td>
          <td class="px-3 py-2">${b.time}</td>
          <td class="px-3 py-2">${b.status}</td>
          <td class="px-3 py-2">
            <button data-edit="${b.id}" data-entity="bookings" class="px-2 py-1 border rounded text-sm">Edit</button>
            <button data-delete="${b.id}" data-entity="bookings" class="px-2 py-1 border rounded text-sm text-red-600">Delete</button>
          </td>
        </tr>`).join('');
    }

    function renderDoctors(filter='') {
      const tbody = qs('#doctorsTbody');
      const arr = Storage.get('doctors').filter(d => JSON.stringify(d).toLowerCase().includes(filter.toLowerCase()));
      tbody.innerHTML = arr.map((d,i) => `
        <tr>
          <td class="px-3 py-2">${i+1}</td>
          <td class="px-3 py-2">${escapeHtml(d.name)}</td>
          <td class="px-3 py-2">${escapeHtml(d.specialty||'')}</td>
          <td class="px-3 py-2">${escapeHtml(d.phone||'')}</td>
          <td class="px-3 py-2">
            <button data-edit="${d.id}" data-entity="doctors" class="px-2 py-1 border rounded text-sm">Edit</button>
            <button data-delete="${d.id}" data-entity="doctors" class="px-2 py-1 border rounded text-sm text-red-600">Delete</button>
          </td>
        </tr>`).join('');
    }

    function renderUsers(filter='') {
      const tbody = qs('#usersTbody');
      const arr = Storage.get('users').filter(u => JSON.stringify(u).toLowerCase().includes(filter.toLowerCase()));
      tbody.innerHTML = arr.map((u,i) => `
        <tr>
          <td class="px-3 py-2">${i+1}</td>
          <td class="px-3 py-2">${escapeHtml(u.name)}</td>
          <td class="px-3 py-2">${escapeHtml(u.email)}</td>
          <td class="px-3 py-2">${escapeHtml(u.role||'staff')}</td>
          <td class="px-3 py-2">
            <button data-edit="${u.id}" data-entity="users" class="px-2 py-1 border rounded text-sm">Edit</button>
            <button data-delete="${u.id}" data-entity="users" class="px-2 py-1 border rounded text-sm text-red-600">Delete</button>
          </td>
        </tr>`).join('');
    }

    function renderReminders(filter='') {
      const tbody = qs('#remindersTbody');
      const arr = Storage.get('reminders').filter(r => JSON.stringify(r).toLowerCase().includes(filter.toLowerCase()));
      tbody.innerHTML = arr.map((r,i) => `
        <tr>
          <td class="px-3 py-2">${i+1}</td>
          <td class="px-3 py-2">${escapeHtml(r.title)}</td>
          <td class="px-3 py-2">${r.due}</td>
          <td class="px-3 py-2">${escapeHtml(r.notes||'')}</td>
          <td class="px-3 py-2">
            <button data-edit="${r.id}" data-entity="reminders" class="px-2 py-1 border rounded text-sm">Edit</button>
            <button data-delete="${r.id}" data-entity="reminders" class="px-2 py-1 border rounded text-sm text-red-600">Delete</button>
          </td>
        </tr>`).join('');
    }

    function renderSchedules(filter='') {
      const tbody = qs('#scheduleTbody');
      const arr = Storage.get('schedules').filter(s => JSON.stringify(s).toLowerCase().includes(filter.toLowerCase()));
      tbody.innerHTML = arr.map((s,i) => `
        <tr>
          <td class="px-3 py-2">${i+1}</td>
          <td class="px-3 py-2">${escapeHtml(s.doctor)}</td>
          <td class="px-3 py-2">${escapeHtml(s.day)}</td>
          <td class="px-3 py-2">${s.from}</td>
          <td class="px-3 py-2">${s.to}</td>
          <td class="px-3 py-2">
            <button data-edit="${s.id}" data-entity="schedules" class="px-2 py-1 border rounded text-sm">Edit</button>
            <button data-delete="${s.id}" data-entity="schedules" class="px-2 py-1 border rounded text-sm text-red-600">Delete</button>
          </td>
        </tr>`).join('');
    }

    function renderRecords(filter='') {
      const tbody = qs('#recordsTbody');
      const arr = Storage.get('records').filter(r => JSON.stringify(r).toLowerCase().includes(filter.toLowerCase()));
      tbody.innerHTML = arr.map((r,i) => `
        <tr>
          <td class="px-3 py-2">${i+1}</td>
          <td class="px-3 py-2">${escapeHtml(r.patient)}</td>
          <td class="px-3 py-2">${escapeHtml(r.type)}</td>
          <td class="px-3 py-2">${r.date}</td>
          <td class="px-3 py-2">${escapeHtml(r.notes||'')}</td>
          <td class="px-3 py-2">
            <button data-edit="${r.id}" data-entity="records" class="px-2 py-1 border rounded text-sm">Edit</button>
            <button data-delete="${r.id}" data-entity="records" class="px-2 py-1 border rounded text-sm text-red-600">Delete</button>
          </td>
        </tr>`).join('');
    }

    // Escape HTML utility
    function escapeHtml(str='') {
      return String(str).replace(/[&<>"']/g, (m) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
    }

    // Global render
    function renderAll(filter='') {
      renderBookings(filter);
      renderDoctors(filter);
      renderUsers(filter);
      renderReminders(filter);
      renderSchedules(filter);
      renderRecords(filter);
    }

    // Wire tab switching
    function initTabs() {
      qsa('[data-tab]').forEach(btn => {
        btn.addEventListener('click', () => {
          const tab = btn.getAttribute('data-tab');
          // set active style
          qsa('[data-tab]').forEach(b=>b.classList.remove('active-route'));
          btn.classList.add('active-route');
          // show panel
          qsa('[data-panel]').forEach(p => p.classList.add('hidden'));
          const panel = qs(`[data-panel="${tab}"]`);
          if (panel) panel.classList.remove('hidden');
          qs('#pageTitle').textContent = tab[0].toUpperCase() + tab.slice(1);
          qs('#globalSearch').value = '';
        });
      });
      // default open dashboard
      qs('[data-tab="dashboard"]').click();
    }

    // Add / Edit handlers for each entity
    function bindAddEditButtons() {
      // Booking
      qs('#addBookingBtn').addEventListener('click', () => {
        currentEntity = 'bookings';
        const doctors = Storage.get('doctors');
        openModal('Create Booking', `
          <div class="grid gap-3">
            <label class="block">Patient name<input id="modal_patient" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Doctor
              <select id="modal_doctor" class="w-full border rounded px-3 py-2">
                ${doctors.map(d => `<option>${escapeHtml(d.name)}</option>`).join('')}
              </select>
            </label>
            <div class="grid grid-cols-2 gap-3">
              <label class="block">Date<input id="modal_date" type="date" class="w-full border rounded px-3 py-2"></label>
              <label class="block">Time<input id="modal_time" type="time" class="w-full border rounded px-3 py-2"></label>
            </div>
            <label class="block">Status
              <select id="modal_status" class="w-full border rounded px-3 py-2">
                <option>confirmed</option><option>pending</option><option>cancelled</option>
              </select>
            </label>
          </div>
        `, () => {
          const patient = qs('#modal_patient').value.trim();
          const doctor = qs('#modal_doctor').value.trim();
          const date = qs('#modal_date').value;
          const time = qs('#modal_time').value;
          const status = qs('#modal_status').value;
          if (!patient || !doctor || !date || !time) { alert('Please fill all fields'); return; }
          const arr = Storage.get('bookings');
          arr.push({ id: uid(), patient, doctor, date, time, status });
          Storage.set('bookings', arr);
          renderBookings();
        });
      });

      // Doctors
      qs('#addDoctorBtn').addEventListener('click', () => {
        currentEntity = 'doctors';
        openModal('Create Doctor', `
          <div class="grid gap-3">
            <label class="block">Name<input id="modal_name" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Specialty<input id="modal_specialty" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Phone<input id="modal_phone" class="w-full border rounded px-3 py-2"></label>
          </div>
        `, () => {
          const name = qs('#modal_name').value.trim();
          const specialty = qs('#modal_specialty').value.trim();
          const phone = qs('#modal_phone').value.trim();
          if (!name) { alert('Name required'); return; }
          const arr = Storage.get('doctors');
          arr.push({ id: uid(), name, specialty, phone });
          Storage.set('doctors', arr);
          renderDoctors();
        });
      });

      // Users
      qs('#addUserBtn').addEventListener('click', () => {
        currentEntity = 'users';
        openModal('Create User', `
          <div class="grid gap-3">
            <label class="block">Name<input id="modal_name" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Email<input id="modal_email" type="email" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Role
              <select id="modal_role" class="w-full border rounded px-3 py-2">
                <option>admin</option><option>staff</option>
              </select>
            </label>
          </div>
        `, () => {
          const name = qs('#modal_name').value.trim();
          const email = qs('#modal_email').value.trim();
          const role = qs('#modal_role').value;
          if (!name || !email) { alert('Name & email required'); return; }
          const arr = Storage.get('users');
          arr.push({ id: uid(), name, email, role });
          Storage.set('users', arr);
          renderUsers();
        });
      });

      // Reminders
      qs('#addReminderBtn').addEventListener('click', () => {
        currentEntity = 'reminders';
        openModal('Create Reminder', `
          <div class="grid gap-3">
            <label class="block">Title<input id="modal_title" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Due Date<input id="modal_due" type="date" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Notes<textarea id="modal_notes" class="w-full border rounded px-3 py-2"></textarea></label>
          </div>
        `, () => {
          const title = qs('#modal_title').value.trim();
          const due = qs('#modal_due').value;
          const notes = qs('#modal_notes').value.trim();
          if (!title || !due) { alert('Title & due date required'); return; }
          const arr = Storage.get('reminders');
          arr.push({ id: uid(), title, due, notes });
          Storage.set('reminders', arr);
          renderReminders();
        });
      });

      // Schedule
      qs('#addScheduleBtn').addEventListener('click', () => {
        currentEntity = 'schedules';
        const doctors = Storage.get('doctors');
        openModal('Create Schedule', `
          <div class="grid gap-3">
            <label class="block">Doctor
              <select id="modal_doctor" class="w-full border rounded px-3 py-2">
                ${doctors.map(d => `<option>${escapeHtml(d.name)}</option>`).join('')}
              </select>
            </label>
            <label class="block">Day<input id="modal_day" class="w-full border rounded px-3 py-2" placeholder="e.g. Monday"></label>
            <div class="grid grid-cols-2 gap-3">
              <label class="block">From<input id="modal_from" type="time" class="w-full border rounded px-3 py-2"></label>
              <label class="block">To<input id="modal_to" type="time" class="w-full border rounded px-3 py-2"></label>
            </div>
          </div>
        `, () => {
          const doctor = qs('#modal_doctor').value;
          const day = qs('#modal_day').value.trim();
          const from = qs('#modal_from').value;
          const to = qs('#modal_to').value;
          if (!doctor || !day || !from || !to) { alert('All fields required'); return; }
          const arr = Storage.get('schedules');
          arr.push({ id: uid(), doctor, day, from, to });
          Storage.set('schedules', arr);
          renderSchedules();
        });
      });

      // Records
      qs('#addRecordBtn').addEventListener('click', () => {
        currentEntity = 'records';
        openModal('Create Record', `
          <div class="grid gap-3">
            <label class="block">Patient<input id="modal_patient" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Type<input id="modal_type" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Date<input id="modal_date" type="date" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Notes<textarea id="modal_notes" class="w-full border rounded px-3 py-2"></textarea></label>
          </div>
        `, () => {
          const patient = qs('#modal_patient').value.trim();
          const type = qs('#modal_type').value.trim();
          const date = qs('#modal_date').value;
          const notes = qs('#modal_notes').value.trim();
          if (!patient || !type || !date) { alert('Patient, type & date required'); return; }
          const arr = Storage.get('records');
          arr.push({ id: uid(), patient, type, date, notes });
          Storage.set('records', arr);
          renderRecords();
        });
      });
    }

    // Edit and Delete delegation
    function bindTableActions() {
      document.addEventListener('click', (e) => {
        const edit = e.target.closest('[data-edit]');
        const del = e.target.closest('[data-delete]');
        if (edit) {
          const id = edit.getAttribute('data-edit');
          const entity = edit.getAttribute('data-entity');
          openEditModal(entity, id);
        } else if (del) {
          const id = del.getAttribute('data-delete');
          const entity = del.getAttribute('data-entity');
          pendingDelete = { entity, id };
          openConfirm(() => handleDelete(pendingDelete.entity, pendingDelete.id));
        }
      });
    }

    // Edit modal per entity
    function openEditModal(entity, id) {
      currentEntity = entity;
      editingId = id;
      const arr = Storage.get(entity);
      const item = arr.find(x => x.id === id);
      if (!item) { alert('Item not found'); return; }

      if (entity === 'bookings') {
        const doctors = Storage.get('doctors');
        openModal('Edit Booking', `
          <div class="grid gap-3">
            <label class="block">Patient<input id="modal_patient" value="${escapeHtml(item.patient)}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Doctor
              <select id="modal_doctor" class="w-full border rounded px-3 py-2">
                ${doctors.map(d => `<option ${d.name===item.doctor ? 'selected' : '' }>${escapeHtml(d.name)}</option>`).join('')}
              </select>
            </label>
            <div class="grid grid-cols-2 gap-3">
              <label class="block">Date<input id="modal_date" type="date" value="${item.date}" class="w-full border rounded px-3 py-2"></label>
              <label class="block">Time<input id="modal_time" type="time" value="${item.time}" class="w-full border rounded px-3 py-2"></label>
            </div>
            <label class="block">Status
              <select id="modal_status" class="w-full border rounded px-3 py-2">
                <option ${item.status==='confirmed'?'selected':''}>confirmed</option><option ${item.status==='pending'?'selected':''}>pending</option><option ${item.status==='cancelled'?'selected':''}>cancelled</option>
              </select>
            </label>
          </div>
        `, () => {
          const patient = qs('#modal_patient').value.trim();
          const doctor = qs('#modal_doctor').value.trim();
          const date = qs('#modal_date').value;
          const time = qs('#modal_time').value;
          const status = qs('#modal_status').value;
          if (!patient || !doctor || !date || !time) { alert('Please fill all fields'); return; }
          const arr2 = Storage.get('bookings').map(b => b.id===id ? { ...b, patient, doctor, date, time, status } : b);
          Storage.set('bookings', arr2); renderBookings();
        });
      }

      if (entity === 'doctors') {
        openModal('Edit Doctor', `
          <div class="grid gap-3">
            <label class="block">Name<input id="modal_name" value="${escapeHtml(item.name)}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Specialty<input id="modal_specialty" value="${escapeHtml(item.specialty||'')}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Phone<input id="modal_phone" value="${escapeHtml(item.phone||'')}" class="w-full border rounded px-3 py-2"></label>
          </div>
        `, () => {
          const name = qs('#modal_name').value.trim();
          const specialty = qs('#modal_specialty').value.trim();
          const phone = qs('#modal_phone').value.trim();
          if (!name) { alert('Name required'); return; }
          const arr2 = Storage.get('doctors').map(d => d.id===id ? { ...d, name, specialty, phone } : d);
          Storage.set('doctors', arr2); renderDoctors();
        });
      }

      if (entity === 'users') {
        openModal('Edit User', `
          <div class="grid gap-3">
            <label class="block">Name<input id="modal_name" value="${escapeHtml(item.name)}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Email<input id="modal_email" value="${escapeHtml(item.email)}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Role
              <select id="modal_role" class="w-full border rounded px-3 py-2">
                <option ${item.role==='admin'?'selected':''}>admin</option>
                <option ${item.role==='staff'?'selected':''}>staff</option>
              </select>
            </label>
          </div>
        `, () => {
          const name = qs('#modal_name').value.trim();
          const email = qs('#modal_email').value.trim();
          const role = qs('#modal_role').value;
          if (!name || !email) { alert('Name & email required'); return; }
          const arr2 = Storage.get('users').map(u => u.id===id ? { ...u, name, email, role } : u);
          Storage.set('users', arr2); renderUsers();
        });
      }

      if (entity === 'reminders') {
        openModal('Edit Reminder', `
          <div class="grid gap-3">
            <label class="block">Title<input id="modal_title" value="${escapeHtml(item.title)}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Due Date<input id="modal_due" type="date" value="${item.due}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Notes<textarea id="modal_notes" class="w-full border rounded px-3 py-2">${escapeHtml(item.notes||'')}</textarea></label>
          </div>
        `, () => {
          const title = qs('#modal_title').value.trim();
          const due = qs('#modal_due').value;
          const notes = qs('#modal_notes').value.trim();
          if (!title || !due) { alert('Title & due date required'); return; }
          const arr2 = Storage.get('reminders').map(r => r.id===id ? { ...r, title, due, notes } : r);
          Storage.set('reminders', arr2); renderReminders();
        });
      }

      if (entity === 'schedules') {
        const doctors = Storage.get('doctors');
        openModal('Edit Schedule', `
          <div class="grid gap-3">
            <label class="block">Doctor
              <select id="modal_doctor" class="w-full border rounded px-3 py-2">
                ${doctors.map(d => `<option ${d.name===item.doctor ? 'selected' : '' }>${escapeHtml(d.name)}</option>`).join('')}
              </select>
            </label>
            <label class="block">Day<input id="modal_day" value="${escapeHtml(item.day)}" class="w-full border rounded px-3 py-2"></label>
            <div class="grid grid-cols-2 gap-3">
              <label class="block">From<input id="modal_from" type="time" value="${item.from}" class="w-full border rounded px-3 py-2"></label>
              <label class="block">To<input id="modal_to" type="time" value="${item.to}" class="w-full border rounded px-3 py-2"></label>
            </div>
          </div>
        `, () => {
          const doctor = qs('#modal_doctor').value;
          const day = qs('#modal_day').value.trim();
          const from = qs('#modal_from').value;
          const to = qs('#modal_to').value;
          if (!doctor || !day || !from || !to) { alert('All fields required'); return; }
          const arr2 = Storage.get('schedules').map(s => s.id===id ? { ...s, doctor, day, from, to } : s);
          Storage.set('schedules', arr2); renderSchedules();
        });
      }

      if (entity === 'records') {
        openModal('Edit Record', `
          <div class="grid gap-3">
            <label class="block">Patient<input id="modal_patient" value="${escapeHtml(item.patient)}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Type<input id="modal_type" value="${escapeHtml(item.type)}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Date<input id="modal_date" type="date" value="${item.date}" class="w-full border rounded px-3 py-2"></label>
            <label class="block">Notes<textarea id="modal_notes" class="w-full border rounded px-3 py-2">${escapeHtml(item.notes||'')}</textarea></label>
          </div>
        `, () => {
          const patient = qs('#modal_patient').value.trim();
          const type = qs('#modal_type').value.trim();
          const date = qs('#modal_date').value;
          const notes = qs('#modal_notes').value.trim();
          if (!patient || !type || !date) { alert('Patient, type & date required'); return; }
          const arr2 = Storage.get('records').map(r => r.id===id ? { ...r, patient, type, date, notes } : r);
          Storage.set('records', arr2); renderRecords();
        });
      }
    }

    // Delete handler
    function handleDelete(entity, id) {
      const arr = Storage.get(entity).filter(x => x.id !== id);
      Storage.set(entity, arr);
      // re-render current panel
      if (entity === 'bookings') renderBookings();
      if (entity === 'doctors') renderDoctors();
      if (entity === 'users') renderUsers();
      if (entity === 'reminders') renderReminders();
      if (entity === 'schedules') renderSchedules();
      if (entity === 'records') renderRecords();
    }

    // Search binding
    function bindSearch() {
      qs('#globalSearch').addEventListener('input', (e) => {
        const q = e.target.value.trim();
        renderAll(q);
      });
    }

    // Export / Import CSV (simple)
    function toCSV(arr) {
      if (!arr || !arr.length) return '';
      const cols = Object.keys(arr[0]);
      const lines = [cols.join(',')].concat(arr.map(r => cols.map(c => `"${String(r[c]||'').replace(/"/g,'""')}"`).join(',')));
      return lines.join('\n');
    }
    function downloadCSV(name, csv) {
      const blob = new Blob([csv], { type: 'text/csv' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url; a.download = name; document.body.appendChild(a); a.click();
      a.remove(); URL.revokeObjectURL(url);
    }
    function bindExportImport() {
      qsa('[data-action="export"]').forEach(btn => {
        btn.addEventListener('click', () => {
          const entity = btn.getAttribute('data-entity');
          const arr = Storage.get(entity);
          const csv = toCSV(arr);
          downloadCSV(entity + '.csv', csv);
        });
      });
      qsa('[data-import]').forEach(inp => {
        inp.addEventListener('change', (e) => {
          const entity = inp.getAttribute('data-import');
          const file = e.target.files[0];
          if (!file) return;
          const reader = new FileReader();
          reader.onload = () => {
            const text = reader.result;
            // simple parse, assumes header row
            const lines = text.split(/\r?\n/).filter(Boolean);
            if (!lines.length) return;
            const headers = lines[0].split(',').map(h => h.replace(/^"|"$/g,''));
            const arr = lines.slice(1).map(l => {
              const values = l.match(/(".*?"|[^",\s]+)(?=\s*,|\s*$)/g) || [];
              const obj = {};
              headers.forEach((h,i) => { obj[h] = (values[i]||'').replace(/^"|"$/g,''); });
              obj.id = obj.id || uid();
              return obj;
            });
            Storage.set(entity, arr);
            renderAll();
            inp.value = '';
            alert('Imported ' + arr.length + ' rows into ' + entity);
          };
          reader.readAsText(file);
        });
      });
    }

    // Simple column sort (on bookings table as example)
    function bindSortHeaders() {
      qsa('#bookingsTable thead [data-sort]').forEach(th => {
        th.addEventListener('click', () => {
          const key = th.getAttribute('data-sort');
          const arr = Storage.get('bookings').slice().sort((a,b) => (''+a[key]).localeCompare(''+b[key]));
          Storage.set('bookings', arr);
          renderBookings();
        });
      });
    }

    // initialize all
    function init() {
      feather.replace();
      seedData();
      initTabs();
      bindAddEditButtons();
      bindTableActions();
      bindSearch();
      bindExportImport();
      bindSortHeaders();
      renderAll();
    }

    init();

  </script>
</body>
</html>
