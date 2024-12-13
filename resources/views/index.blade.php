@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Items List</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('items.create') }}" class="btn btn-primary ">Create New Item</a>
        
        

       <div class="d-flex">
        <form action="{{ route('items.importCsv') }}" method="POST" enctype="multipart/form-data" class="">
            @csrf
           <div class="d-flex align-items-center">
            <input type="file" name="file" id="csvFile" accept=".csv" class="form-control me-2" required>
            <button type="submit" id="importBtn" class="btn btn-primary btn-sm mt-2 me-3 p-0">Import Items</button>
           </div>
        </form>
        <!-- Export Button -->
        <button id="exportBtn" class="btn btn-success btn-sm">Export Table Data</button>
       </div>
    </div>

    @if (session('success'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-bordered" id="itemsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone</th>
                <th>address</th>
                <th>city</th>
                <th>state</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->age }}</td>
                    <td>{{ $item->gender }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->city }}</td>
                    <td>{{ $item->state }}</td>

                    <td>
                        <a href="{{ route('items.show', $item->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add JavaScript to Export Table Data -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
<script>
    // Function to export the table data to CSV
    document.getElementById('exportBtn').addEventListener('click', function() {
        var table = document.getElementById('itemsTable');
        var rows = table.querySelectorAll('tr');
        var csvData = [];
    
        rows.forEach(function(row, index) {
            var rowData = [];
            var cols = row.querySelectorAll('td, th');
            
            // Exclude the last column (Actions column)
            for (var i = 0; i < cols.length - 1; i++) {
                rowData.push('"' + cols[i].innerText.replace(/"/g, '""') + '"');
            }

            // If not the first row (the header), append to the CSV array
            if (index !== 0) {
                csvData.push(rowData.join(','));
            } else {
                // For the header row, add a header row
                csvData.unshift(rowData.join(','));
            }
        });
    
        // Create a CSV Blob
        var csvFile = new Blob([csvData.join('\n')], { type: 'text/csv' });
        
        // Create a link to trigger the download
        var link = document.createElement('a');
        link.href = URL.createObjectURL(csvFile);
        link.download = 'items.csv'; // The name of the CSV file
        
        // Trigger the download by simulating a click
        link.click();
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to handle CSV file upload and import
    document.getElementById('importBtn').addEventListener('click', function() {
        var fileInput = document.getElementById('csvFile');
        var file = fileInput.files[0];
        
        if (file && file.type === 'text/csv') {
            var formData = new FormData();
            formData.append('file', file);
    
            // Send the CSV file via AJAX to the server for processing
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/path-to-your-server-endpoint', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        alert('Data imported successfully');
                        // Optionally, update the table here based on imported data
                    } else {
                        reloadPage();
                    }
                } else {
                   reloadPage();
                }
            };
            xhr.send(formData);
        } else {
            alert('Please upload a valid CSV file');
        }
    });
    </script>

@endsection
