<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Tarik Tambang - Tebak Kata</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        .flag {
            position: absolute; width: 40px; height: 60px;
            transition: left 0.5s cubic-bezier(0.25, 0.8, 0.25, 1); z-index: 20;
        }
        .flag-pole { width: 4px; height: 60px; background: #333; position: absolute; left: 50%; transform: translateX(-50%); }
        .flag-cloth { width: 30px; height: 20px; background: #fbbf24; position: absolute; top: 5px; left: 50%; clip-path: polygon(0 0, 100% 50%, 0 100%); animation: wave 1s infinite; }
        @keyframes wave { 0%, 100% { transform: translateX(0) scaleX(1); } 50% { transform: translateX(2px) scaleX(0.95); } }

        .keyboard-key { transition: all 0.15s ease; touch-action: manipulation; }
        .keyboard-key:active { transform: scale(0.95); box-shadow: inset 0 2px 4px rgba(0,0,0,0.2); }
        .input-display { min-height: 48px; border: 3px dashed #cbd5e1; background: white; border-radius: 8px; padding: 8px 16px; font-size: 20px; font-weight: 600; letter-spacing: 2px; display: flex; align-items: center; justify-content: center; }

        /* Animasi Sentakan Tarik Tambang */
        .tarik-kiri { animation: sentakKiri 0.3s ease-out; }
        .tarik-kanan { animation: sentakKanan 0.3s ease-out; }
        @keyframes sentakKiri { 0%, 100% { translate: 0 0; } 50% { translate: -20px 0; } }
        @keyframes sentakKanan { 0%, 100% { translate: 0 0; } 50% { translate: 20px 0; } }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    
   <div class="container mx-auto px-4 py-4 md:py-6 relative">
        <h1 class="text-3xl md:text-4xl font-bold text-center text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
            🎮 Game Tarik Tambang - Tebak Kata
        </h1>
        
        <div class="flex justify-center md:absolute md:right-4 md:top-1/2 md:-translate-y-1/2 gap-3 mt-4 md:mt-0 z-50">
            <button id="btn-head-restart" class="bg-white border-2 border-blue-400 hover:bg-blue-50 text-blue-600 font-bold py-1.5 px-4 rounded-full shadow transition transform hover:scale-105 text-sm md:text-base">
                🔄 
            </button>
            <button id="btn-head-endgame" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1.5 px-4 rounded-full shadow transition transform hover:scale-105 text-sm md:text-base">
                🛑 
            </button>
        </div>
    </div>

    <div class="container mx-auto px-4 mb-4 md:mb-6">
        <div class="bg-white rounded-xl shadow-lg p-4 relative overflow-hidden h-48 md:h-64 flex flex-col justify-center">
            
            <div class="flag absolute top-[55%] md:top-[58%] left-1/2 -translate-x-1/2 -translate-y-1/2 z-20" id="flag">
                <div class="flag-pole"></div><div class="flag-cloth"></div>
            </div>

            <div id="arena-geser" class="absolute inset-0 transition-transform duration-500 ease-in-out z-10 flex justify-center items-center py-2 md:py-4">
                
                <div class="relative h-full flex justify-center">
                    <img id="img-utama" src="/game-assets/image/tarikfix.png" class="h-full w-auto object-contain mix-blend-multiply transition-all duration-300 scale-[1.3]" alt="Tarik Tambang">
                </div>

            </div>

            <div class="absolute bottom-2 left-6 md:left-12 flex flex-col items-center z-30">
                <div class="text-3xl md:text-5xl font-bold text-blue-600 leading-none" id="scoreLeft">0</div>
                <div class="text-xs md:text-sm text-gray-500 font-semibold mt-1">Tim Kiri</div>
            </div>
            <div class="absolute bottom-2 right-6 md:right-12 flex flex-col items-center z-30">
                <div class="text-3xl md:text-5xl font-bold text-red-600 leading-none" id="scoreRight">0</div>
                <div class="text-xs md:text-sm text-gray-500 font-semibold mt-1">Tim Kanan</div>
            </div>

        </div>
    </div>

    </div> <div id="banner-hasil" class="container mx-auto px-4 mb-6 hidden">
        <div class="bg-white rounded-xl shadow-lg p-6 text-center border-4 border-yellow-400 relative overflow-hidden transform transition-all duration-500 scale-95 opacity-0" id="banner-content">
            
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-50"></div>
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-50"></div>

            <h2 id="teks-pemenang" class="text-3xl md:text-4xl font-extrabold mb-4 relative z-10 drop-shadow-sm">
                🎉 TIM ... MENANG! 🎉
            </h2>

            <div class="flex justify-center gap-12 mb-6 relative z-10">
                <div class="text-center">
                    <p class="text-sm md:text-base text-gray-500 font-bold uppercase tracking-wider">Skor Kiri</p>
                    <p id="skor-akhir-kiri" class="text-3xl font-black text-blue-600">0</p>
                </div>
                <div class="text-center">
                    <p class="text-sm md:text-base text-gray-500 font-bold uppercase tracking-wider">Skor Kanan</p>
                    <p id="skor-akhir-kanan" class="text-3xl font-black text-red-600">0</p>
                </div>
            </div>

            <button id="btn-main-lagi" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-8 rounded-full shadow-md transform transition hover:scale-105 active:scale-95 relative z-10 text-lg">
                🔄 Main Lagi
            </button>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-8">

    <div class="container mx-auto px-4 pb-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-2xl p-4 md:p-6" id="leftPlayer">
                <div class="bg-white rounded-lg p-3 md:p-4 mb-4 shadow-md text-center">
                    <div class="text-xs md:text-sm text-gray-500 mb-1 font-semibold uppercase tracking-wider">Soal Kiri:</div>
                    <div class="text-base md:text-xl font-bold text-gray-800" id="questionLeft">Memuat soal...</div>
                </div>
                <div class="input-display mb-4" id="inputLeft"><span class="text-gray-400 text-sm md:text-base font-normal">Ketik jawaban...</span></div>
                <div class="text-center mb-3 h-6"><div class="text-sm font-semibold text-white" id="statusLeft"></div></div>
                
                <div class="space-y-1 md:space-y-2 w-full" id="keyboardLeft">
                    <div class="flex gap-1 md:gap-1.5 justify-center">
                        <button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="1">1</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="2">2</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="3">3</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="4">4</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="5">5</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="6">6</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="7">7</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="8">8</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="9">9</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="0">0</button>
                    </div>
                    <div class="flex gap-1 md:gap-1.5 justify-center">
                        <button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="Q">Q</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="W">W</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="E">E</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="R">R</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="T">T</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="Y">Y</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="U">U</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="I">I</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="O">O</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="P">P</button>
                    </div>
                    <div class="flex gap-1 md:gap-1.5 justify-center px-4">
                        <button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="A">A</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="S">S</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="D">D</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="F">F</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="G">G</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="H">H</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="J">J</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="K">K</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="L">L</button>
                    </div>
                    <div class="flex gap-1 md:gap-1.5 justify-center px-8">
                        <button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="Z">Z</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="X">X</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="C">C</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="V">V</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="B">B</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="N">N</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="M">M</button>
                    </div>
                    <div class="flex gap-2 justify-center mt-2">
                        <button class="keyboard-key bg-red-500 hover:bg-red-600 text-white flex-1 max-w-[100px] py-2 rounded font-bold text-xs shadow-md" data-key="BACKSPACE">⌫ HAPUS</button>
                        <button class="keyboard-key bg-green-500 hover:bg-green-600 text-white flex-1 max-w-[120px] py-2 rounded font-bold text-xs shadow-md" data-key="ENTER">ENTER ↵</button>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-xl shadow-2xl p-4 md:p-6" id="rightPlayer">
                <div class="bg-white rounded-lg p-3 md:p-4 mb-4 shadow-md text-center">
                    <div class="text-xs md:text-sm text-gray-500 mb-1 font-semibold uppercase tracking-wider">Soal Kanan:</div>
                    <div class="text-base md:text-xl font-bold text-gray-800" id="questionRight">Memuat soal...</div>
                </div>
                <div class="input-display mb-4" id="inputRight"><span class="text-gray-400 text-sm md:text-base font-normal">Ketik jawaban...</span></div>
                <div class="text-center mb-3 h-6"><div class="text-sm font-semibold text-white" id="statusRight"></div></div>
                
                <div class="space-y-1 md:space-y-2 w-full" id="keyboardRight">
                    <div class="flex gap-1 md:gap-1.5 justify-center">
                        <button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="1">1</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="2">2</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="3">3</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="4">4</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="5">5</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="6">6</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="7">7</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="8">8</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="9">9</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="0">0</button>
                    </div>
                    <div class="flex gap-1 md:gap-1.5 justify-center">
                        <button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="Q">Q</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="W">W</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="E">E</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="R">R</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="T">T</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="Y">Y</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="U">U</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="I">I</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="O">O</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="P">P</button>
                    </div>
                    <div class="flex gap-1 md:gap-1.5 justify-center px-4">
                        <button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="A">A</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="S">S</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="D">D</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="F">F</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="G">G</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="H">H</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="J">J</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="K">K</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="L">L</button>
                    </div>
                    <div class="flex gap-1 md:gap-1.5 justify-center px-8">
                        <button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="Z">Z</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="X">X</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="C">C</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="V">V</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="B">B</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="N">N</button><button class="keyboard-key flex-1 max-w-[40px] py-2 bg-gray-100 hover:bg-gray-200 rounded font-bold text-gray-700 shadow" data-key="M">M</button>
                    </div>
                    <div class="flex gap-2 justify-center mt-2">
                        <button class="keyboard-key bg-red-500 hover:bg-red-600 text-white flex-1 max-w-[100px] py-2 rounded font-bold text-xs shadow-md" data-key="BACKSPACE">⌫ HAPUS</button>
                        <button class="keyboard-key bg-green-500 hover:bg-green-600 text-white flex-1 max-w-[120px] py-2 rounded font-bold text-xs shadow-md" data-key="ENTER">ENTER ↵</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div id="modal-restart" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm hidden transition-all duration-300 opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 w-[90%] max-w-sm text-center transform transition-all duration-300 scale-95 opacity-0">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">🔄 Restart Game?</h3>
            <p class="text-gray-500 mb-6 text-sm md:text-base">Apakah Anda yakin ingin mengulang permainan dari awal? Skor akan di-reset.</p>
            <div class="flex justify-center gap-3">
                <button id="btn-cancel-restart" class="flex-1 py-2.5 rounded-full font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</button>
                <button id="btn-confirm-restart" class="flex-1 py-2.5 rounded-full font-bold text-white bg-blue-500 hover:bg-blue-600 shadow-md transition transform hover:scale-105">Ya, Restart</button>
            </div>
        </div>
    </div>

    <div id="modal-endgame" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm hidden transition-all duration-300 opacity-0">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 w-[90%] max-w-sm text-center transform transition-all duration-300 scale-95 opacity-0">
            <h3 class="text-2xl font-bold text-gray-800 mb-2">🛑 Akhiri Permainan?</h3>
            <p class="text-gray-500 mb-6 text-sm md:text-base">Akhiri permainan sekarang dan lihat hasil skor akhirnya?</p>
            <div class="flex justify-center gap-3">
                <button id="btn-cancel-endgame" class="flex-1 py-2.5 rounded-full font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition">Batal</button>
                <button id="btn-confirm-endgame" class="flex-1 py-2.5 rounded-full font-bold text-white bg-red-500 hover:bg-red-600 shadow-md transition transform hover:scale-105">Ya, Akhiri</button>
            </div>
        </div>
    </div>

    <div id="banner-hasil" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-md hidden transition-all duration-500 opacity-0">
        <div class="bg-white rounded-xl shadow-2xl p-6 md:p-10 text-center border-4 border-yellow-400 relative overflow-hidden transform transition-all duration-500 scale-95 opacity-0 w-[90%] max-w-lg">
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-50 pointer-events-none"></div>
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-50 pointer-events-none"></div>

            <h2 id="teks-pemenang" class="text-3xl md:text-4xl font-extrabold mb-4 relative z-10 drop-shadow-sm">
                🎉 TIM ... MENANG! 🎉
            </h2>

            <div class="flex justify-center gap-12 mb-8 relative z-10">
                <div class="text-center">
                    <p class="text-sm md:text-base text-gray-500 font-bold uppercase tracking-wider">Skor Kiri</p>
                    <p id="skor-akhir-kiri" class="text-5xl font-black text-blue-600 mt-1">0</p>
                </div>
                <div class="text-center">
                    <p class="text-sm md:text-base text-gray-500 font-bold uppercase tracking-wider">Skor Kanan</p>
                    <p id="skor-akhir-kanan" class="text-5xl font-black text-red-600 mt-1">0</p>
                </div>
            </div>

            <button id="btn-main-lagi" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transform transition hover:scale-105 active:scale-95 relative z-10 text-lg">
                🔄 Main Lagi
            </button>
        </div>
    </div>

    <script>
        const questionsFromServer = @json($questions);
    </script>
    <script src="/game-assets/game.js"></script>
</body>
</html>