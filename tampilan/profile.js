function printmahasiswa() {
    // Temukan elemen iframe
    var printFrame = document.getElementById('print-frame');

    // Set src iframe ke halaman print.php
    printFrame.src = 'index.php?page=print';

    // Tunggu sampai halaman di iframe selesai dimuat, lalu cetak
    printFrame.onload = function () {
        printFrame.contentWindow.focus();
        printFrame.contentWindow.print();
    };
}

function printData(nim) {
    // Temukan elemen iframe
    var printFrame = document.getElementById('print-frame');

    // Set src iframe ke halaman student-card.php dengan parameter nim
    printFrame.src = 'student-card.php?nim=' + nim;

    // Tunggu sampai halaman di iframe selesai dimuat, lalu cetak
    printFrame.onload = function () {
        printFrame.contentWindow.focus();
        printFrame.contentWindow.print();
    };
}



// Function to edit profile (Updated to work with table)
function editProfile(button) {
    let row = button.parentElement.parentElement;
    let nim = row.cells[1].innerText;
    let name = row.cells[2].innerText;
    let prodi = row.cells[3].innerText;
    let fakultas = row.cells[4].innerText;

    // Prompt user to edit data
    let newNim = prompt("Edit NIM:", nim);
    let newName = prompt("Edit Name:", name);
    let newProdi = prompt("Edit Prodi:", prodi);
    let newFakultas = prompt("Edit Fakultas:", fakultas);

    if (newNim && newName && newProdi && newFakultas) {
        row.cells[1].innerText = newNim;
        row.cells[2].innerText = newName;
        row.cells[3].innerText = newProdi;
        row.cells[4].innerText = newFakultas;
    }
}

// Function to delete profile
function deleteProfile(button) {
    if (confirm("Are you sure you want to delete this profile?")) {
        let row = button.parentElement.parentElement;
        row.remove();
    }
}

// Function to print profile (using window.print)
function printProfile() {
    window.print();
}

// Function to add new profile (and handle modal)
function addProfile() {
    // Show modal to add profile
    let modal = document.getElementById('modal');
    modal.style.display = 'flex';
}

// Function to close modal
function closeModal() {
    var modal = document.getElementById('modal');
    modal.style.display = 'none';
}

// Function to save new profile data from the form
function saveNewProfile(event) {
    event.preventDefault();

    // Get data from form inputs
    let nim = document.getElementById('nim').value;
    let nama = document.getElementById('nama').value;
    let prodi = document.getElementById('prodi').value;
    let fakultas = document.getElementById('fakultas').value;

    // Add new row to table
    let tableBody = document.getElementById("profile-body");
    let newRow = document.createElement("tr");

    let rowCount = tableBody.rows.length + 1;
    newRow.innerHTML = `
        <td>${rowCount}</td>
        <td>${nim}</td>
        <td>${nama}</td>
        <td>${prodi}</td>
        <td>${fakultas}</td>
        <td>
            <button onclick="editProfile(this)">Edit</button>
            <button onclick="deleteProfile(this)">Delete</button>
            <button onclick="printProfile()">Print</button>
        </td>
    `;

    tableBody.appendChild(newRow);

    // Close modal and reset form
    closeModal();
    document.querySelector("#modal form").reset();
}
// Function untuk menampilkan modal
function showModal() {
    var modal = document.getElementById('modal');
    modal.style.display = 'flex';  // Menampilkan modal
}

// Function untuk menutup modal
function closeModal() {
    var modal = document.getElementById('modal');
    modal.style.display = 'none';  // Menutup modal
}
