// ==========================================
// 1. GAME STATE & DATABASE SOAL
// ==========================================
const gameState = {
    leftPlayer: {
        currentInput: "",
        currentQuestion: null,
        score: 0,
        questionIndex: 0,
    },
    rightPlayer: {
        currentInput: "",
        currentQuestion: null,
        score: 0,
        questionIndex: 0,
    },
    ropePosition: 50, // 0 = Kiri menang, 100 = Kanan menang
    gameOver: false,
    pullAmount: 25, // Jumlah tarikan per jawaban benar
};

const questionsBank = [
    { question: "Ibu kota Indonesia?", answer: "JAKARTA" },
    { question: "2 + 2 = ?", answer: "4" },
    { question: "Warna langit?", answer: "BIRU" },
    { question: "Planet terdekat dengan matahari?", answer: "MERKURIUS" },
    {
        question: "Hewan berkaki empat yang suka menggonggong?",
        answer: "ANJING",
    },
    { question: "5 x 5 = ?", answer: "25" },
    { question: "Ibu kota Jepang?", answer: "TOKYO" },
    { question: "Buah berwarna kuning melengkung?", answer: "PISANG" },
    { question: "Hari setelah Senin?", answer: "SELASA" },
    { question: "10 - 3 = ?", answer: "7" },
    { question: "Hewan raja hutan?", answer: "SINGA" },
    { question: "Warna daun?", answer: "HIJAU" },
    { question: "Bahasa yang digunakan di Perancis?", answer: "PERANCIS" },
    { question: "Jumlah hari dalam seminggu?", answer: "7" },
    { question: "Organ tubuh untuk melihat?", answer: "MATA" },
    { question: "3 x 4 = ?", answer: "12" },
    { question: "Benua terbesar di dunia?", answer: "ASIA" },
    { question: "Hewan yang hidup di air dan punya sirip?", answer: "IKAN" },
    { question: "Warna darah?", answer: "MERAH" },
    { question: "100 / 10 = ?", answer: "10" },
];

let leftQuestions = [];
let rightQuestions = [];

function shuffleArray(array) {
    const newArray = [...array];
    for (let i = newArray.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
    }
    return newArray;
}

// ==========================================
// 2. DOM ELEMENTS CACHE
// ==========================================
const elements = {
    left: {
        input: document.getElementById("inputLeft"),
        question: document.getElementById("questionLeft"),
        status: document.getElementById("statusLeft"),
        score: document.getElementById("scoreLeft"),
        keyboard: document.getElementById("keyboardLeft"),
        playerArea: document.getElementById("leftPlayer"),
    },
    right: {
        input: document.getElementById("inputRight"),
        question: document.getElementById("questionRight"),
        status: document.getElementById("statusRight"),
        score: document.getElementById("scoreRight"),
        keyboard: document.getElementById("keyboardRight"),
        playerArea: document.getElementById("rightPlayer"),
    },
    flag: document.getElementById("flag"),
};

// ==========================================
// 3. LOGIKA VISUAL & ANIMASI KARAKTER
// ==========================================
function updateCharacterState(state) {
    const imgUtama = document.getElementById("img-utama");
    const flag = document.getElementById("flag");

    // Hapus efek sentakan dari state sebelumnya
    imgUtama.classList.remove("tarik-kiri", "tarik-kanan");

    switch (state) {
        case "idle":
            imgUtama.src = "/game/image/tarikfix.png";
            imgUtama.classList.remove("scale-x-[-1.3]");
            flag.style.display = "block";
            break;

        case "kiri_menarik":
            imgUtama.src = "/game/image/stat2.png";
            imgUtama.classList.remove("scale-x-[-1.3]");
            imgUtama.classList.add("tarik-kiri");

            setTimeout(() => {
                if (!gameState.gameOver) updateCharacterState("idle");
            }, 800);
            break;

        case "kanan_menarik":
            imgUtama.src = "/game/image/stat2.png";
            imgUtama.classList.remove("scale-x-[-1.3]");
            imgUtama.classList.add("tarik-kanan");

            setTimeout(() => {
                if (!gameState.gameOver) updateCharacterState("idle");
            }, 800);
            break;

        case "kiri_menang":
            flag.style.display = "none";
            imgUtama.src = "/game/image/winfix.png";
            imgUtama.classList.remove("scale-x-[-1.3]");
            break;

        case "kanan_menang":
            flag.style.display = "none";
            imgUtama.src = "/game/image/winfix.png";
            imgUtama.classList.remove("scale-x-[-1.3]");
            break;
    }
}

