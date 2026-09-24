<?php
namespace App\Http\Controllers;

use App\Models\ChatbotFAQ;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate(['pesan' => 'required|string|max:500']);
        $pesan = strtolower($request->input('pesan'));

        $best = null; $bestScore = 0;
        foreach (ChatbotFAQ::all() as $faq) {
            $score = 0;
            foreach (explode(',', strtolower($faq->keywords)) as $kw) {
                $kw = trim($kw);
                if ($kw !== '' && str_contains($pesan, $kw)) $score++;
            }
            if ($score > $bestScore) { $bestScore = $score; $best = $faq; }
        }

        if ($best) {
            return response()->json(['jawaban' => $best->jawaban, 'topik' => $best->topik]);
        }

        return response()->json([
            'jawaban' => 'Maaf, saya belum memahami pertanyaan Anda. Anda dapat bertanya seputar layanan Pusdatin BNPT, seperti layanan pengaduan TI (hardware, software, jaringan, email, hak akses), SOP, atau kontak helpdesk kami di (021) 384-5555 ext. 200 pada jam kerja.',
            'topik' => 'Umum',
        ]);
    }
}
