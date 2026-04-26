<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - UniFAST-TDP SMS</title>
    <style>
        :root {
            --primary-red: #8A0303;
            --hover-red: #a50404;
            --dark-gray: #333333;
            --light-bg: #f4f4f4;
            --white: #ffffff;
            --text-main: #333333;
            --text-muted: #666666;
            --border-color: #eeeeee;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: var(--light-bg); 
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: var(--dark-gray);
            color: var(--white);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
        }

        .sidebar-header {
            padding: 2rem;
            text-align: center;
            background: rgba(0,0,0,0.1);
        }

        .sidebar-header h1 {
            font-size: 1.5rem;
            margin: 0;
            letter-spacing: 2px;
        }

        .nav-menu {
            flex-grow: 1;
            padding: 1rem 0;
        }

        .nav-item {
            padding: 1rem 2rem;
            display: block;
            color: var(--white);
            text-decoration: none;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(255,255,255,0.05);
            border-left: 4px solid var(--primary-red);
        }

        /* Main Content Area */
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            padding: 2rem;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: var(--white);
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 10px;
            border-bottom: 4px solid var(--primary-red);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .stat-card h3 {
            margin: 0;
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .stat-card p {
            margin: 10px 0 0;
            font-size: 2rem;
            font-weight: bold;
            color: var(--text-main);
        }

        /* Section Containers */
        .crud-section { 
            background: var(--white); 
            margin-bottom: 2rem; 
            padding: 2rem; 
            border-radius: 10px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
        }

        h2 { margin-top: 0; color: var(--dark-gray); border-bottom: 2px solid var(--border-color); padding-bottom: 10px; }

        .form-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 1rem; 
            margin-bottom: 1.5rem; 
            background: #fafafa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        input, select, textarea { 
            padding: 0.75rem; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            outline: none;
        }

        input:focus { border-color: var(--primary-red); }

        /* Buttons */
        .btn-primary { 
            background: var(--primary-red); 
            color: var(--white); 
            border: none; 
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            cursor: pointer; 
            font-weight: 600; 
            transition: 0.3s;
        }

        .btn-primary:hover { background: var(--hover-red); }

        .btn-logout {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid var(--border-color); }
        th { background: #f8f9fa; color: var(--dark-gray); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; }
        tr:hover { background: #fdfdfd; }

        .action-btn { padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-size: 0.85rem; border: none; cursor: pointer; color: white; }
        .edit { background: #4b5563; }
        .delete { background: var(--primary-red); }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h1>SMS ADMIN</h1>
        </div>
        <nav class="nav-menu">
            <a href="#" class="nav-item active">Dashboard</a>
            <a href="#" class="nav-item">Scholarships</a>
            <a href="#" class="nav-item">Applicants</a>
            <a href="#" class="nav-item">Reports</a>
        </nav>
    </div>

    <div class="main-content">
        
        <div class="top-bar">
            <div>Welcome back, <strong>{{ auth()->user()->name }}</strong></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Programs</h3>
                <p id="stat-progs">0</p>
            </div>
            <div class="stat-card">
                <h3>Total Applicants</h3>
                <p id="stat-apps">0</p>
            </div>
            <div class="stat-card">
                <h3>Pending Apps</h3>
                <p id="stat-pending">0</p>
            </div>
        </div>

        {{-- 1. Scholarship Programs --}}
        <div class="crud-section">
            <h2>📚 Scholarship Management</h2>
            <div class="form-grid">
                <input id="progName" placeholder="Program Name" required>
                <input id="progDesc" placeholder="Description">
                <input id="progAmount" type="number" placeholder="Grant Amount" step="0.01" required>
                <input id="progSlots" type="number" placeholder="Slots" required>
                <input id="progDeadline" type="date" required>
                <select id="progStatus">
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
                <button class="btn-primary" onclick="createProgram()">+ Create Program</button>
            </div>
            <table id="progTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Slots</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        {{-- 2. Applicants --}}
        <div class="crud-section">
            <h2>👤 Applicant Records</h2>
            <table id="appTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>School</th>
                        <th>Course</th>
                        <th>GPA</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>

    <script>
        const API_BASE = '/api';

        async function loadAll() {
            loadPrograms();
            loadApplicants();
        }

        async function loadPrograms() {
            const res = await fetch(API_BASE + '/scholarship-programs');
            const data = await res.json();
            document.getElementById('stat-progs').innerText = data.length;
            const tbody = document.querySelector('#progTable tbody');
            tbody.innerHTML = data.map(p => `
                <tr>
                    <td>${p.id}</td>
                    <td style="font-weight:600">${p.name}</td>
                    <td>₱${parseFloat(p.grant_amount).toLocaleString()}</td>
                    <td>${p.slots}</td>
                    <td>${new Date(p.deadline).toLocaleDateString()}</td>
                    <td><span style="color:${p.status === 'open' ? '#10b981' : '#ef4444'}; font-weight:bold">${p.status.toUpperCase()}</span></td>
                    <td>
                        <button class="action-btn edit" onclick="editProgram(${p.id})">Edit</button>
                        <button class="action-btn delete" onclick="deleteProgram(${p.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        async function loadApplicants() {
            const res = await fetch(API_BASE + '/applicants');
            const data = await res.json();
            document.getElementById('stat-apps').innerText = data.length;
            const tbody = document.querySelector('#appTable tbody');
            tbody.innerHTML = data.map(a => `
                <tr>
                    <td>${a.id}</td>
                    <td>${a.first_name} ${a.last_name}</td>
                    <td>${a.email}</td>
                    <td>${a.school}</td>
                    <td>${a.course}</td>
                    <td>${a.gpa}</td>
                    <td>
                        <button class="action-btn delete" onclick="deleteApplicant(${a.id})">Remove</button>
                    </td>
                </tr>
            `).join('');
        }

        async function createProgram() {
            const data = {
                name: document.getElementById('progName').value,
                description: document.getElementById('progDesc').value,
                grant_amount: parseFloat(document.getElementById('progAmount').value),
                slots: parseInt(document.getElementById('progSlots').value),
                deadline: document.getElementById('progDeadline').value,
                status: document.getElementById('progStatus').value
            };
            await fetch(API_BASE + '/scholarship-programs', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            loadPrograms();
        }

        async function deleteProgram(id) {
            if (confirm('Are you sure you want to delete this program?')) {
                await fetch(API_BASE + '/scholarship-programs/' + id, {method: 'DELETE'});
                loadPrograms();
            }
        }

        loadAll();
    </script>
</body>
</html>