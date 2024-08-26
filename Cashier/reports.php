<?php
// Include the database connection
include '../connections.php';

// Include the HTML header
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Include the styles and scripts from nav.php -->
    <?php include("nav.php"); ?>
    
</head>
<style>
    
    .reports-container {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-top: 20px;
        background-color: white;
       
    }

    .report-box {
        background-color: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin-top: 50px;
        margin-bottom: 50px;
        position: relative;
        width: 45%;
    }

    .report-box h2 {
        color: #333;
        font-size: 1.5rem;
        margin-bottom: 20px; /* Adjusted margin */
    }

    .box-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        color: #333; /* Icon color */
    }

    .export-buttons {
        margin-top: 55px;
        display: flex;
        justify-content: center; /* Center the buttons horizontally */
    }

    .export-buttons button {
        background-color: #4caf50;
        color: #fff;
        padding: 5px 8px; /* Adjusted padding */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 0 6px; /* Adjusted margin */
        font-size: 14px;
        
        letter-spacing: 1px;
        transition: background-color 0.3s ease; /* Smooth button hover effect */
    }

    .export-buttons button:hover {
        background-color: #45a049;
    }


    .table-container {
            width: 100%;
            margin-top: 20px;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-family: 'Arial, sans-serif';
            font-size: 11px;
        }

        .table-container th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            font-size: 12px;
        }

        .table-container td:first-child {
            text-align: left;
        }

        .table-container tr:nth-child(even) {
            background-color: #f9f9f9;
        
            .modal-content.small {
    width: 300px;
    
}

.modal-title {
    font-size: 1.2rem;
}

.modal-message {
    font-size: 1rem;
    margin-bottom: 2px;
}

.logout-actions {
    display: flex;
    justify-content: space-between;
}

.logout-btn,
.cancel-btn {
    padding: 8px 16px;
    font-size: 0.9rem;
}}
</style>

<body>
   


<!-- ================= Reports Container ================ -->
<div class="reports-container" id="reportsContainer">

    <!-- Box 1: Export Inventory List -->
    <div class="report-box">
        <ion-icon class="box-icon" name="list-outline"></ion-icon>
        <h2>Export Inventory List</h2>
        <div class="export-buttons">
            <button onclick="exportToExcel('inventoryList')">Excel</button>
            <button onclick="exportToPDF('inventoryList')">PDF</button>
        </div>
    </div>

    <!-- Box 2: Export Purchase Order -->
<div class="report-box">
    <ion-icon class="box-icon" name="file-tray-full-outline"></ion-icon>
    <h2>Export Purchase Order</h2>
    <div class="export-buttons">
        <button onclick="exportPurchaseOrder('Excel')">Excel</button>
        <button onclick="exportPurchaseOrder('PDF')">PDF</button>
    </div>
    
</div>





</div>





<!-- pdf -->


<!-- ================= Export Functions ================ -->

