<?php namespace qilara\Http\Controllers;


use qilara\Http\Controllers\Controller;
use qilara\Models\User;
use qilara\Models\Memo;
use qilara\Models\MemoItem;
use Auth;
use Request;
use DB;

class MemoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = Memo::with('memo_item')->orderBy('id', 'desc')->get();

		return view('memo.index', [
				"title" => trans('common.procurement'),
				"data" => $data
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('memo.create', [
            "title" => trans('common.create_memo'),
            'date' => null
        ]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/*echo "Masuk Ke Sini";
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";*/
		$memo = new Memo();
		$memo->memo_no = $this->generate_memo_no();
		$memo->user_id = Auth::user()->id;
		$memo->memo_date = date("Y-m-d");
		/*$memo->regarding = Request::input('regarding');*/
		$memo->save();

		//$memo_item = new MemoItem();

		$cur_memo = Memo::find($memo->id);

		if (!empty($_POST['items'])) {
			$items = json_decode(Request::input('items'));
			echo "<pre>";
			print_r($items);
			echo "</pre>";
			foreach ($items as $keys => $val) {
				$memo_item = new MemoItem();
				$memo_item->item_name = $val->item_name;
				$memo_item->amount = str_replace(",", "", $val->amount);
				$memo_item->unit = $val->unit;
				$memo_item->unit_price = str_replace(",", "", $val->unit_price);
				$cur_memo->memo_item()->save($memo_item);
			}
		}

		$this->printMemo($memo->id);

		return Redirect::route('dashboard.procurement.index')
				->with('message', trans('common.memo_saved'));

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function printMemo($id)
	{
		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$phpWord->addParagraphStyle('styleRight', array('align' => 'right', 'valign' => 'center'));
		$phpWord->addParagraphStyle('styleCenter', array('align' => 'center', 'valign' => 'center'));
		$phpWord->addParagraphStyle('stylePaddingTop', array('spaceBefore' => 480, 'spaceAfter' => 0));
		$phpWord->addFontStyle('bold', array('bold' => true));
		$phpWord->addFontStyle('underline', array('underline' => 'single'));
		$phpWord->addParagraphStyle('styleContent', array('spaceBefore' => 0, 'spaceAfter' => 240));
		$phpWord->addParagraphStyle('styleFirstLine', array('spaceBefore' => 480, 'spaceAfter' => 240));
		$phpWord->addParagraphStyle('styleContent2', array('spaceBefore' => 240, 'spaceAfter' => 240));
		//$phpWord->addTitleStyle(1, array('bold' => true), array('spaceAfter' => 240));
		$phpWord->addFontStyle('footer_small', array('size' => 9));
		$phpWord->addParagraphStyle('singlePar', array('spaceAfter' => 0, 'spaceBefore' => 0, 'lineHeight' => 1, 'align' => 'center'));

		$titleStyle = array('bold' => true, 'align' => 'center', 'size' => 14);

		$data = Memo::with('memo_item')->findOrFail($id);
		$user = User::find($data->user_id)->first();

		$phpWord->setDefaultParagraphStyle(
				array('spaceAfter' => 0,
						'spaceBefore' => 0,
						'lineHeight' => 1.5)
		);

		$section = $phpWord->addSection();
		$sectionStyle = $section->getStyle();
		$sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5));

		//Tabs
		$phpWord->addParagraphStyle(
				'headerTabs',
				array(
						'tabs' => array(
								new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(5.5)),
								new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(6.5))
						)
				)
		);

		$section->addText('Memo Permintaan Barang', $titleStyle, 'styleCenter');
		$section->addText('');

		$section->addText(htmlspecialchars("Nomor\t:\t".$data->memo_no), null, 'headerTabs');
		$section->addText(htmlspecialchars("Tanggal\t:\t".localeDate($data->memo_date, false)), null, 'headerTabs');
		$section->addText(htmlspecialchars("Kepada\t:\t"), null, 'headerTabs');
		$section->addText(htmlspecialchars("Dari\t:\t".$user->name), null, 'headerTabs');
		$section->addText(htmlspecialchars("Perihal\t:\t"), null, 'headerTabs');
		$section->addText(htmlspecialchars("Kegiatan/ Program/ Bidang\t:\t"), null, 'headerTabs');

		$styleTable = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 80);
		$styleFirstRow = array('borderBottomSize' => 18, 'borderBottomColor' => '000000', 'bgColor' => 'E5E5E5');
		$styleCell = array('valign' => 'center');
		$fontStyle = array('bold' => true, 'align' => 'center');
		$cellColSpan = array('gridSpan' => 4, 'valign' => 'center', 'align' => 'center');

		$phpWord->addTableStyle('Fancy Table', $styleTable, $styleFirstRow);
		$table = $section->addTable('Fancy Table');
		$table->addRow();
		$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.3), $styleCell)->addText(htmlspecialchars('No'), $fontStyle, 'styleCenter');
		$table->addCell(3800, $styleCell)->addText(htmlspecialchars('Nama Barang'), $fontStyle, 'styleCenter');
		$table->addCell(1200, $styleCell)->addText(htmlspecialchars('Katalog'), $fontStyle, 'styleCenter');
		$table->addCell(1500, $styleCell)->addText(htmlspecialchars('Jumlah'), $fontStyle, 'styleCenter');
		$table->addCell(1500, $styleCell)->addText(htmlspecialchars('Satuan'), $fontStyle, 'styleCenter');
		$table->addCell(1500, $styleCell)->addText(htmlspecialchars('Keterangan'), $fontStyle, 'styleCenter');

		$i = 1;

		foreach($data->memo_item as $row) {
			$table->addRow();
			$table->addCell()->addText($i, null, 'styleCenter');
			$table->addCell()->addText($row->item_name, null, 'styleCell');
			$table->addCell()->addText($row->item_name, null, 'styleCell');
			$table->addCell()->addText(number_format($row->amount), null, 'styleRight');
			$table->addCell()->addText($row->unit, null, 'styleCell');
			$table->addCell()->addText($row->unit, null, 'styleCell');

			$i++;
		}

		//Tabs TTD 1
		$phpWord->addParagraphStyle(
				'ttd1Tabs',
				array(
						'tabs' => array(
								new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1)),
								new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(10))
						)
				)
		);

		$section->addText('');
		$section->addText(htmlspecialchars("\t\tSerpong, ".localeDate($data->memo_date, false)), null, 'ttd1Tabs');
		$section->addText(htmlspecialchars("\tPeneliti,\tKoordinator Keltian,"), null, 'ttd1Tabs');
		$section->addText('');
		$section->addText('');
		$section->addText('');
		$section->addText(htmlspecialchars("\t".Auth::user()->name."\t"), null, 'ttd1Tabs');
		$section->addText(htmlspecialchars("\tNIP. ".Auth::user()->nim."\t"), null, 'ttd1Tabs');

		$section->addText('');

		$phpWord->addParagraphStyle(
				'ttd2Tabs',
				array(
						'tabs' => array(
								new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(5.5))
						)
				)
		);

		$section->addText(htmlspecialchars("\tPejabat Pembuat Komitmen,"), null, 'ttd2Tabs');
		$section->addText('');
		$section->addText('');
		$section->addText('');


		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$filename = "Memo ".str_replace("/","--",$data->memo_no).".docx";
        ob_clean();

        $objWriter->save($filename);

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filename));
		flush();
		readfile($filename);
		unlink($filename);
	}

	public function generate_memo_no()
	{
		$memo_month = date('n');
		$memo_month = numberToRoman($memo_month);

		$memo_year = date('Y');

		$memo_code = "/Mandiri/".$memo_month."/".$memo_year;

		$memo_no = DB::table('memos')
					->select(DB::raw('MAX(CAST(SUBSTRING(memo_no, 1, 3) AS UNSIGNED)) as max_memo_no'))
					->whereRaw('memo_no LIKE "___'.$memo_code.'"')->first();

		if (empty($memo_no->max_memo_no)) {
			return "001".$memo_code;
		} else {
			return sprintf("%03d", ($memo_no->max_memo_no + 1)).$memo_code;
		}
	}
}
