<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
<link href="/style/main.css" rel="stylesheet" />


<style>
    /* General Reset */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #e6f7ff;
    color: #003366;
    box-sizing: border-box;
}

/* Navbar */
.navbar {
    background-color: #3c8fe3;
    display: flex;
    align-items: center;
    padding: 10px 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 10;
    height: 60px;
}

.logo img {
    height: 60px;
    max-width: 300px;
    object-fit: contain;
}

/* Box Container */
.container {
    width: 90%;
    max-width: 1200px;
    margin: 20px auto;
    text-align: center;
}

.box {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.box1 {
    height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-bottom: 40px;
}

.box1 h1 {
    font-size: 28px;
    color: #004d99;
    margin: 10px 0;
}

.box1 p {
    color: #333333;
    font-size: 16px;
}

/* Box 2 and 3 */
.login-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.box2, .box3 {
    flex: 1 1 calc(50% - 20px);
    max-width: 500px;
    padding: 30px;
    text-align: left;
}

.icon {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 15px;
}

.icon img {
    width: 50px;
    height: 50px;
}

h3 {
    color: #004d99;
    margin-bottom: 10px;
}

p {
    margin-bottom: 20px;
    line-height: 1.6;
    color: #333333;
}

.button-container {
    display: flex; /* Mengatur tata letak flexbox */
    justify-content: space-between; /* Menjaga jarak antar tombol */
    align-items: center; /* Pusatkan vertikal */
    width: 100%; /* Pastikan container mengambil seluruh lebar */
    margin-top: 10px; /* Jarak atas jika dibutuhkan */
}


/* Button */
.button {
    display: inline-block;
    background-color: #004d99;
    color: white;
    font-size: 14px;
    font-weight: bold;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center;
}

.button:hover {
    background-color: #003366;
}

/* Button Sign Up */
.btn-signup {
    display: inline-block;
    color: #004d99; /* Warna teks sama dengan tema */
    font-size: 14px;
    font-weight: bold;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none; /* Hilangkan garis bawah pada link */
    transition: all 0.3s ease;
    background-color: transparent; /* Tidak ada background */
}

.btn-signup:hover {
    background-color: #f0f0f0; /* Warna background saat hover */
    color: #003366; /* Warna teks saat hover */
    border-color: #003366; /* Ubah warna border saat hover */
}



/* Responsive Design */
@media (max-width: 768px) {
    .login-container {
        flex-direction: column;
    }

    .box2, .box3 {
        flex: 1 1 100%;
    }

    .box1 {
        height: auto;
    }
}
</style>