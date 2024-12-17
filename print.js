function printTable() {
    // Ambil elemen yang berisi data siswa
    const container = document.querySelector('.container');

    if (!container || container.innerHTML.trim() === '') {
        alert('Tidak ada data untuk dicetak.');
        return;
    }

    // Buat jendela baru untuk mencetak
    const printWindow = window.open('', '_blank');

    // Struktur HTML yang akan dicetak
    printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Print Data Siswa</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    text-align: center;
                }
                .card {
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    margin: 10px auto;
                    padding: 15px;
                    width: 80%;
                    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                }
                img {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                }
                h3 {
                    font-size: 18px;
                    margin: 10px 0;
                }
                p {
                    margin: 5px 0;
                    color: #555;
                }
            </style>
        </head>
        <body>
            <h1>Data Siswa</h1>
            ${container.innerHTML}
        </body>
        </html>
    `);

    // Fokuskan jendela dan panggil fungsi cetak
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
