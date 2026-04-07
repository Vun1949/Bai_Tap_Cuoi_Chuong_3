<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Course Management System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-w: 260px; }
        .app-shell { min-height: 100vh; }
        .app-sidebar { width: var(--sidebar-w); flex: 0 0 var(--sidebar-w); }
        .app-content { min-width: 0; }
        .course-img { width: 72px; height: 48px; object-fit: cover; border-radius: .5rem; background: #f1f3f5; }
        .table td, .table th { vertical-align: middle; }
    </style>
</head>
<body class="bg-light">
    <div class="d-flex app-shell">
        <aside class="app-sidebar border-end bg-white p-3">
            <div class="mb-3">
                <div class="fw-bold">CMS</div>
                <div class="text-muted small">Course Management System</div>
            </div>

            <x-sidebar />
        </aside>

        <main class="app-content flex-grow-1">
            <div class="container-fluid p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h1 class="h4 mb-1">@yield('page_title', 'Dashboard')</h1>
                        @hasSection('page_subtitle')
                            <div class="text-muted small">@yield('page_subtitle')</div>
                        @endif
                    </div>
                    <div class="text-muted small">
                        SQLite • Laravel
                    </div>
                </div>

                <x-alert />

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

