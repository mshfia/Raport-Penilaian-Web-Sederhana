// Fungsi untuk memuat konten halaman dari file eksternal menggunakan PHP
function loadContent(page) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', page + '.php', true); // Panggil file PHP secara dinamis
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Ganti konten di dalam <main> dengan konten dari file yang dimuat
            document.getElementById('main-content').innerHTML = xhr.responseText;
        } else {
            console.error('Error loading the content: ' + xhr.status);
        }
    };
    xhr.send();
}

// Muat Dashboard secara default saat halaman pertama kali dimuat
loadContent('dashboard'); // Muat file dashboard.php

const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

// Setiap kali link di sidebar diklik, muat konten yang sesuai
allSideMenu.forEach(item => {
    const li = item.parentElement;

    item.addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah pengalihan halaman secara default

        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active'); // Hapus kelas active dari semua item
        })
        li.classList.add('active'); // Tambahkan kelas active ke item yang diklik

        // Ambil nilai href dari link yang diklik dan hapus .php
        const page = item.getAttribute('href').replace('.php', '');

        // Panggil fungsi loadContent untuk memuat halaman baru
        loadContent(page);
    });
});

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');
});

// Fungsi untuk menangani form pencarian (search)
const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
    if (window.innerWidth < 576) {
        e.preventDefault();
        searchForm.classList.toggle('show');
        if (searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
});

// Respon berdasarkan ukuran layar
if (window.innerWidth < 768) {
    sidebar.classList.add('hide');
} else if (window.innerWidth > 576) {
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
}

window.addEventListener('resize', function () {
    if (this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
});

// Switch mode untuk mengubah ke dark mode
const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
    if (this.checked) {
        document.body.classList.add('dark');
    } else {
        document.body.classList.remove('dark');
    }
});
