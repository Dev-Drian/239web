$(document).ready(function () {
    let keywords = [];
    let processedCount = 0;
    let intervalId;
    let results = [];

    $('#printTable').on('click', function () {
        const tableRows = $('#resultsBody tr');

        if (tableRows.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Data to Print',
                text: 'There are no results to print. Please update the data first.',
            });
            return;
        }

        // Preload logo image
        const img = new Image();
        img.src = logoUrl;

        img.onload = function () {
            const printWindow = window.open('', '_blank');
            const printDate = new Date().toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            printWindow.document.write(`
                            <html>
                                <head>
                                    <title>Keyword Ranking Report</title>
                                    <style>
                                        @page { margin: 20px; }
                                        body { 
                                            font-family: 'Arial', sans-serif; 
                                            margin: 40px;
                                        }
                                        .header {
                                            border-bottom: 2px solid #4C6A92;
                                            padding-bottom: 20px;
                                            margin-bottom: 30px;
                                            display: flex;
                                            justify-content: space-between;
                                            align-items: center;
                                        }
                                        .logo {
                                            width: 200px;
                                        }
                                        .report-title {
                                            color: #2c3e50;
                                            font-size: 24px;
                                            margin: 0;
                                        }
                                        .report-date {
                                            color: #7f8c8d;
                                            font-size: 14px;
                                            text-align: right;
                                        }
                                        table {
                                            width: 100%;
                                            border-collapse: collapse;
                                            margin-top: 20px;
                                        }
                                        th {
                                            background-color: #4C6A92;
                                            color: white;
                                            padding: 15px;
                                            text-align: left;
                                            font-size: 14px;
                                        }
                                        td {
                                            padding: 12px;
                                            border-bottom: 1px solid #ecf0f1;
                                            color: #2c3e50;
                                        }
                                        tr:nth-child(even) {
                                            background-color: #f8f9fa;
                                        }
                                        .footer {
                                            margin-top: 30px;
                                            padding-top: 20px;
                                            border-top: 1px solid #bdc3c7;
                                            text-align: center;
                                            color: #7f8c8d;
                                            font-size: 12px;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class="header">
                                        <img src="${logoUrl}" class="logo" alt="Company Logo">
                                        <div>
                                            <h1 class="report-title">SEO Position Report</h1>
                                            <p class="report-date">Generated: ${printDate}</p>
                                        </div>
                                    </div>
                                    <table>
                                        <thead>
                                            <tr>
                                                ${$('#resultsBody thead th').map((i, th) => `<th>${$(th).text()}</th>`).get().join('')}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${$('#resultsBody tr').map((i, tr) => `
                                                                                <tr>
                                                                                    ${$(tr).find('td').map((j, td) => `<td>${$(td).text()}</td>`).get().join('')}
                                                                                </tr>
                                                                            `).get().join('')}
                                        </tbody>
                                    </table>
                                    <div class="footer">
                                        Confidential Report - Generated by SEO Analytics Tool
                                    </div>
                                </body>
                            </html>
                            `);

            // Delay printing to ensure content loads
            setTimeout(() => {
                printWindow.document.close();
                printWindow.print();
                printWindow.close();
            }, 500);
        };

        img.onerror = function () {
            Swal.fire({
                icon: 'error',
                title: 'Logo Error',
                text: 'Could not load company logo for printing',
            });
        };
    });

    // Cargar resultados históricos al inicio
    loadSavedResults();

    // Manejo del archivo CSV
    $('#csvFile').on('change', function (event) {
        handleCsvUpload(event);
    });

    // Añadir keyword manualmente
    $('#addKeyword').click(function () {
        addKeywordManually();
    });

    // Manejo del formulario
    $('#keywordForm').on('submit', function (e) {
        handleFormSubmission(e);
    });

    // Botón para obtener volúmenes y CPC para todas las keywords a la vez
    $('#getKeywordData').click(function () {
        getKeywordData();
    });

    // Guardar los resultados en la base de datos
    $('#saveResults').click(function () {
        saveResults();
    });

    // Exportar a CSV
    $('#exportCsv').click(function () {
        exportToCsv();
    });

    // Hacer la función removeKeyword global para que funcione con onclick
    window.removeKeyword = function (keyword) {
        removeKeywordFromList(keyword);
    };
});