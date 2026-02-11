<php?
namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = auth()->id(); // Mengambil ID peminjam yang sedang login
        
        // Definisikan semua variabel yang dibutuhkan di View
        $total_alat = Alat::where('stok', '>', 0)->count(); 
        $pinjam_pending = Peminjaman::where('user_id', $user_id)->where('status', 'menunggu')->count();
        $pinjam_aktif = Peminjaman::where('user_id', $user_id)->where('status', 'disetujui')->count();
        $recent_orders = Peminjaman::with('detailPeminjaman.alat')
                            ->where('user_id', $user_id)
                            ->latest()
                            ->take(5)
                            ->get();

        // Kirim variabel ke view menggunakan compact atau array
        return view('peminjam.dashboard', compact(
            'total_alat', 
            'pinjam_pending', 
            'pinjam_aktif', 
            'recent_orders'
        ));
    }
}