function updateRopePosition() {
    const arenaGeser = document.getElementById("arena-geser");

    if (arenaGeser) {
        // Kita kurangi faktor pengalinya dari 0.5 menjadi 0.2
        // Agar pergeseran gambar tidak terlalu jauh sampai menabrak bendera di tengah.
        const batasGeser = 0.3;

        const geser = (gameState.ropePosition - 50) * batasGeser;

        // Geser seluruh arena gambar ke kiri atau ke kanan
        arenaGeser.style.transform = `translateX(${geser}%)`;
    }
}

function updateInputDisplay(player) {
    const playerState = gameState[player + "Player"];
    const inputElement = elements[player].input;

    if (playerState.currentInput === "") {
        inputElement.innerHTML =
            '<span class="text-gray-400">Ketik jawaban...</span>';
    } else {
        inputElement.textContent = playerState.currentInput;
    }
}

// ==========================================
// 4. CORE GAME LOGIC
// ==========================================
function loadQuestion(player) {
    const playerState = gameState[player + "Player"];
    const questions = player === "left" ? leftQuestions : rightQuestions;

    if (playerState.questionIndex >= questions.length) {
        if (player === "left") leftQuestions = shuffleArray(questionsBank);
        else rightQuestions = shuffleArray(questionsBank);
        playerState.questionIndex = 0;
    }

    playerState.currentQuestion = questions[playerState.questionIndex];
    elements[player].question.textContent =
        playerState.currentQuestion.question;
    playerState.currentInput = "";
    updateInputDisplay(player);
    elements[player].status.textContent = "";
}

function checkAnswer(player) {
    if (gameState.gameOver) return;

    const playerState = gameState[player + "Player"];
    const correctAnswer = playerState.currentQuestion.answer.toUpperCase();
    const userAnswer = playerState.currentInput.toUpperCase().trim();

    if (userAnswer === "") return;

    if (userAnswer === correctAnswer) handleCorrectAnswer(player);
    else handleWrongAnswer(player);
}

function handleCorrectAnswer(player) {
    const playerState = gameState[player + "Player"];

    playerState.score++;
    elements[player].score.textContent = playerState.score;
    elements[player].status.innerHTML =
        '<span class="text-green-300">✓ BENAR! TARIK!</span>';

    if (player === "left") {
        gameState.ropePosition = Math.max(
            0,
            gameState.ropePosition - gameState.pullAmount,
        );
        updateCharacterState("kiri_menarik");
    } else {
        gameState.ropePosition = Math.min(
            100,
            gameState.ropePosition + gameState.pullAmount,
        );
        updateCharacterState("kanan_menarik");
    }

    updateRopePosition();

    if (gameState.ropePosition <= 0) {
        endGame("left");
        return;
    } else if (gameState.ropePosition >= 100) {
        endGame("right");
        return;
    }

    playerState.questionIndex++;
    setTimeout(() => loadQuestion(player), 1000);
}

function handleWrongAnswer(player) {
    const playerState = gameState[player + "Player"];
    elements[player].status.innerHTML =
        '<span class="text-yellow-300">✗ Salah! Coba lagi</span>';

    playerState.currentInput = "";
    updateInputDisplay(player);

    setTimeout(() => {
        elements[player].status.textContent = "";
    }, 2000);
}

