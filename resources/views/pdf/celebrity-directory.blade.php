<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Celebrity Directory</title>
    <style>
        @page {
            margin: 20px 15px;
            size: A4 landscape;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 7.5pt;
            color: #1e293b;
        }
        .header {
            text-align: center;
            padding: 10px 0 8px 0;
            border-bottom: 2px solid #e11d48;
            margin-bottom: 8px;
        }
        .header h1 {
            font-size: 16pt;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .header p {
            font-size: 8pt;
            color: #64748b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #e11d48;
            color: #fff;
            font-weight: 600;
            font-size: 7pt;
            text-align: left;
            padding: 4px 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 3px 6px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 7pt;
        }
        tr:nth-child(even) td {
            background: #f8fafc;
        }
        .num {
            text-align: center;
            color: #94a3b8;
            font-size: 6.5pt;
            width: 30px;
        }
        .name {
            font-weight: 600;
            color: #0f172a;
        }
        .category {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 3px;
            font-size: 6.5pt;
            font-weight: 600;
        }
        .category-general { background: #f1f5f9; color: #475569; }
        .category-movie_star { background: #eef2ff; color: #4338ca; }
        .category-country_singer { background: #fffbeb; color: #b45309; }
        .category-musician { background: #fdf2f8; color: #be185d; }
        .category-adult_star { background: #faf5ff; color: #7c3aed; }
        .gender {
            text-align: center;
        }
        .country {
            color: #475569;
        }
        .instagram {
            color: #e11d48;
            font-size: 6.5pt;
        }
        .footer {
            text-align: center;
            font-size: 6.5pt;
            color: #94a3b8;
            padding: 10px 0 0 0;
            border-top: 1px solid #e2e8f0;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Celebrity Directory</h1>
        <p>Complete listing of all celebrities &middot; Generated {{ now()->format('F j, Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="num">#</th>
                <th>Name</th>
                <th>Category</th>
                <th style="text-align:center;">Gender</th>
                <th>Country</th>
                <th>Instagram</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($celebrities as $i => $c)
                <tr>
                    <td class="num">{{ $i + 1 }}</td>
                    <td class="name">{{ $c['name'] }}</td>
                    <td>
                        <span class="category category-{{ $c['category_key'] }}">{{ $c['category_label'] }}</span>
                    </td>
                    <td class="gender">{{ $c['gender'] ?: '—' }}</td>
                    <td class="country">{{ $c['country'] ?: '—' }}</td>
                    <td class="instagram">{{ $c['instagram'] ?: '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ count($celebrities) }} celebrity {{ Str::plural('entry', count($celebrities)) }}
    </div>
</body>
</html>
