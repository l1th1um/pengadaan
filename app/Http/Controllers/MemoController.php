<?php namespace qilara\Http\Controllers;


use Illuminate\Support\Facades\Session;
use qilara\Http\Controllers\Controller;
use qilara\Models\User;
use qilara\Models\Memo;
use qilara\Models\MemoItem;
use Auth;
use Request;
use DB;
use Redirect;
use yajra\Datatables\Datatables;
use Response;


class MemoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        /*$data = Memo::with('memo_item')->where('user_id','=',Auth::user()->id)->orderBy('id', 'desc')->get();

		return view('memo.index', [
				"title" => trans('common.procurement'),
				"data" => $data
		]);*/
        if (Auth::user()->hasRole('gudang'))
        {
            //$data = Memo::with('users')->with('memo_item')->orderBy('id', 'desc')->get();
            $data = DB::table('memo_items')
                ->select('memo_items.id','memo_id', 'memo_no', 'memo_date', 'item_name', 'catalog',
						'amount', 'unit', 'notes','status','procurement_status','name')
                ->join('memos', 'memos.id', '=', 'memo_items.memo_id')
				->join('users', 'users.id', '=', 'memos.user_id')
                ->orderBy("memo_id","desc")
                ->get();

            $page = 'memo.index_gudang';
        }
        else
        {
            $data = DB::table('memo_items')
                ->select('memo_items.id','memo_id', 'memo_no', 'memo_date', 'item_name', 'catalog', 'amount',
						'unit', 'notes','status','procurement_status')
                ->join('memos', 'memos.id', '=', 'memo_items.memo_id')
                ->where('memos.user_id', '=', Auth::user()->id)
                ->orderBy("memo_id","desc")
                ->get();

            $page = 'memo.index';
        }

        return view($page, [
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
            'date' => null,
			'coordinator' => $this->listAdditionalRole(2),
			'commitment_official' => $this->listAdditionalRole(1)
        ]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        if (strlen(Request::input('items')) < 3) {
            return Redirect::back()->withErrors(trans('common.request_item_empty'));
        }
        else
        {
            $memo = new Memo();
            $memo->memo_no = $this->generate_memo_no();
            $memo->user_id = Auth::user()->id;
            $memo->memo_date = date("Y-m-d");
			$memo->coordinator = Request::input('coordinator');
			$memo->commitment_official= Request::input('commitment_official');
            $memo->save();

            $cur_memo = Memo::find($memo->id);

            if (!empty($_POST['items'])) {
                $items = json_decode(Request::input('items'));

                foreach ($items as $keys => $val) {
                    $memo_item = new MemoItem();
                    $memo_item->item_name = $val->item_name;
                    $memo_item->catalog = $val->catalog;
                    $memo_item->amount = str_replace(",", "", $val->amount);
                    $memo_item->unit = $val->unit;
                    $memo_item->notes = $val->notes;
                    $cur_memo->memo_item()->save($memo_item);
                }
            }

            Session::flash('memo_id', $memo->id);

            return Redirect::route('dashboard.memo.index')
                ->with('message', trans('common.memo_saved'));
        }
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
        $memo = Memo::findOrFail($id);

        $items = $this->jsArray($memo->memo_item);

        return view('memo.create', [
            "title" => trans('common.add_procurement'),
            "memo" => $memo,
            "items" => $items,
            'date' => convertToDatepicker($memo->memo_date),
			'coordinator' => $this->listAdditionalRole(2),
			'commitment_official' => $this->listAdditionalRole(1)
        ]);
	}

    public function jsArray($data)
    {
        $str = '[';
        foreach ($data as $val) {
            $str .= '["' . $val->id . '","' . $val->item_name . '", "' . number_format($val->amount) . '", "' . $val->unit . '","' . $val->unit_price . '"],';
        }

        $str = substr($str, 0, -1) . "];";

        return $str;
    }

    public function datatables($id)
    {
        if ($id != 0)
		{
			$items = MemoItem::select('id','memo_id','item_name','amount','unit','catalog')->where('memo_id','=',$id)->get();

			foreach ($items as $key => &$val)
			{
				$val->item_name = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="item_name" data-url="'.route('memo.datatables.edit', $id).'">'.$val->item_name.'</a>';
				$val->catalog = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="unit_price" data-url="'.route('memo.datatables.edit', $id).'">'.$val->catalog.'</a>';
				$val->amount = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="amount" data-url="'.route('memo.datatables.edit', $id).'">'.$val->amount.'</a>';
				$val->unit = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="unit" data-url="'.route('memo.datatables.edit', $id).'">'.$val->unit.'</a>';
				$val->notes = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="notes" data-url="'.route('memo.datatables.edit', $id).'">'.$val->notes.'</a>';
			}

			return Datatables::of($items)->make(true);
		}
		else
		{
			echo '{
				"sEcho": 1,
				"iTotalRecords": "0",
				"iTotalDisplayRecords": "0",
				"aaData": []
			}';

		}
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$memo = Memo::findorFail($id);
		$memo->coordinator = Request::input('coordinator');
		$memo->commitment_official= Request::input('commitment_official');
		$memo->save();

		Session::flash('memo_id', $id);

		return Redirect::route('dashboard.memo.index')
				->with('message', trans('common.memo_updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $memo = Memo::find($id);

        $memo->memo_item()->delete();

        $memo->delete();

        return Redirect::back()->with('message', trans('common.memo_deleted'));
	}

	public function addItem($id)
	{
		$item = new MemoItem();
		$item->memo_id = $id;
		$item->catalog = Request::input('catalog');
        $item->item_name = Request::input('item_name');
		$item->amount = str_replace(",", "", Request::input('amount'));;
		$item->unit = Request::input('unit');
		$item->save();

		return $item->id;
	}

	public function updateItem($id)
	{
		$item_id = Request::input('pk');
		$name = Request::input('name');
		$value = Request::input('value');

		$item = MemoItem::where("id","=",$item_id)->where("memo_id","=",$id)->first();
		$item->$name = $value;
		$item->save();

		return Response::make("", 200);
	}

	public function removeItem($id)
	{
		MemoItem::destroy(json_decode(Request::input('items'), true));
		return 0;
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

		/*$data = Memo::with('memo_item')->findOrFail($id);
		$user = User::find($data->user_id)->first();*/

        $data = DB::table('memos AS m')
                ->select('m.id', 'memo_no', 'memo_date', 'regarding', 'memo_status',
                         'u1.nip AS user_nip', 'u2.nip AS coordinator_nip', 'u3.nip AS commitment_nip',
			             'u1.name AS user_name', 'u2.name AS coordinator_name', 'u3.name AS commitment_name',
                         'a1.display_name AS coordinator_type', 'a2.display_name AS official_type')
                ->join('users AS u1', 'u1.id', '=', 'm.user_id')
                ->join('users AS u2', 'u2.id', '=', 'm.coordinator')
                ->join('users AS u3', 'u3.id', '=', 'm.commitment_official')
                ->join('additional_roles AS a1', 'a1.id', '=', 'u2.add_role')
                ->join('additional_roles AS a2', 'a2.id', '=', 'u3.add_role')
                ->where('m.id','=',$id)
                ->first();

        $item = MemoItem::where('memo_id','=',$id)->get();

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
		$section->addText(htmlspecialchars("Kepada\t:\tPejabat Pembuat Komitmen"), null, 'headerTabs');
		$section->addText(htmlspecialchars("Dari\t:\t".$data->user_name), null, 'headerTabs');
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

		foreach($item as $row) {
			$table->addRow();
			$table->addCell()->addText($i, null, 'styleCenter');
			$table->addCell()->addText($row->item_name, null, 'styleCell');
			$table->addCell()->addText($row->item_name, null, 'styleCell');
			$table->addCell()->addText(number_format($row->amount), null, 'styleRight');
			$table->addCell()->addText($row->unit, null, 'styleCell');
			$table->addCell()->addText($row->notes, null, 'styleCell');

			$i++;
		}

		//Tabs TTD 1
		$phpWord->addParagraphStyle(
				'ttd1Tabs',
				array(
						'tabs' => array(
								new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1)),
								new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(10))
						),
						'spaceAfter' => 0, 'spaceBefore' => 0, 'lineHeight' => 1
				)
		);

		$section->addText('');
		$section->addText(htmlspecialchars("\t\tSerpong, ".localeDate($data->memo_date, false)), null, 'ttd1Tabs');
		$section->addText(htmlspecialchars("\tPeneliti,\tKoordinator Keltian"), null, 'ttd1Tabs');
		$section->addText(htmlspecialchars("\t\t".substr($data->coordinator_type,20)), null, 'ttd1Tabs');
		$section->addText('');
		$section->addText('');
		$section->addText('');
		/*$section->addText(htmlspecialchars("\t".Auth::user()->name."\t"), null, 'ttd1Tabs');*/
		$textrun = $section->createTextRun('ttd1Tabs');
		$textrun->addText(htmlspecialchars("\t"));
		$textrun->addText($data->user_name, "underline");
        $textrun->addText(htmlspecialchars("\t"));
        $textrun->addText($data->coordinator_name, "underline");

		$section->addText(htmlspecialchars("\tNIP. ".$data->user_nip."\tNIP.".$data->coordinator_nip), null, 'ttd1Tabs');

		$section->addText('');

		$phpWord->addParagraphStyle(
				'ttd2Tabs',
				array(
						'tabs' => array(
								new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(5.5))
						),
                    'spaceAfter' => 0, 'spaceBefore' => 0, 'lineHeight' => 1
				)
		);

		$section->addText(htmlspecialchars("\t Pejabat Pembuat Komitmen"), null, 'ttd2Tabs');
		$section->addText(htmlspecialchars("\t".substr($data->official_type, 24).","), null, 'ttd2Tabs');
		$section->addText('');
		$section->addText('');
		$section->addText('');
        $textrun = $section->createTextRun('ttd2Tabs');
        $textrun->addText(htmlspecialchars("\t"));
        $textrun->addText($data->commitment_name, "underline");
        $section->addText(htmlspecialchars("\tNIP. ".$data->commitment_nip), null, 'ttd2Tabs');


		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$filename = "Memo".str_replace("/","--",$data->memo_no).".docx";
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

    public function autocomplete_catalog()
    {
        $memo_item = MemoItem::select(DB::raw('distinct(catalog) as catalog'))
                                ->orderBy('catalog','desc')->get();

        return json_decode($memo_item);
    }

	public function processMemo($id)
	{
		//$memo = MemoItem::with('memos')->findOrFail($id);
		$memo = DB::table('memo_items')
				->select('memo_items.id','memo_id', 'memo_no', 'memo_date', 'item_name', 'catalog', 'amount',
						'unit', 'notes','status','procurement_status','name')
				->join('memos', 'memos.id', '=', 'memo_items.memo_id')
				->join('users', 'users.id', '=', 'memos.user_id')
				->where('memo_items.id','=',$id)
				->first();

		return view('memo.process_memo', [
				"title" => trans('common.item_request_process'),
				'memo' => $memo
		]);
	}

	public function updateMemoStatus($id)
	{

		$memo = MemoItem::find($id);
		if (Request::input('status')) {
			$memo->status = Request::input('status');
			$memo->save();
			return Redirect::route('dashboard.memo.index')
					->with('message', trans('common.memo_saved'));
		}
		if (Request::input('procurement_status')) {
			$memo->procurement_status = Request::input('procurement_status');
			$memo->save();
			return Redirect::route('memo.forwarded.index')
					->with('message', trans('common.memo_saved'));
		}


	}

    public function editItemStatus($id)
    {
        $item = MemoItem::with('memo')->findOrFail($id)->first();

        return view('memo.item_details', [
            "title" => trans('common.add_procurement'),
            "item" => $item
        ]);
    }

	public function itemDestroy($id)
	{
		$memo = MemoItem::find($id);

		//$memo->memo_item()->delete();

		$memo->delete();

		return Redirect::back()->with('message', trans('common.memo_deleted'));
	}

	public function forwarded_memo()
	{
		$data = DB::table('memo_items')
				->select('memo_items.id','memo_id', 'memo_no', 'memo_date', 'item_name',
						 'catalog', 'amount', 'unit', 'notes','status','procurement_status','name')
				->join('memos', 'memos.id', '=', 'memo_items.memo_id')
				->join('users', 'users.id', '=', 'memos.user_id')
				->where('status','=',2)
				->orderBy("memo_id","desc")
				->get();

		$page = 'memo.index_gudang';

		return view($page, [
				"title" => trans('common.procurement'),
				"data" => $data
		]);
	}

	public function listAdditionalRole($parent = 1)
	{
		$data = array();
		$user = DB::table('users')
				->select('users.id','users.name')
				->join('additional_roles', 'additional_roles.id', '=', 'users.add_role')
				->where('parent','=',$parent)
				->get();

		foreach ($user as $val)
		{
			$data[$val->id] = $val->name;
		}

		return $data;
	}
}