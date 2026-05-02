<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloading Ticket...</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#ffcb00',
                        'primary-dark': '#a38400',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .bg-ticket-header {
            background: linear-gradient(to right, #ffcb00, #a38400);
        }
        #download-status {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 100;
            gap: 1rem;
        }
    </style>
</head>
<body>

    <div id="download-status">
        <div class="border-primary h-12 w-12 animate-spin rounded-full border-4 border-t-transparent"></div>
        <p class="font-bold text-slate-700">Generating Ticket Image...</p>
        <p class="text-sm text-slate-400">Mohon tunggu sebentar, gambar sedang diproses.</p>
    </div>

    <!-- Ticket Container (Rendered off-screen or covered by status) -->
    <div id="ticket-container" class="w-[400px] shrink-0 overflow-hidden rounded-2xl bg-white">
        <!-- Header -->
        <div class="bg-ticket-header relative overflow-hidden p-6 text-center">
            <div class="absolute -top-10 -right-10 h-32 w-32 rounded-full bg-white/20 blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-black/10 blur-2xl"></div>

            <div class="relative z-10 flex flex-col items-center gap-2">
                <h2 class="mt-2 text-xl font-black tracking-wider text-slate-900 uppercase">{{ $participant->event->name ?? '-' }}</h2>
                <div class="inline-block rounded-full bg-black/10 px-3 py-1 text-xs font-semibold text-slate-900">TICKET PASS</div>
            </div>
        </div>

        <!-- Body -->
        <div class="flex flex-col gap-6 bg-white p-8">
            <div class="flex items-start justify-between gap-4">
                <div class="flex flex-1 flex-col gap-4">
                    <div>
                        <p class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">Nama Partisipan</p>
                        <p class="text-lg font-bold text-slate-800 uppercase">{{ $participant->massa->full_name ?? '-' }}</p>
                    </div>

                    <div class="flex gap-6">
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">NIK</p>
                            <p class="font-mono text-sm font-semibold text-slate-700">{{ $participant->massa->nik ?? '-' }}</p>
                        </div>
                    </div>

                    @if(($participant->event->start_date ?? false) || ($participant->event->location ?? false))
                    <div class="flex flex-col gap-2 border-t border-slate-100 pt-2">
                        @if($participant->event->start_date ?? false)
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">Tanggal</p>
                            <p class="text-xs font-semibold text-slate-700">{{ \Carbon\Carbon::parse($participant->event->start_date)->translatedFormat('d F Y') }}</p>
                        </div>
                        @endif

                        @if($participant->event->location ?? false)
                        <div>
                            <p class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">Lokasi</p>
                            <p class="text-xs font-semibold text-slate-700">{{ $participant->event->location }}</p>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- QR Code -->
                <div class="flex flex-col items-center gap-2 rounded-xl border border-slate-100 bg-slate-50 p-3">
                    <div class="rounded-lg bg-white p-2">
                        <img id="qr-image" src="{{ asset('storage/qrcodes/' . $participant->qr_code) }}" alt="QR Code" class="h-48 w-48 object-contain" crossorigin="anonymous" />
                    </div>
                    <p class="text-primary-dark font-mono text-xs font-bold tracking-widest">{{ $participant->participant_code }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="border-t border-slate-100 bg-slate-50 p-4 text-center">
            <p class="text-[10px] text-slate-400">Tunjukkan QR Code ini pada saat registrasi ulang di lokasi acara.</p>
        </div>
    </div>

    <script>
        window.onload = async function() {
            // Wait a bit for images and fonts
            await new Promise(r => setTimeout(r, 500));
            
            try {
                const element = document.getElementById('ticket-container');
                const canvas = await html2canvas(element, {
                    scale: 3,
                    useCORS: true,
                    backgroundColor: null
                });

                const dataUrl = canvas.toDataURL('image/png');
                const link = document.createElement('a');
                link.download = 'Ticket_{{ $participant->participant_code }}.png';
                link.href = dataUrl;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                document.getElementById('download-status').innerHTML = `
                    <div class="mb-4 rounded-full bg-green-50 p-4 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <p class="font-bold text-slate-700">Download Berhasil!</p>
                    <p class="px-8 text-center text-sm text-slate-400">Jika download tidak berjalan otomatis, silakan klik tombol di bawah.</p>
                    <button onclick="window.location.reload()" class="bg-primary mt-4 rounded-lg px-4 py-2 font-bold text-slate-900">Coba Lagi</button>
                `;
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('download-status').innerHTML = `
                    <p class="font-bold text-red-500">Gagal mendownload tiket.</p>
                    <p class="mt-2 text-sm text-slate-400">${error.message}</p>
                `;
            }
        };
    </script>
</body>
</html>
