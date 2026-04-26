<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretary Dashboard - UniFAST-TDP SMS</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f1f5f9; }
        .header { background:#10b981; color:#fff; padding:1rem; position:sticky; top:0; z-index:10; }
        .container { max-width: 1400px; margin: 0 auto; padding: 1rem; }
        .nav { display:flex; gap:1rem; }
        h2 { margin: 1.5rem 0 1rem; color:#059669; }
        .crud-section { background:#fff; margin-bottom:2rem; padding:1.5rem; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        .form-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:1rem; margin-bottom:1rem; }
        input, select, textarea, button { padding: 0.65rem; border: 1px solid #d1d5db; border-radius: 5px; font-size:1rem; }
        button { background:#10b981; color:#fff; border:none; cursor:pointer; font-weight:600; }
        button:hover { background:#059669; }
        table { width:100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border:1px solid #e5e7eb; padding:0.75rem; text-align:left; }
        th { background:#10b981; color:#fff; font-weight:600; }
        tr:nth-child(even) { background:#f9fafb; }
        .action-btn { padding:0.4rem 0.8rem; margin:0 0.2rem; border-radius:4px; text-decoration:none; font-size:0.85rem; }
        .edit { background:#3b82f6; color:#fff; }
        .delete { background:#ef4444; color:#fff; }
        .notice { background:#d1fae5; border:1px solid #a7f3d0; padding:1rem; border-radius:6px; margin-bottom:1rem; }
        .disabled { opacity:0.5; pointer-events:none; }
    </style>
</head>
<body>
    <div class="header">
        <div class="container" style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Secretary Dashboard</h1>
            <div class="nav">
                <span>Logged as: <strong>{{ auth()->user()->name }}</strong> (Secretary)</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:#dc2626;">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="notice">
            <strong>Secretary Access:</strong> CRUD on Applicants, Applications, Requirements | <em>View Programs only</em>
        </div>

        {{-- 1. Scholarship Programs (View Only) --}}
        <div class="crud-section disabled">
            <h2>📚 Scholarship Programs <span style="color:#6b7280">(View Only)</span></h2>
            <table id="progTable">
                <thead><tr><th>ID</th><th>Name</th><th>Amount</th><th>Slots</th><th>Deadline</th><th>Status</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>

        {{-- 2. Applicants --}}
        <div class="crud-section">
            <h2>👤 Applicants</h2>
            <div class="form-grid">
                <input id="secAppFname" placeholder="First Name" required>
                <input id="secAppLname" placeholder="Last Name" required>
                <input id="secAppEmail" type="email" placeholder="Email" required>
                <input id="secAppContact" placeholder="Contact" required>
                <input id="secAppSchool" placeholder="School" required>
                <input id="secAppCourse" placeholder="Course" required>
                <input id="secAppGpa" type="number" step="0.01" min="0" max="5" placeholder="GPA" required>
                <input id="secAppBdate" type="date" required>
                <button onclick="createSecApplicant()">+ Create</button>
            </div>
            <table id="secAppTable">
                <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>School</th><th>Course</th><th>GPA</th><th>Actions</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>

        {{-- 3. Applications --}}
        <div class="crud-section">
            <h2>📋 Applications</h2>
            <div class="form-grid">
                <input id="secAppId" type="number" placeholder="Applicant ID" required>
                <input id="secProgId" type="number" placeholder="Program ID" required>
                <input id="secStatus" placeholder="Status" required>
                <input id="secRemarks" placeholder="Remarks">
                <button onclick="createSecApplication()">+ Create</button>
            </div>
            <table id="secAppTableApps">
                <thead><tr><th>ID</th><th>Applicant</th><th>Program</th><th>Status</th><th>Remarks</th><th>Actions</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>

        {{-- 4. Requirements --}}
        <div class="crud-section">
            <h2>📄 Requirements</h2>
            <div class="form-grid">
                <input id="secReqProgId" type="number" placeholder="Program ID" required>
                <input id="secReqDoc" placeholder="Document Name" required>
                <select id="secReqReq">
                    <option value="1">Required</option>
                    <option value="0">Optional</option>
                </select>
                <button onclick="createSecRequirement()">+ Create</button>
            </div>
            <table id="secReqTable">
                <thead><tr><th>ID</th><th>Program</th><th>Document</th><th>Required</th><th>Actions</th></tr></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
        const API_BASE = '/api';

        async function loadPrograms() {
            const res = await fetch(API_BASE + '/scholarship-programs');
            const data = await res.json();
            document.querySelector('#progTable tbody').innerHTML = data.map(p => `
                <tr><td>${p.id}</td><td>${p.name}</td><td>$${p.grant_amount}</td><td>${p.slots}</td><td>${new Date(p.deadline).toLocaleDateString()}</td><td><span style="color:${p.status === 'open' ? '#10b981' : '#ef4444'}">${p.status.toUpperCase()}</span></td></tr>
            `).join('');
        }

        // Secretary Applicants CRUD
        async function loadApplicantsSec() {
            // similar to admin
        }

        // etc...

        loadPrograms();
        // load secretary data...
    </script>
</body>
</html>

