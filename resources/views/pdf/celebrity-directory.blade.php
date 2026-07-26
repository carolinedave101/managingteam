<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Celebrity Directory</title>
    <style>
        @page {
            margin: 15px 10px;
            size: A4 landscape;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 7pt;
            color: #1e293b;
        }
        .header {
            text-align: center;
            padding: 8px 0;
            border-bottom: 2px solid #e11d48;
            margin-bottom: 6px;
        }
        .header h1 {
            font-size: 14pt;
            margin-bottom: 2px;
        }
        .header p {
            font-size: 7pt;
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
            font-size: 6.5pt;
            text-align: left;
            padding: 3px 5px;
        }
        td {
            padding: 2px 5px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 6.5pt;
        }
        tr:nth-child(even) td {
            background: #f8fafc;
        }
        .num { text-align: center; width: 25px; }
        .name { font-weight: 600; }
        .gender { text-align: center; }
        .footer {
            text-align: center;
            font-size: 6pt;
            color: #94a3b8;
            padding: 8px 0 0 0;
            border-top: 1px solid #e2e8f0;
            margin-top: 6px;
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
                <th class="gender">Gender</th>
                <th>Country</th>
                <th>Instagram</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($celebrities as $i => $c)
                <tr>
                    <td class="num">{{ $i + 1 }}</td>
                    <td class="name">{{ $c['name'] }}</td>
                    <td>{{ $c['category_label'] }}</td>
                    <td class="gender">{{ $c['gender'] ?: '—' }}</td>
                    <td>{{ $c['country'] ?: '—' }}</td>
                    <td>{{ $c['instagram'] ?: '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ count($celebrities) }} celebrity entries
    </div>
</body>
</html>