<!-- Export Functions -->
<script>
    function exportToPDF(data, filename, tableName) {
    // Create a container for the data to be exported
    const container = document.createElement('div');

    // Add header to the container
    const header = document.createElement('div');
    header.style.textAlign = 'center';
    header.style.marginBottom = '20px';

    // Add company name
    const companyName = document.createElement('h1');
   companyName.textContent = 'BRL Trading';
   companyName.style.color = '#333'; // Set text color
   header.appendChild(companyName);

    // Add company logo and header text in the same line
    const logoAndHeaderTextWrapper = document.createElement('div');
    logoAndHeaderTextWrapper.style.display = 'flex'; // Use flexbox for layout

    // Add company logo (replace 'path/to/logo.png' with the actual path to your logo)
    const companyLogo = document.createElement('img');
    companyLogo.src = 'ASSETS/imgs/logo_brl.png'; // Replace with the actual path to your logo
    companyLogo.style.width = '100px'; // Adjust width as needed
    companyLogo.style.height = 'auto';
    logoAndHeaderTextWrapper.appendChild(companyLogo);


    // Add header text
    const headerText = document.createElement('h2');
    headerText.textContent = 'BRL Trading';
    headerText.style.marginLeft = '20px'; // Adjust the margin as needed for spacing
    headerText.style.marginTop = '20px';
    logoAndHeaderTextWrapper.appendChild(headerText);

    // Append the wrapper to the header
    header.appendChild(logoAndHeaderTextWrapper);

    container.appendChild(header);

    // Create a table and append it to the container
    const table = document.createElement('table');
    table.style.width = '80%'; // Set the table width (adjust as needed)
    table.style.borderCollapse = 'collapse'; // Collapse borders for better styling
    table.style.marginTop = '20px'; // Add margin to separate header and table

    const headerRow = table.insertRow(0);

    // Add header cells with styling
    Object.keys(data[0]).forEach(key => {
        const th = document.createElement('th');
        th.textContent = key;
        th.style.border = '1px solid #ddd'; // Border styling
        th.style.padding = '8px';
        th.style.textAlign = 'left';
        th.style.backgroundColor = '#f2f2f2'; // Header background color
        th.style.color = '#333';
        headerRow.appendChild(th);
    });

    // Add data rows with enhanced styling
    data.forEach((rowData, rowIndex) => {
        const row = table.insertRow();
        Object.values(rowData).forEach((value, index) => {
            const cell = row.insertCell();
            cell.textContent = value;
            cell.style.border = '1px solid #ddd'; // Border styling
            cell.style.padding = '12px'; // Increased padding for better spacing
            cell.style.textAlign = index === 0 ? 'left' : 'center'; // Align the first column to the left, others to center
            cell.style.fontWeight = index === 0 ? 'bold' : 'normal'; // Bolden the text in the first column
            cell.style.background = rowIndex % 2 === 0 ? '#f9f9f9' : 'transparent'; // Alternate row background color
            cell.style.color = '#333'; // Text color
            cell.style.fontFamily = 'Arial, sans-serif'; // Font family
        });
    });

    // Append the table to the container
    container.appendChild(table);

    // Use html2pdf to export the container content as PDF
    html2pdf(container, {
        filename: `${filename}_${tableName}`,
        margin: 10,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    });
}

    function exportToExcel(data, filename) {
        const worksheet = XLSX.utils.json_to_sheet(data);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet 1');
        XLSX.writeFile(workbook, filename + '.xlsx');
    }

    function exportTo(format, data, filename) {
        console.log(`Exporting data to ${format.toUpperCase()}`);

        if (format === 'PDF') {
            exportToPDF(data, filename);
        } else if (format === 'Excel') {
            exportToExcel(data, filename);
        }

        console.log(`${format.toUpperCase()} Exported Successfully`);
    }

    function exportInventory(format) {
        const filename = 'inventory_data';
        fetch('get_inventory_data.php')
            .then(response => response.json())
            .then(data => {
                exportTo(format, data, filename);
            })
            .catch(error => {
                console.error('Error exporting inventory data:', error);
            });
    }


    // Attach the export functions to the respective buttons
    document.querySelector(".reports-container .report-box:nth-child(1) button:nth-child(1)").addEventListener("click", function () {
        exportInventory('Excel');
    });
    document.querySelector(".reports-container .report-box:nth-child(1) button:nth-child(2)").addEventListener("click", function () {
        exportInventory('PDF');
    });


    function exportToPDF(data, filename, tableName) {
    // Create a container for the data to be exported
    const container = document.createElement('div');

    // Add data table to the container
    const tableContainer = document.createElement('div');
    tableContainer.classList.add('table-container');
    const table = document.createElement('table');

    // Add header row
    const headerRow = table.insertRow();
    Object.keys(data[0]).forEach(key => {
        const th = document.createElement('th');
        th.textContent = key;
        headerRow.appendChild(th);
    });

    // Add data rows
    data.forEach(rowData => {
        const row = table.insertRow();
        Object.values(rowData).forEach(value => {
            const cell = row.insertCell();
            cell.textContent = value;
        });
    });

    // Append the table to the container
    tableContainer.appendChild(table);
    container.appendChild(tableContainer);

    // Use html2pdf to export the container content as PDF
    html2pdf(container, {
        filename: `${filename}_${tableName}.pdf`,
        margin: 10,
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        },
        html2canvas: { scale: 2 },
        pagebreak: { avoid: '.avoid-page-break' } // Add this line to avoid page break inside a table cell
    });
}

// Example usage
const sampleData = [
    { column1: 'value1', column2: 'value2' },
    { column1: 'value3', column2: 'value4' },
];

exportToPDF(sampleData, 'example', 'exampleTable');

 //purchase
 
 function exportPurchaseOrder(format) {
        const filename = 'purchase_order_data';
        fetch('get_purchase_order_data.php')
            .then(response => response.json())
            .then(data => {
                exportTo(format, data, filename, 'purchaseOrderTable');
            })
            .catch(error => {
                console.error('Error exporting purchase order data:', error);
            });
    }
</script>






    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>
    

        <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.6/jspdf.plugin.autotable.min.js"></script>

    <!-- Include XLSX library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

    <!-- Include html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>



    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="assets/js/chartsJS.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>