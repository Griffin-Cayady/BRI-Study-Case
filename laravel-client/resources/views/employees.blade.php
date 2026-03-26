<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees — Employee System</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f0f4f8;
            min-height: 100vh;
            color: #2d3748;
        }

        /* ── Header ── */
        header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2b6cb0 100%);
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
        }

        .header-left { display: flex; align-items: center; gap: 12px; }

        .logo {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
        }

        header h1 { font-size: 1.1rem; font-weight: 700; color: #fff; }
        header .sub { font-size: 0.75rem; color: rgba(255,255,255,0.6); }

        .header-right { display: flex; align-items: center; gap: 14px; }

        .jwt-badge {
            display: flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.85);
        }

        .jwt-dot {
            width: 7px; height: 7px;
            background: #68d391;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .logout-form button {
            background: rgba(255,255,255,0.15);
            border: 1.5px solid rgba(255,255,255,0.3);
            border-radius: 8px;
            padding: 7px 16px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s;
        }

        .logout-form button:hover { background: rgba(255,255,255,0.25); }

        /* ── Stats ── */
        .container { max-width: 1280px; margin: 0 auto; padding: 28px 24px; }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 18px 20px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            border-left: 4px solid var(--accent);
        }

        .stat-card .label { font-size: 0.75rem; font-weight: 600; color: #718096; text-transform: uppercase; letter-spacing: 0.05em; }
        .stat-card .value { font-size: 1.8rem; font-weight: 700; color: #1a202c; margin-top: 4px; }

        /* ── Toolbar ── */
        .toolbar {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 220px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 0.95rem;
            pointer-events: none;
        }

        .search-wrap input {
            width: 100%;
            padding: 10px 14px 10px 36px;
            border: 1.5px solid #e2e8f0;
            border-radius: 9px;
            font-size: 0.9rem;
            color: #2d3748;
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-wrap input:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49,130,206,0.1);
        }

        .filter-group { display: flex; gap: 8px; flex-wrap: wrap; }

        .filter-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            font-size: 0.82rem;
            font-weight: 600;
            color: #4a5568;
            cursor: pointer;
            transition: all 0.15s;
        }

        .filter-btn:hover { border-color: #3182ce; color: #3182ce; }
        .filter-btn.active { background: #3182ce; border-color: #3182ce; color: #fff; }

        .result-count {
            margin-left: auto;
            font-size: 0.82rem;
            color: #718096;
            white-space: nowrap;
            padding: 8px 0;
        }

        /* ── Table ── */
        .table-wrap {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }

        thead { background: #f7fafc; }

        thead th {
            padding: 13px 18px;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 700;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid #edf2f7;
        }

        tbody tr {
            border-bottom: 1px solid #f7fafc;
            transition: background 0.12s;
        }

        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #ebf8ff; }
        tbody tr.hidden { display: none; }

        tbody td { padding: 14px 18px; vertical-align: middle; }

        .td-id { font-weight: 700; color: #a0aec0; font-size: 0.82rem; }
        .td-name { font-weight: 600; color: #1a202c; }
        .td-manager { color: #4a5568; }
        .td-format, .td-hierarchy { font-family: 'Courier New', monospace; font-size: 0.8rem; color: #718096; }

        /* Level badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 0.76rem;
            font-weight: 700;
        }

        .badge-dot { width: 6px; height: 6px; border-radius: 50%; }

        .badge-0 { background: #ebf8ff; color: #2b6cb0; } .badge-0 .badge-dot { background: #3182ce; }
        .badge-1 { background: #f0fff4; color: #276749; } .badge-1 .badge-dot { background: #38a169; }
        .badge-2 { background: #faf5ff; color: #6b46c1; } .badge-2 .badge-dot { background: #805ad5; }
        .badge-3 { background: #fffaf0; color: #c05621; } .badge-3 .badge-dot { background: #dd6b20; }
        .badge-4 { background: #fff5f5; color: #c53030; } .badge-4 .badge-dot { background: #e53e3e; }

        .empty-state {
            text-align: center;
            padding: 56px 24px;
            color: #a0aec0;
        }

        .empty-state .icon { font-size: 2.5rem; margin-bottom: 12px; }
        .empty-state p { font-size: 0.95rem; }
    </style>
</head>
<body>

<header>
    <div class="header-left">
        <div class="logo">👥</div>
        <div>
            <h1>Employee Directory</h1>
            <div class="sub">BRI Study Case</div>
        </div>
    </div>
    <div class="header-right">
        <div class="jwt-badge">
            <span class="jwt-dot"></span>
            Authenticated via JWT
        </div>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit">Sign Out</button>
        </form>
    </div>
</header>

<div class="container">

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card" style="--accent:#3182ce;">
            <div class="label">Total Employees</div>
            <div class="value">{{ count($employees) }}</div>
        </div>
        <div class="stat-card" style="--accent:#38a169;">
            <div class="label">Top Manager</div>
            <div class="value" style="font-size:1.1rem; padding-top:6px;">
                {{ collect($employees)->where('path_level', '0')->first()['employee_name'] ?? '—' }}
            </div>
        </div>
        <div class="stat-card" style="--accent:#805ad5;">
            <div class="label">Max Depth</div>
            <div class="value">{{ collect($employees)->max('path_level') }}</div>
        </div>
        <div class="stat-card" style="--accent:#dd6b20;">
            <div class="label">Direct Reports</div>
            <div class="value">{{ collect($employees)->where('path_level', '1')->count() }}</div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <div class="search-wrap">
            <span class="search-icon">🔍</span>
            <input type="text" id="searchInput" placeholder="Search by name, manager, or hierarchy…">
        </div>

        <div class="filter-group">
            <button class="filter-btn active" data-level="all">All</button>
            @foreach(collect($employees)->pluck('path_level')->unique()->sort()->values() as $lvl)
                <button class="filter-btn" data-level="{{ $lvl }}">Level {{ $lvl }}</button>
            @endforeach
        </div>

        <div class="result-count" id="resultCount">Showing {{ count($employees) }} employees</div>
    </div>

    {{-- Table --}}
    <div class="table-wrap">
        <table id="empTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Manager</th>
                    <th>Level</th>
                    <th>Format</th>
                    <th>Hierarchy</th>
                </tr>
            </thead>
            <tbody id="empBody">
                @forelse ($employees as $emp)
                <tr data-level="{{ $emp['path_level'] }}"
                    data-search="{{ strtolower($emp['employee_name'] . ' ' . ($emp['manager_name'] ?? '') . ' ' . $emp['path_hierarchy']) }}">
                    <td class="td-id">#{{ $emp['employee_id'] }}</td>
                    <td class="td-name">{{ $emp['employee_name'] }}</td>
                    <td class="td-manager">{{ $emp['manager_name'] ?? '—' }}</td>
                    <td>
                        <span class="badge badge-{{ $emp['path_level'] }}">
                            <span class="badge-dot"></span>
                            Level {{ $emp['path_level'] }}
                        </span>
                    </td>
                    <td class="td-format">{{ $emp['employee_format'] }}</td>
                    <td class="td-hierarchy">{{ $emp['path_hierarchy'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="icon">📭</div>
                            <p>No employee data found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div id="noResults" style="display:none;">
            <div class="empty-state">
                <div class="icon">🔍</div>
                <p>No employees match your search.</p>
            </div>
        </div>
    </div>

</div>

<script>
    const searchInput  = document.getElementById('searchInput');
    const filterBtns   = document.querySelectorAll('.filter-btn');
    const rows         = document.querySelectorAll('#empBody tr[data-level]');
    const resultCount  = document.getElementById('resultCount');
    const noResults    = document.getElementById('noResults');

    let activeLevel = 'all';

    function applyFilters() {
        const query = searchInput.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach(row => {
            const matchSearch = !query || row.dataset.search.includes(query);
            const matchLevel  = activeLevel === 'all' || row.dataset.level === activeLevel;

            if (matchSearch && matchLevel) {
                row.classList.remove('hidden');
                visible++;
            } else {
                row.classList.add('hidden');
            }
        });

        resultCount.textContent = `Showing ${visible} of ${rows.length} employees`;
        noResults.style.display = visible === 0 ? 'block' : 'none';
        document.getElementById('empTable').style.display = visible === 0 ? 'none' : 'table';
    }

    searchInput.addEventListener('input', applyFilters);

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeLevel = btn.dataset.level;
            applyFilters();
        });
    });
</script>

</body>
</html>
