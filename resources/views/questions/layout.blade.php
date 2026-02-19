<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Seachan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-start: #eff6ff;
            --bg-end: #f3e8ff;
            --ink: #1f2937;
            --ink-soft: #64748b;
            --card-bg: #ffffff;
            --line: #e2e8f0;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --danger: #ef4444;
            --danger-dark: #dc2626;
            --success-bg: #ecfdf5;
            --success-ink: #065f46;
            --chip-bg: #eef2ff;
            --chip-ink: #3730a3;
            --shadow-lg: 0 10px 30px rgba(15, 23, 42, 0.12);
            --shadow-sm: 0 6px 16px rgba(37, 99, 235, 0.2);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Poppins", "Segoe UI", sans-serif;
            color: var(--ink);
            background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
        }

        .page-shell {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px 16px 36px;
        }

        .hero {
            text-align: center;
            margin-bottom: 18px;
        }

        .hero-title {
            margin: 0;
            font-size: clamp(1.8rem, 4.5vw, 2.5rem);
            font-weight: 700;
            line-height: 1.2;
            color: transparent;
            background: linear-gradient(90deg, #2563eb, #7c3aed);
            background-clip: text;
            -webkit-background-clip: text;
        }

        .page-panel {
            background: var(--card-bg);
            border-radius: 18px;
            box-shadow: var(--shadow-lg);
            border: 1px solid #ffffff;
            padding: clamp(16px, 2.7vw, 26px);
        }

        .panel-narrow {
            max-width: 780px;
            margin: 0 auto;
        }

        .page-title {
            font-weight: 700;
            line-height: 1.25;
            font-size: clamp(1.4rem, 3.5vw, 1.9rem);
            margin: 0;
            color: var(--ink);
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            margin-left: auto;
        }

        .top-actions .btn {
            white-space: nowrap;
        }

        .btn-brand {
            border: none;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            color: #fff;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
            border-radius: 12px;
            padding: 10px 15px;
            transition: transform 0.15s ease, filter 0.15s ease;
        }

        .btn-brand:hover {
            color: #fff;
            transform: translateY(-1px);
            filter: brightness(1.02);
        }

        .btn-neutral {
            border: 1px solid #cbd5e1;
            color: #334155;
            background: #f8fafc;
            font-weight: 600;
            border-radius: 12px;
            padding: 8px 14px;
            transition: background-color 0.15s ease, transform 0.15s ease;
        }

        .btn-neutral:hover {
            background: #eef2ff;
            color: #1e3a8a;
            transform: translateY(-1px);
        }

        .btn-danger-soft {
            border: none;
            background: var(--danger);
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: 8px 14px;
            transition: transform 0.15s ease, background-color 0.15s ease;
        }

        .btn-danger-soft:hover {
            color: #fff;
            background: var(--danger-dark);
            transform: translateY(-1px);
        }

        .alert-custom {
            border: 1px solid #a7f3d0;
            background: var(--success-bg);
            color: var(--success-ink);
            border-radius: 12px;
            padding: 10px 12px;
            font-weight: 500;
            margin-bottom: 14px;
        }

        .alert-danger-custom {
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
            border-radius: 12px;
            padding: 12px 14px;
            margin-bottom: 16px;
        }

        .error-title {
            margin: 0 0 8px;
            font-size: 0.95rem;
            font-weight: 700;
        }

        .error-list {
            margin: 0;
            padding-left: 20px;
        }

        .table-shell {
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
        }

        .question-table {
            margin: 0;
            min-width: 600px;
        }

        .question-table thead th {
            border-bottom: none;
            background: #1d4ed8;
            color: #fff;
            font-size: 0.82rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            padding: 12px 14px;
        }

        .question-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .question-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .question-table td {
            padding: 12px 14px;
            border-color: var(--line);
            vertical-align: middle;
        }

        .question-cell {
            font-weight: 500;
            color: #1e293b;
        }

        .answer-chip {
            display: inline-block;
            border-radius: 999px;
            padding: 6px 10px;
            background: var(--chip-bg);
            color: var(--chip-ink);
            font-size: 0.82rem;
            font-weight: 600;
        }

        .action-stack {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-stack form {
            margin: 0;
        }

        .empty-state {
            text-align: center;
            border: 1px dashed #cbd5e1;
            border-radius: 16px;
            padding: 30px 16px;
            background: #f8fafc;
        }

        .empty-title {
            margin-bottom: 8px;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ink);
        }

        .empty-text {
            color: var(--ink-soft);
            margin-bottom: 16px;
        }

        .form-label {
            color: #334155;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.2);
        }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .page-shell {
                padding-top: 16px;
            }

            .page-panel {
                border-radius: 18px;
                padding: 16px 14px;
            }

            .question-table {
                min-width: 540px;
            }

            .top-bar {
                overflow-x: auto;
            }

            .action-stack .btn {
                width: auto;
            }

            .form-footer .btn {
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <main class="page-shell">
        <header class="hero">
            <h1 class="hero-title">Seachan - Question Manager</h1>
        </header>
        @yield('content')
    </main>
</body>
</html>
