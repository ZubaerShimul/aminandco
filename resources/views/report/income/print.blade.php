<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Striped Table with Centered Caption</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #fff2cd;
        }
        tr:nth-child(odd) {
            background-color: #ebd1dc;
        }
        h2 {
            caption-side: top;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }
		h3 {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Striped Table Example</h2>
<h3>Payment Report</h3>

<p>Date: 12/12/2023 - 31-12-2024</p>

<table>
    <tr>
        <th>Header 1</th>
        <th>Header 2</th>
        <th>Header 3</th>
    </tr>
    <tr>
        <td>Row 1, Cell 1</td>
        <td>Row 1, Cell 2</td>
        <td>Row 1, Cell 3</td>
    </tr>
    <tr>
        <td>Row 2, Cell 1</td>
        <td>Row 2, Cell 2</td>
        <td>Row 2, Cell 3</td>
    </tr>
    <tr>
        <td>Row 3, Cell 1</td>
        <td>Row 3, Cell 2</td>
        <td>Row 3, Cell 3</td>
    </tr>
    <tr>
        <td>Row 4, Cell 1</td>
        <td>Row 4, Cell 2</td>
        <td>Row 4, Cell 3</td>
    </tr>
</table>

</body>
</html>
