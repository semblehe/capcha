<?php
/**
 * Created by JetBrains PhpStorm.
 * User: D'Gijis
 * Date: 11/6/13
 * Time: 10:50 AM
 * To change this template use File | Settings | File Templates.
 */
class AkreditasiController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        if (isset(Yii::app()->session['leveluser']))
        {
            return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'=>array(''),
                    'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions'=>array('DaftarAkreditasi','FormAkreditasi','CetakSk'),

                    'users'=>array('@'),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                    'actions'=>array('admin','delete'),
                    'users'=>array('admin'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );
        }
        else {
            $this->redirect('/site/logout');
        }
    }

	function actionDaftarAkreditasi(){
		$referensi                  =   new Referensi();
		$akreditasi                 =   new Akreditasi();
		$data['DDLFakultas']        =   $referensi->getdaftarfakultas();
		(isset($_GET['KdFak']))? $data['KdFak'] = $_GET['KdFak']  :   $data['KdFak'] = '01';
		$data['dataAkreditasi'] =   $akreditasi->daftarAkreditasiByFakultas($data['KdFak']);

		if(isset($_POST['TglMulai'])){
			$KdFak                  =   substr($_POST['KdProdi'],0,2);
			$akreditasi->hapusAkreditasi($_POST['KdProdi'],$_POST['TglMulai']);
			$this->redirect('DaftarAkreditasi?KdFak='.$KdFak);
		}

		$this->render('daftarAkreditasi',$data);
	}

	function actionFormAkreditasi(){
		$akreditasi                 =   new Akreditasi();
		$referensi                  =   new Referensi();

		if(isset($_GET['KdFak'])){
			$data['KdFak']              =   $_GET['KdFak'];
			$data['DDLProdi']           =   $referensi->getprogramstudifakultas($data['KdFak']);
		}elseif(isset($_POST['yt0'])){
			$akreditasi->insertAkreditasi($_POST['KdProdi'],$_POST['Tanggal'],$_POST['Kualitas'], $_POST['Nilai'], $_POST['NoSurat']);
			$this->redirect('DaftarAkreditasi?KdFak='.$_POST['KdFak']);
		}

		$this->renderPartial('formAkreditasi',$data);
	}
   function actionCetakSk(){
       $model=new Akreditasi();
       $KdProdi=$_GET['KdProdi'];
       $TglMulaiAkreditasi=$_GET['TglMulaiAkreditasi'];
       $dataakreditasi=$model->skAkreditasi($KdProdi,$TglMulaiAkreditasi);
       $namaBulan  =   array("-","Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
       $namaHari  =   array("-","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
       $mpdf = Yii::createComponent('application.extensions.MPDF56.mpdf', 'win-1252', 'A4', '', '', 15, 15, 48, 15, 8, 8);

       $html= Yii::app()->controller->renderPartial('pdf_SKAkreditasi',array(
           'mpdf'=>$mpdf,
           'namaBulan'=> $namaBulan,
           'namaHari'=> $namaHari,
           'dataakreditasi'=>$dataakreditasi),
       true);

       $mpdf->WriteHTML($html);
       $mpdf->Output('cetakSKAkreditasi.pdf', 'I');
   }
}
