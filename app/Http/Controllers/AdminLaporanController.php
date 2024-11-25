<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Setting;

use App\Models\Reporter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Traits\NetworkAccessTrait;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class AdminLaporanController extends Controller
{
    use NetworkAccessTrait;

    public $setting;
    public $user_network;

    public function __construct()
    {
        $this->setting = Setting::where('id_network', auth()->user()->id_network)->first();
        $this->user_network = auth()->user()->id_network;
    }

    // index
    public function index(){
        $start = \Carbon\Carbon::now()->translatedFormat('Y-m-d');      
        $end = \Carbon\Carbon::tomorrow()->translatedFormat('Y-m-d');
        
        return view('admin.laporan.laporan',[
            'judul' => 'Laporan' . ' - ' . $this->setting->judul_situs,
            'berita' => Berita::beritaPerTanggal($this->user_network, $start, $end)->get(),
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
        
        ]);
    }

    public function show(Request $request){
        $start = $request->input('tanggal_awal');      
        $end = $request->input('tanggal_akhir');

        return view('admin.laporan.laporan_tanggal',[
            'judul' => 'Laporan' . ' - ' . $this->setting->judul_situs,
            'berita' => Berita::beritaPerTanggal($this->user_network, $start, $end)->get(),
            'awal' => $start,
            'akhir' => $end,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
        ]);
    }

    public function laporanWartawan(){
        $tanggal = Carbon::now()->translatedFormat('Y-m-d');

        return view('admin.laporan.jumlah_berita',[
            'judul' => 'Laporan' . ' - ' . $this->setting->judul_situs,
            'jumlahBerita' => Reporter::beritaWartawan($this->user_network, $tanggal),
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
        ]);
    }

    public function laporanWartawanTanggal(Request $request){
        $tanggal = $request->input('tanggal');

        return view('admin.laporan.jumlah_berita_tanggal',[
            'judul' => 'Laporan' . ' - ' . $this->setting->judul_situs,
            'jumlahBerita' => Reporter::beritaWartawan($this->user_network, $tanggal),
            'tanggal' => $tanggal,
            'list_tayang' => $this->list_tayang(),
            'id_setting' => $this->setting->id,
            'setting' => $this->setting,
        ]);
    }

    public function downloadexcel(Request $request){

        $start = $request->input('tanggal_awal');      
        $end = $request->input('tanggal_akhir');
        $awal = \Carbon\Carbon::parse($start)->translatedFormat('d-m-Y');
        $akhir = \Carbon\Carbon::parse($end)->translatedFormat('d-m-Y');

        $berita = Berita::beritaPerTanggal($this->user_network, $start, $end)->get();
            
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator($this->setting->judul_situs)
            ->setLastModifiedBy($this->setting->judul_situs)
            ->setTitle('Laporan Berita' . $this->setting->judul_situs)
            ->setSubject('Laporan Berita' . $this->setting->judul_situs)
            ->setDescription('Laporan Berita' . $this->setting->judul_situs)
            ->setKeywords($this->setting->judul_situs)
            ->setCategory('Laporan');

        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'TANGGAL')
            ->setCellValue('B1', 'JUDUL')
            ->setCellValue('C1', 'KATEGORI')
            ->setCellValue('D1', 'FOKUS')
            ->setCellValue('E1', 'REDAKTUR')
            ->setCellValue('F1', 'WARTAWAN') 
            ->setCellValue('G1', 'URL');        

        foreach($berita as $i=>$b){
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue( 'A'. $i + 2 , \Carbon\Carbon::parse($b->tanggal_tayang . $b->waktu)->translatedFormat('d-m-Y H:i'))
            ->setCellValue( 'B'. $i + 2 , $b->judul)
            ->setCellValue( 'C'. $i + 2 , $b->Kategori->nama)
            ->setCellValue( 'D'. $i + 2 , $b->Fokus ? $b->Fokus->nama : '')
            ->setCellValue( 'E'. $i + 2 , $b->penulis)
            ->setCellValue( 'F'. $i + 2 , $b->wartawan)
            ->setCellValue( 'G'. $i + 2 , $this->setting && $this->setting->Network ? $this->setting->Network->url . '/berita/' . $b->slug : '');
            
        }

        // Set column widths
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(50);

        //Set Bold Title
        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

        //Wrap Column Judul
        $spreadsheet->getActiveSheet()->getStyle('B1:B'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

        // Align Middle
        $spreadsheet->getActiveSheet()->getStyle('A1:A'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('B1:B'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('C1:C'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('D1:D'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('E1:E'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('F1:F'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setVertical('center');
        $spreadsheet->getActiveSheet()->getStyle('G1:G'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setVertical('center');

        // Indent
        $spreadsheet->getActiveSheet()->getStyle('A1:A'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setIndent(1);
        $spreadsheet->getActiveSheet()->getStyle('B1:B'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setIndent(1);
        $spreadsheet->getActiveSheet()->getStyle('C1:C'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setIndent(1);
        $spreadsheet->getActiveSheet()->getStyle('D1:D'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setIndent(1);
        $spreadsheet->getActiveSheet()->getStyle('E1:E'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setIndent(1);
        $spreadsheet->getActiveSheet()->getStyle('F1:F'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setIndent(1);
        $spreadsheet->getActiveSheet()->getStyle('G1:G'.$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setIndent(1);

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Laporan ' . $this->setting->judul_situs);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan ' .  $this->setting->judul_situs . ' - ' . $awal .' sampai '. $akhir .'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;

    }
}