function handleKeyPress(player, key) {
    if (gameState.gameOver) return;
    const playerState = gameState[player + "Player"];

    if (key === "BACKSPACE") {
        playerState.currentInput = playerState.currentInput.slice(0, -1);
        updateInputDisplay(player);
    } else if (key === "ENTER") {
        checkAnswer(player);
    } else if (key.length === 1) {
        playerState.currentInput += key;
        updateInputDisplay(player);
    }
}

// ==========================================
// 5. GAME CYCLE (END & RESET)
// ==========================================
function endGame(winner) {
    gameState.gameOver = true;

    if (winner === "left") updateCharacterState("kiri_menang");
    else updateCharacterState("kanan_menang");

    // Panggil banner hasil setelah jeda 800ms (menunggu animasi jatuh/lompat selesai)
    setTimeout(() => {
        tampilkanBannerHasil();
    }, 800);
}

function resetGame() {
    gameState.leftPlayer = {
        currentInput: "",
        currentQuestion: null,
        score: 0,
        questionIndex: 0,
    };
    gameState.rightPlayer = {
        currentInput: "",
        currentQuestion: null,
        score: 0,
        questionIndex: 0,
    };
    gameState.ropePosition = 50;
    gameState.gameOver = false;

    leftQuestions = shuffleArray(questionsBank);
    rightQuestions = shuffleArray(questionsBank);

    elements.left.score.textContent = "0";
    elements.right.score.textContent = "0";
    elements.left.status.textContent = "";
    elements.right.status.textContent = "";

    // Perbaikan crash terjadi di 2 fungsi bawah ini:
    updateRopePosition();
    updateCharacterState("idle");

    loadQuestion("left");
    loadQuestion("right");

    document.getElementById("banner-hasil").classList.add("hidden");
}

// ==========================================
// 6. EVENT LISTENERS
// ==========================================
function setupKeyboardListeners() {
    elements.left.keyboard.addEventListener("click", (e) => {
        if (e.target.classList.contains("keyboard-key")) {
            handleKeyPress("left", e.target.dataset.key);
            e.target.classList.add("correct");
            setTimeout(() => e.target.classList.remove("correct"), 200);
        }
    });

    elements.right.keyboard.addEventListener("click", (e) => {
        if (e.target.classList.contains("keyboard-key")) {
            handleKeyPress("right", e.target.dataset.key);
            e.target.classList.add("correct");
            setTimeout(() => e.target.classList.remove("correct"), 200);
        }
    });
}

function setupPhysicalKeyboard() {
    let lastPlayer = "left";

    document.addEventListener("keydown", (e) => {
        if (gameState.gameOver || e.ctrlKey || e.metaKey) return;
        const key = e.key.toUpperCase();

        if (key === "BACKSPACE" || key === "DELETE") {
            e.preventDefault();
            handleKeyPress(lastPlayer, "BACKSPACE");
        } else if (key === "ENTER") {
            e.preventDefault();
            handleKeyPress(lastPlayer, "ENTER");
            lastPlayer = lastPlayer === "left" ? "right" : "left";
        } else if (/^[A-Z0-9]$/.test(key)) {
            e.preventDefault();
            handleKeyPress(lastPlayer, key);
        }

        if (e.key === "Tab") {
            e.preventDefault();
            lastPlayer = lastPlayer === "left" ? "right" : "left";
            const indicator = document.createElement("div");
            indicator.textContent = `🎯 Aktif: Pemain ${lastPlayer === "left" ? "Kiri" : "Kanan"}`;
            indicator.className =
                "fixed top-5 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded shadow-lg z-50 font-bold";
            document.body.appendChild(indicator);
            setTimeout(() => indicator.remove(), 1000);
        }
    });
}

// ==========================================
// 7. INISIALISASI
// ==========================================
window.addEventListener("DOMContentLoaded", () => {
    setupKeyboardListeners();
    setupPhysicalKeyboard();
    resetGame();
});

