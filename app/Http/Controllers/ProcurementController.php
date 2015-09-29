<?php namespace qilara\Http\Controllers;

use qilara\Http\Requests;
use qilara\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use qilara\Models\Invoice;
use qilara\Models\PurchaseOrder;
use Request;
use qilara\Models\Procurement;
use qilara\Models\ProcurementItem;
use Redirect;
use Input;
use Validator;
use Auth;
use yajra\Datatables\Datatables;
use Response;

class ProcurementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = Procurement::with('procurement_item')->orderBy('id', 'desc')->get();
        return view('procurement.index', [
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
        return view('procurement.create', [
            "title" => trans('common.add_procurement'),
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
        $fileName = "";

        if (Input::hasFile('offering_letter')) {
            $file = array('image' => Input::file('offering_letter'));
            $rules = array('image' => 'mimes:jpeg,png,bmp,doc,docx,pdf,xls,xlsx');
            $validator = Validator::make($file, $rules);

            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                if (Input::file('offering_letter')->isValid()) {
                    $destinationPath = 'uploads';
                    $extension = Input::file('offering_letter')->getClientOriginalExtension();
                    $fileName = basename(Input::file('offering_letter')->getClientOriginalName(), "." . $extension) . "_" . rand(11111, 99999) . '.' . $extension;
                    Input::file('offering_letter')->move($destinationPath, $fileName);
                }
            }

        }

        $date = explode("/", Request::input('offering_letter_date'));

        $procurement = new Procurement();
        $procurement->company_name = Request::input('company_name');
        $procurement->address = Request::input('address');
        $procurement->phone = Request::input('phone');
        $procurement->fax = Request::input('fax');
        $procurement->contact_person = Request::input('contact_person');

        $procurement->offering_letter_no = Request::input('offering_letter_no');
        $procurement->offering_letter_date = sprintf("%04d-%02d-%02d", $date[2], $date[1], $date[0]);
        $procurement->offering_letter = $fileName;
        $procurement->created_by = Auth::user()->id;


        $procurement->save();

        /*$cur_proc = Procurement::find($procurement->id);

        if (!empty($_POST['items'])) {
            $items = json_decode($_POST['items']);

            foreach ($items as $keys => $val) {
                $proc_item = new ProcurementItem();
                $proc_item->item_name = $val[1];
                $proc_item->amount = str_replace(",", "", $val[2]);
                $proc_item->unit = $val[3];
                $proc_item->unit_price = str_replace(",", "", $val[4]);

                $cur_proc->procurement_item()->save($proc_item);
            }
        }*/

        return Redirect::route('dashboard.procurement.edit', $procurement->id)
            ->with('message', trans('common.procurement_saved'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $data = Procurement::findOrFail($id);

        $order = array('letter_no' => $this->generate_invoice(), 'date' => null, 'info' => null);
        $po = PurchaseOrder::where("proc_id","=",$id)->first();

        if ($po)
        {
            $order['letter_no'] = $po->letter_no;
            $order['date'] = convertToDatepicker($po->letter_date);
            $order['info'] = $po->additional_info;
        }

        return view('procurement.show', [
            "title" => trans('common.add_procurement'),
            "data" => $data,
            'letter_no' => $order['letter_no'],
            'po_letter_date' => $order['date'],
            'additional_info' => $order['info']
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $procurement = Procurement::findOrFail($id);

        $items = $this->jsArray($procurement->procurement_item);

        return view('procurement.create', [
            "title" => trans('common.add_procurement'),
            "procurement" => $procurement,
            "items" => $items,
            'date' => convertToDatepicker($procurement->offering_letter_date)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $date = explode("/", Request::input('offering_letter_date'));

        $procurement = Procurement::find($id);
        $procurement->company_name = Request::input('company_name');
        $procurement->address = Request::input('address');
        $procurement->phone = Request::input('phone');
        $procurement->fax = Request::input('fax');
        $procurement->contact_person = Request::input('contact_person');

        $procurement->offering_letter_no = Request::input('offering_letter_no');
        $procurement->offering_letter_date = sprintf("%04d-%02d-%02d", $date[2], $date[1], $date[0]);

        if (Input::hasFile('offering_letter')) {
            $file = array('image' => Input::file('offering_letter'));
            $rules = array('image' => 'mimes:jpeg,png,bmp,doc,docx,pdf,xls,xlsx');
            $validator = Validator::make($file, $rules);

            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                if (Input::file('offering_letter')->isValid()) {
                    $destinationPath = 'uploads';
                    $extension = Input::file('offering_letter')->getClientOriginalExtension();
                    $fileName = basename(Input::file('offering_letter')->getClientOriginalName(), "." . $extension) . "_" . rand(11111, 99999) . '.' . $extension;
                    Input::file('offering_letter')->move($destinationPath, $fileName);

                    $procurement->offering_letter = $fileName;
                }
            }

        }

        $procurement->updated_by = Auth::user()->id;

        $procurement->save();

       /* $cur_proc = Procurement::find($id);

        ProcurementItem::where("proc_id", "=", $id)->delete();

        if (!empty($_POST['items'])) {
            $items = json_decode($_POST['items']);

            foreach ($items as $keys => $val) {
                $proc_item = new ProcurementItem();
                $proc_item->item_name = $val[1];
                $proc_item->amount = str_replace(",", "", $val[2]);
                $proc_item->unit = $val[3];
                $proc_item->unit_price = str_replace(",", "", $val[4]);

                $cur_proc->procurement_item()->save($proc_item);
            }
        }*/

        return Redirect::route('dashboard.procurement.index')
            ->with('message', trans('common.procurement_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $procurement = Procurement::find($id);

        $procurement->procurement_item()->delete();

        $procurement->delete();

        return Redirect::back()->with('message', trans('common.offering_deleted'));
    }

    public function uploadInvoice($id)
    {
        $file = array('image' => Input::file('invoice'));
        $rules = array('image' => 'mimes:jpeg,png,bmp,doc,docx,pdf,xls,xlsx');
        $validator = Validator::make($file, $rules);


        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {

            if (Request::hasFile('invoice') && Request::file('invoice')->isValid()) {
                $destinationPath = 'uploads';
                $extension = Request::file('invoice')->getClientOriginalExtension();
                $fileName = basename(Request::file('invoice')->getClientOriginalName(), "." . $extension) . "_" . rand(11111, 99999) . '.' . $extension;
                Request::file('invoice')->move($destinationPath, $fileName);


                $invoice = Invoice::firstOrNew(['proc_id' => $id]);
                $invoice->path = $fileName;
                $invoice->user_id = Auth::user()->id;

                $invoice->save();
                return Redirect::back()->with('message', trans('common.invoice_saved'));
            }
            else
            {
                return Redirect::back()->withInput()->withErrors(trans('common.error_occured'));
            }
        }
    }

    public function changeStatus($id)
    {
        //echo $id;
        $file = array('image' => Input::file('payment_proof'));
        $rules = array('image' => 'mimes:jpeg,png,bmp,doc,docx,pdf,xls,xlsx');
        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $procurement = Procurement::find($id);
            $procurement->proc_status = Request::input('status');


            if (Request::hasFile('payment_proof') && Request::file('payment_proof')->isValid()) {
                $destinationPath = 'uploads';
                $extension = Request::file('payment_proof')->getClientOriginalExtension();
                $fileName = basename(Request::file('payment_proof')->getClientOriginalName(), "." . $extension) . "_" . rand(11111, 99999) . '.' . $extension;
                Request::file('payment_proof')->move($destinationPath, $fileName);

                $procurement->payment_proof = $fileName;
            }

            $procurement->save();

            return Redirect::back()
                ->with('message', trans('common.status_saved'));
        }
    }

    public function jsArray($data)
    {
        $str = '[';
        foreach ($data as $val) {
            //$str .= '["' . $val->id . '","' . $val->item_name . '", "' . number_format($val->amount) . '", "' . $val->unit . '","' . number_format($val->unit_price) . '"],';
            $str .= '["' . $val->id . '","' . $val->item_name . '", "' . number_format($val->amount) . '", "' . $val->unit . '","' . $val->unit_price . '"],';
        }

        $str = substr($str, 0, -1) . "];";

        return $str;
    }

    public function purchaseOrder($id)
    {
        /*$data = Procurement::with('purchase_order')->findOrFail($id);

        return view('procurement.purchase_order', [
            "data" => $data
        ]);*/
        $this->generateWordLetter($id);
    }

    public function generate_invoice()
    {
        $month = date('n');
        $month = numberToRoman($month);

        $year = date('Y');

        $suffix = "/PP-BTPK/PO/" . $month . "/" . $year;
        $po = PurchaseOrder::where("letter_no", "LIKE", "%" . $suffix)->orderBy('letter_no', 'desc')->first();

        if (!$po) {
            return "001" . $suffix;
        } else {
            $number = intval(substr($po->letter_no, 0, 3));
            return sprintf("%03d",($number + 1)) . $suffix;
        }
    }

    public function printPO($id)
    {
        $po = PurchaseOrder::firstOrNew(array("proc_id" => $id));
        $date = explode("/", Request::input('po_letter_date'));

        //$po->proc_id = $id;
        $po->letter_no = Request::input('purchase_order_no');
        $po->letter_date = sprintf("%04d-%02d-%02d", $date[2], $date[1], $date[0]);

        $po->user_id = Auth::user()->id;
        $po->additional_info = Request::input('additional_info');
        $po->save();

        $url = route('dashboard.procurement.purchase_order', $id);
        link_new_window($url);

        return Redirect::route('dashboard.procurement.show', $id)
            ->with('message', trans('common.purchase_order_saved'));
    }

    public function datatables($id)
    {
        $items = ProcurementItem::select('id','proc_id','item_name','amount','unit','unit_price')->where('proc_id','=',$id)->get();

        foreach ($items as $key => &$val)
        {
            //$val->item_name = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" data-url="'.route('procurement.datatables.edit', array($id, $val->id)).'">'.$val->item_name.'</a>';
            $val->item_name = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="item_name" data-url="'.route('procurement.datatables.edit', $id).'">'.$val->item_name.'</a>';
            $val->amount = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="amount" data-url="'.route('procurement.datatables.edit', $id).'">'.$val->amount.'</a>';
            $val->unit = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="unit" data-url="'.route('procurement.datatables.edit', $id).'">'.$val->unit.'</a>';
            $val->unit_price = '<a href="javascript://" class="item_name" data-type="text" data-pk="'.$val->id.'" id="unit_price" data-url="'.route('procurement.datatables.edit', $id).'">'.$val->unit_price.'</a>';
        }

        return Datatables::of($items)->make(true);
    }

    public function updateItem($id)
    {
        $item_id = Request::input('pk');
        $name = Request::input('name');
        $value = Request::input('value');

        $item = ProcurementItem::where("id","=",$item_id)->where("proc_id","=",$id)->first();
        $item->$name = $value;
        $item->save();

        return Response::make("", 200);
    }

    public function addItem($id)
    {
        $item = new ProcurementItem();
        $item->proc_id = $id;
        $item->item_name = Request::input('item_name');
        $item->amount = str_replace(",", "", Request::input('amount'));;
        $item->unit = Request::input('unit');
        $item->unit_price = str_replace(",", "", Request::input('unit_price'));;
        $item->save();

        return $item->id;
    }

    public function removeItem($id)
    {
        ProcurementItem::destroy(json_decode(Request::input('items'), true));
        return 0;
    }

    public function generateWordLetter($id)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->addParagraphStyle('styleRight', array('align' => 'right', 'valign' => 'center'));
        $phpWord->addParagraphStyle('styleCenter', array('align' => 'center', 'valign' => 'center'));
        $phpWord->addParagraphStyle('stylePaddingTop', array('spaceBefore' => '480', 'spaceAfter' => '0'));
        $phpWord->addFontStyle('bold', array('bold' => true));
        $phpWord->addFontStyle('underline', array('underline' => 'single'));
        $phpWord->addParagraphStyle('styleContent', array('spaceBefore' => '0', 'spaceAfter' => '240'));
        $phpWord->addParagraphStyle('styleFirstLine', array('spaceBefore' => '480', 'spaceAfter' => '240'));
        $phpWord->addParagraphStyle('styleContent2', array('spaceBefore' => '240', 'spaceAfter' => '240'));
        //$phpWord->addTitleStyle(1, array('bold' => true), array('spaceAfter' => 240));
        $phpWord->addFontStyle('footer_small', array('size' => 9));
        $phpWord->addParagraphStyle('singlePar', array('spaceAfter' => 0, 'spaceBefore' => 0, 'lineHeight' => 1, 'align' => 'center'));

        $data = Procurement::with('purchase_order')->findOrFail($id);

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
            'noSuratTabs',
            array(
                'tabs' => array(
                    new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2)),
                    new \PhpOffice\PhpWord\Style\Tab('left', \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2.5))
                )
            )
        );

        $section->addText('Serpong, '.localeDate($data->purchase_order->letter_date), null, 'styleRight');
        $section->addText(htmlspecialchars("Nomor\t:\t".$data->purchase_order->letter_no), null, 'noSuratTabs');
        $section->addText(htmlspecialchars("Perihal\t:\tSurat Pesanan"), null, 'noSuratTabs');

        $section->addText('Kepada Yth,', null, 'stylePaddingTop');
        $section->addText($data->company_name, 'bold');
        $section->addText($data->address, 'bold');

        if (! empty($data->phone))
            $section->addText("Telp . ". $data->phone, 'bold');

        if (! empty($data->fax))
            $section->addText("Fax . ". $data->phone, 'bold');

        $section->addText('Dengan Hormat,', null, 'styleFirstLine');
        $section->addText(sprintf('Sesuai dengan penawaran harga dari %s No. %s tanggal %s, mohon untuk pengiriman barang dibawah ini:',$data->company_name, $data->offering_letter_no, localeDate($data->offering_letter_date)), null, 'styleContent');

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
        $table->addCell(1200, $styleCell)->addText(htmlspecialchars('Qty'), $fontStyle, 'styleCenter');
        $table->addCell(1500, $styleCell)->addText(htmlspecialchars('Harga Satuan (Rp.)'), $fontStyle, 'styleCenter');
        $table->addCell(1500, $styleCell)->addText(htmlspecialchars('Total (Rp.)'), $fontStyle, 'styleCenter');

        $i = 1;
        $sub_total = 0;
        foreach($data->procurement_item as $row){
            $table->addRow();
            $table->addCell()->addText($i, null, 'styleCenter');
            $table->addCell()->addText($row->item_name, null, 'styleCell');
            $table->addCell()->addText($row->amount." ". $row->unit, null, 'styleCenter');
            $table->addCell()->addText(number_format($row->unit_price),null, 'styleRight');
            $table->addCell()->addText(number_format($row->unit_price * $row->amount), null, 'styleRight');

            $sub_total += ($row->unit_price * $row->amount);
            $i++;
        }

        $ppn = $sub_total * 0.1;
        $total = $sub_total + $ppn;

        $table->addRow();
        $table->addCell(null, $cellColSpan)->addText("Jumlah", 'bold', 'styleCenter');
        $table->addCell()->addText(number_format($sub_total), 'bold', 'styleRight');

        $table->addRow();
        $table->addCell(null, $cellColSpan)->addText("PPN 10%", 'bold', 'styleCenter');
        $table->addCell()->addText(number_format($ppn), 'bold', 'styleRight');

        $table->addRow();
        $table->addCell(null, $cellColSpan)->addText("Total", 'bold', 'styleCenter');
        $table->addCell()->addText(number_format($total), 'bold', 'styleRight');

        $textrun = $section->addTextRun('styleFirstLine');
        $textrun->addText('Terbilang : ');
        $textrun->addText(terbilang($total)." rupiah",'bold');

        if (! empty($data->purchase_order->additional_info)) {
            try {
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $data->purchase_order->additional_info);    
            }
            catch (\Exception $e)
            {
                echo "<h1><Error Occured, Contact System Administrator/h1>";
                exit;
            }
            
        }

        $section->addText("Demikian atas perhatian dan kerjasamanya kami ucapkan terima kasih.", null, 'styleContent2');

        $footerTable = array('width' => '100', 'borderTopSize' => 6, 'borderBottomSize' => 6, 'cellMargin' => 80 );
        $bottomCellBorder = array('borderBottomSize' => 6, 'align' => 'center', 'valign' => 'center');

        $phpWord->addTableStyle('Footer Table', $footerTable);

        $table = $section->addTable('Footer Table');

        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'top');
        $cellBottom = array('vMerge' => 'restart', 'valign' => 'bottom');
        $cellRowContinue = array('vMerge' => 'continue');
        $row3cm = array('exactHeight ' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3));

        $table->addRow($bottomCellBorder);
        $cell = $table->addCell(5000, $cellRowSpan);
        $cell->addListItem('Mohon untuk ditandatangani dan difax kembali ke (021) 7560549', 0);
        $cell->addListItem('Kwitansi penagihan ditujukan kepada :', 0);
        $cell->addListItem('Bidang Teknologi Proses dan Katalisis', 1, null, 1);
        $cell->addListItem('NPWP : 00.397.688.3-411.000',1, 'bold',  1);

        $table->addCell(4000)->addText('Pejabat Pengadaan Bidang Teknologi Proses dan Katalisis T.A 2015,', 'bold', 'styleCenter');
        $table->addCell(4000)->addText($data->company_name.',', 'bold', 'styleCenter');

        $table->addRow($row3cm);
        $table->addCell(null, $cellRowContinue);

        $cell = $table->addCell(null,$cellBottom);
        $cell->addText('Nandang Sutiana','underline', 'singlePar');
        $cell->addText('NIP. 19771118200911101',null, 'singlePar');

        $cell = $table->addCell(null,$cellBottom);
        $cell->addText($data->contact_person,'underline', 'singlePar');
        $cell->addText(' ',null, 'singlePar');

        //Save
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $filename = "Surat Pesanan ".str_replace("/","--",$data->purchase_order->letter_no).".docx";

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

}