// ==========================================
// FUNGSI ANIMASI OVERLAY / MODAL
// ==========================================
function toggleOverlay(id, show) {
    const modal = document.getElementById(id);
    const content = modal.firstElementChild; // Mengambil kotak konten di dalamnya

    if (show) {
        modal.classList.remove("hidden");
        // Jeda kecil agar transisi CSS berjalan
        setTimeout(() => {
            modal.classList.remove("opacity-0");
            modal.classList.add("opacity-100");
            content.classList.remove("scale-95", "opacity-0");
            content.classList.add("scale-100", "opacity-100");
        }, 10);
    } else {
        modal.classList.remove("opacity-100");
        modal.classList.add("opacity-0");
        content.classList.remove("scale-100", "opacity-100");
        content.classList.add("scale-95", "opacity-0");
        // Sembunyikan sepenuhnya setelah animasi selesai
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 300);
    }
}

// ==========================================
// KONTROL TOMBOL HEADER (RESTART & ENDGAME)
// ==========================================

// Buka Modal Restart
document.getElementById("btn-head-restart").addEventListener("click", () => {
    toggleOverlay("modal-restart", true);
});

// Aksi Modal Restart
document
    .getElementById("btn-cancel-restart")
    .addEventListener("click", () => toggleOverlay("modal-restart", false));
document.getElementById("btn-confirm-restart").addEventListener("click", () => {
    toggleOverlay("modal-restart", false);
    setTimeout(() => resetGame(), 300); // Tunggu modal tertutup baru reset
});

// Buka Modal Endgame
document.getElementById("btn-head-endgame").addEventListener("click", () => {
    if (!gameState.gameOver) toggleOverlay("modal-endgame", true);
});

// Aksi Modal Endgame
document
    .getElementById("btn-cancel-endgame")
    .addEventListener("click", () => toggleOverlay("modal-endgame", false));
document.getElementById("btn-confirm-endgame").addEventListener("click", () => {
    toggleOverlay("modal-endgame", false);
    gameState.gameOver = true;

    const skorKiri = gameState.leftPlayer.score;
    const skorKanan = gameState.rightPlayer.score;

    // Cek siapa yang menang saat tombol ditekan
    if (skorKiri > skorKanan) updateCharacterState("kiri_menang");
    else if (skorKanan > skorKiri) updateCharacterState("kanan_menang");
    else updateCharacterState("idle");

    // Munculkan banner hasil setelah modal endgame tertutup
    setTimeout(() => tampilkanBannerHasil(), 500);
});

// ==========================================
// FUNGSI BANNER HASIL AKHIR (OVERLAY)
// ==========================================
function tampilkanBannerHasil() {
    const teksPemenang = document.getElementById("teks-pemenang");
    const skorKiri = gameState.leftPlayer.score;
    const skorKanan = gameState.rightPlayer.score;

    document.getElementById("skor-akhir-kiri").textContent = skorKiri;
    document.getElementById("skor-akhir-kanan").textContent = skorKanan;

    if (skorKiri > skorKanan) {
        teksPemenang.textContent = "🏆 TIM KIRI MENANG! 🏆";
        teksPemenang.className =
            "text-3xl md:text-4xl font-extrabold mb-4 relative z-10 drop-shadow-sm text-blue-600";
    } else if (skorKanan > skorKiri) {
        teksPemenang.textContent = "🏆 TIM KANAN MENANG! 🏆";
        teksPemenang.className =
            "text-3xl md:text-4xl font-extrabold mb-4 relative z-10 drop-shadow-sm text-red-600";
    } else {
        teksPemenang.textContent = "🤝 PERMAINAN SERI! 🤝";
        teksPemenang.className =
            "text-3xl md:text-4xl font-extrabold mb-4 relative z-10 drop-shadow-sm text-gray-700";
    }

    // Panggil fungsi overlay untuk memunculkan
    toggleOverlay("banner-hasil", true);
}

// Tombol Main Lagi ditekan
document.getElementById("btn-main-lagi").addEventListener("click", () => {
    toggleOverlay("banner-hasil", false);
    setTimeout(() => resetGame(), 300);
});
