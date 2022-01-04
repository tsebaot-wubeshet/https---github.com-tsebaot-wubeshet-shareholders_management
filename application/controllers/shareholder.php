<?php

session_start(); //we need to start session in order to access it through CI

class Shareholder extends CI_Controller
{
	public $connection = "";
	private $initialPaidUpCapital = 0.00;
	private $soldShare = 0.00;
	private $boughtShare = 0.00;
	//$totalTransfered=$boughtShare-$soldShare;
	private $totalTransfered = 0.00;
	//$adjestedBalance=$initialPaidUpCapital+$totalTransfered;
	private $adjestedBalance = 0.00;
	private $forAdjustment = 0.00;
	//$adjustedBalanceForDividend=$adjestedBalance-$forAdjustment;
	private $adjustedBalanceForDividend = 0.00;
	private $dividendCapitalized = 0.00;
	private $dividendPayableCapitalized = 0.00;
	private $cashPaid = 0.00;
	//$totalRaised=$dividendCapitalized+$dividendPayableCapitalized+$cashPaid
	private $totalRaised = 0.00;
	//$totalPaidUpCapital=$adjestedBalance+$totalRaised;
	private $totalPaidUpCapital = 0.00;
	//sum Of each breackdown value
	private $sumOfAveragePaidupCapital = 0.00;
	//$totalPaidUpCapitalUtilazid=$adjustedBalanceForDividend+$sumOfAveragePaidupCapital
	private $totalPaidUpCapitalUtilazid = 0.00;
	private $fullyBoughtForAdjustment = 0.00;
	private $forNestedBoughtShare = 0.00;
	private $fromNestedfullBought = array();
	public function __construct()
	{
		$this->connection = mysqli_connect('localhost', 'root', '', 'shareholder');
		parent::__construct();

		// Load form helper library
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->helper('url');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// Load database
		$this->load->model('shareholder_model');
		$this->load->model('login_database');
	}
	public function index()
	{
		$this->load->helper('url');
		$this->load->view('sessions/login_form');
	}
	public function home()
	{
		$this->load->helper('url');
		$this->load->view('layouts/admin_page');
	}

	public function view_tender()
	{

		$this->load->library('pagination');
		$this->load->library('table');
		//$this->table->set_heading('Id','Tender Title');

		$config['base_url'] = 'http://127.0.0.1/fetanjobs/index.php/tenders/view_tender';
		$config['total_rows'] = $this->db->get('tender')->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 5;
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';

		$this->pagination->initialize($config);
		$data['records'] = $this->db->get('tender', $config['per_page'], $this->uri->segment(3));
		$this->load->view('tender/view_tender', $data);
	}

	public function blocked_share_excel()
	{
		$this->load->view('shareholder/blocked_share_excel');
	}
	public function pledged_share_excel()
	{
		$this->load->view('shareholder/pledged_share_excel');
	}
	public function certificate_share_excel()
	{
		$this->load->view('shareholder/certificate_share_excel');
	}
	public function new_share_request_excel()
	{
		$this->load->view('shareholder/new_share_request_excel');
	}
	public function new_share_request_report()
	{
		$this->load->view('shareholder/new_share_request');
	}

	public function add_user()
	{
		$this->load->view('sessions/user');
	}
	public function list_user()
	{
		$this->load->view('sessions/user_list');
	}
	public function reset_password()
	{
		$this->load->view('sessions/changepass');
	}
	public function cash_rev_report()
	{
		$this->load->view('shareholder/cash_rev_report');
	}
	public function list_allotment()
	{
		$this->load->view('shareholder/list_allotment');
	}
	public function authorize_allotment()
	{
		$this->load->view('shareholder/authorize_allotment');
	}
	public function create_shareholder_from_existing()
	{
		$this->load->view('shareholder/create_shareholder_from_existing');
	}
	public function choose_shareholder()
	{
		$this->load->view('shareholder/choose_shareholder');
	}
	public function type_of_transfer()
	{
		$this->load->view('shareholder/type_of_transfer');
	}
	public function query()
	{
		$this->load->view('shareholder/query');
	}
	public function share_for_resale()
	{
		$this->load->view('shareholder/share_for_resale');
	}
	public function transfer_share_for_sale()
	{
		$this->load->view('shareholder/transfer_share_for_sale');
	}
	public function dev_rev_report()
	{
		$this->load->view('shareholder/dev_rev_report');
	}
	public function payable_rev_report()
	{
		$this->load->view('shareholder/payable_rev_report');
	}
	public function transfer_to_existing()
	{
		$this->load->view('shareholder/transfer_to_existing');
	}
	//certificate mgt
	public function manage_allotement()
	{
		$this->load->view('shareholder/manage_allotement');
	}
	public function add_paidup()
	{
		$this->load->view('shareholder/add_paidup');
	}
	public function edit_requested_share()
	{
		$this->load->view('shareholder/edit_requested_share');
	}
	public function edit_certificate()
	{
		$this->load->view('shareholder/edit_certificate');
	}
	public function upload_certificate()
	{
		$this->load->view('shareholder/upload_certificate');
	}
	public function upload_balance()
	{
		$this->load->view('shareholder/upload_balance');
	}
	public function dividend_report_excel()
	{
		$this->load->view('shareholder/dividend_report_excel');
	}
	public function shareholder_excel()
	{
		$this->load->view('shareholder/shareholder_excel');
	}
	public function transfer_share_from_nib_excel()
	{
		$this->load->view('shareholder/transfer_share_from_nib_excel');
	}

	public function update_certificate()
	{
		$this->load->view('shareholder/update_certificate');
	}
	public function rejected_report()
	{
		$this->load->view('shareholder/rejected_report');
	}
	public function dividend_cap()
	{
		$this->load->view('shareholder/dividend_cap');
	}
	public function pledged_report()
	{
		$this->load->view('shareholder/pledged_report');
	}
	public function blocked_report()
	{
		$this->load->view('shareholder/blocked_report');
	}
	public function release_blocked_share()
	{
		$this->load->view('shareholder/release_blocked_share');
	}
	public function closed_transfer_share()
	{
		$this->load->view('shareholder/closed_report');
	}
	public function closed_share()
	{
		$this->load->view('shareholder/closed_share');
	}
	public function release_pledge()
	{
		$this->load->view('shareholder/release_pledge');
	}
	public function transfer_share_excel()
	{
		$this->load->view('shareholder/transfer_share_excel');
	}
	public function transfer_bank_report()
	{
		$this->load->view('shareholder/transfer_bank_report');
	}
	public function authorize_cash_share_bank()
	{
		$this->load->view('shareholder/authorize_cash_share_bank');
	}
	public function transfer_report()
	{
		$this->load->view('shareholder/transfer_report');
	}
	public function closed_report()
	{
		$this->load->view('shareholder/closed_report');
	}
	public function transfer_from_nib()
	{
		$this->load->view('shareholder/transfer_from_nib');
	}
	public function authorize_new_shareholder()
	{
		$this->load->view('shareholder/authorize_new_shareholder');
	}
	public function authorize_blocked()
	{
		$this->load->view('shareholder/authorize_blocked');
	}
	public function authorize_transfer()
	{
		$this->load->view('shareholder/authorize_transfer');
	}
	public function authorize_cashpayment()
	{
		$this->load->view('shareholder/authorize_cashpayment');
	}
	public function authorize_capitalized()
	{
		$this->load->view('shareholder/authorize_capitalized');
	}
	public function authorize_payable()
	{
		$this->load->view('shareholder/authorize_payable');
	}

	public function release_blocked()
	{
		$this->load->view('shareholder/release_blocked');
	}

	public function pledged_release()
	{
		$this->load->view('shareholder/pledged_release');
	}
	public function distribute_capcash()
	{
		$this->load->view('shareholder/distribute_capcash');
	}
	public function transfer_cap_cash_pay()
	{
		$this->load->view('shareholder/transfer_cap_cash_pay');
	}
	public function edit_distribute()
	{
		$this->load->view('shareholder/edit_distribute');
	}
	public function edit_paidup()
	{
		$this->load->view('shareholder/edit_paidup');
	}
	public function edit_dividend()
	{
		$this->load->view('shareholder/edit_dividend');
	}
	public function add_dividend()
	{
		$this->load->view('shareholder/add_dividend');
	}
	public function paidup_calc()
	{
		$this->load->view('shareholder/paidup_calc');
		//not used
	}
	public function certificate()
	{
		$this->load->view('shareholder/certificate');
	}
	public function edit_cap_dividend()
	{
		$this->load->view('shareholder/edit_cap_dividend');
	}
	public function certificate_report()
	{
		$this->load->view('shareholder/certificate_report');
	}
	public function edit_capitalized()
	{
		$this->load->view('shareholder/edit_capitalized');
	}
	//end certificate mgt

	//dividend payable mgt
	public function dividend_payable()
	{
		$this->load->view('shareholder/dividend_payable');
	}

	//end dividend payable mgt
	public function authorizetransfer()
	{
		$this->load->view('shareholder/printslip');
	}

	public function top_shareholders()
	{
		$this->load->view('shareholder/top_shareholders');
	}

	public function layouts()
	{
		$this->load->view('layouts/admin_page');
	}

	public function allotment_update()
	{
		$this->load->view('shareholder/allotment_update');
	}

	public function statement()
	{
		$this->load->view('shareholder/statement');
	}

	public function edit_shareholder()
	{
		$this->load->view('shareholder/edit_shareholder');
	}

	public function dividend_calculation()
	{
		$this->load->view('shareholder/dividend_calculation');
	}
	// public function dividendCalculation(){

	// 	}
	public function dividend_calculationAlgorithim()
	{
		$conn = $this->connection;
		$this->clearTables();
		$budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");
		$budget_result = mysqli_fetch_array($budget_query);
		$from = "";
		$to = "";
		$year = 0;
		if ($budget_result) {
			$from = $budget_result['budget_from'];
			$to = $budget_result['budget_to'];
			$year = $budget_result['id'];
		}
		$shareholders = mysqli_query($conn, "SELECT account_no,currentYear_status from shareholders where  currentYear_status= 1 or (currentYear_status=2 and closed_year=$year) order by account_no ASC") or die(mysqli_error($conn));
		$orderShareholder = 0;
		while ($shareholder = mysqli_fetch_array($shareholders)) {
			$account = $shareholder['account_no'];
			$countNumber = $shareholder['account_no'];
			$this->fullyBoughtForAdjustment = 0.00;
			$this->forNestedBoughtShare = 0.00;
			$this->sumOfAveragePaidupCapital = 0.00;
			$this->fromNestedfullBought = array();

			if ($shareholder['currentYear_status'] == 1) {
				$this->fromFullyBought($conn, $account, $from, $to, $year);
				$this->forBreakdown($conn, $account, $from, $to, $year);
				$this->breakdown($conn, $account, $from, $to, $year);
			}
			$this->cualculation($conn, $account, $from, $to, $year);

			$totalPaidUpCapitalUtilazid = 0.00;
			if ($shareholder['currentYear_status'] == 1) {
				$totalPaidUpCapitalUtilazid = $this->sumOfAveragePaidupCapital + $this->adjustedBalanceForDividend;
				//   mysqli_query($conn,"INSERT INTO paidup_utilized (account,amount,year) values($account,$totalPaidUpCapitalUtilazid,$year)") or die(mysqli_error($conn));//ON DUPLICATE KEY UPDATE amount=values(amount)
			}
			mysqli_query($conn, "INSERT INTO dividend_report (account,initial_paidup_capital,transfer,adjusted_balance,forAdjustment,adjusted_balance_for_dividend,capitalized,payable,cash,total_raised,total_paidup_capital,total_average_paidup_capital,total_utilized_paidup_capital,year)
		 values('$account',round($this->initialPaidUpCapital,2),round($this->totalTransfered,2),round($this->adjestedBalance,2),round($this->forAdjustment,2),round($this->adjustedBalanceForDividend,2),round($this->dividendCapitalized,2),round($this->dividendPayableCapitalized,2),round($this->cashPaid,2),round($this->totalRaised,2),round($this->totalPaidUpCapital,2),round($this->sumOfAveragePaidupCapital,2),round($totalPaidUpCapitalUtilazid,2),$year) 
		 ") or die(mysqli_error($conn)); //ON DUPLICATE KEY UPDATE initial_paidup_capital = values(initial_paidup_capital), transfer = values(transfer), adjusted_balance = values(adjusted_balance), forAdjustment = values(forAdjustment), adjusted_balance_for_dividend = values(adjusted_balance_for_dividend), capitalized = values(capitalized), payable = values(payable), cash = values(cash), total_raised = values(total_raised), total_paidup_capital = values(total_paidup_capital), total_average_paidup_capital = values(total_average_paidup_capital), total_utilized_paidup_capital = values(total_utilized_paidup_capital)


			$orderShareholder += 1;
		}

		redirect('/shareholder/dividend_report');
	}
	public function dividend_portion_report()
	{
		$conn = $this->connection;
		$budget_query = mysqli_query($conn, "SELECT * FROM budget_year WHERE budget_status = 1");
		$budget_result = mysqli_fetch_array($budget_query);
		$year = 0;
		if ($budget_result) {
			$year = $budget_result['id'];
		}
		$this->dividend_portion($conn, $year);
		redirect('/shareholder/dividend_report');
	}
	private function clearTables()
	{
		$conn = $this->connection;
		mysqli_query($conn, "DELETE FROM break_down") or die(mysqli_error($conn));
		mysqli_query($conn, "DELETE FROM dividend_report") or die(mysqli_error($conn));
		mysqli_query($conn, "DELETE FROM ratio_dividend") or die(mysqli_error($conn));
		mysqli_query($conn, "DELETE FROM paidup_utilized") or die(mysqli_error($conn));
	}
	private function dividend_portion($conn, $year)
	{
		mysqli_query($conn, "DELETE FROM ratio_dividend") or die(mysqli_error($conn));
		$paidup_utilized_sum = mysqli_query($conn, "SELECT SUM(total_utilized_paidup_capital) as value from dividend_report where year=$year ") or die(mysqli_error($conn));
		$total_paidup_utilized = mysqli_fetch_array($paidup_utilized_sum);
		$paidup_utilized = mysqli_query($conn, "SELECT account, total_utilized_paidup_capital as amount from dividend_report where year=$year ") or die(mysqli_error($conn));
		while ($paidup_utilized_row = mysqli_fetch_array($paidup_utilized)) {
			$accountNum = $paidup_utilized_row['account'];
			$ratio = 0;
			if ($total_paidup_utilized['value'] > 0) {
				$ratio = $paidup_utilized_row['amount'] / floatval($total_paidup_utilized['value']);
			}
			$dividend_amt = mysqli_query($conn, "SELECT dividend from dividend_amount where year = $year ") or die(mysqli_error($conn));
			$div_amt = mysqli_fetch_array($dividend_amt);
			$dividend = 0;
			if ($div_amt) {
				$dividend = $div_amt['dividend'];
			}
			$dividend_portion = $ratio * $dividend;
			mysqli_query($conn, "INSERT INTO ratio_dividend (account,ratio,dividend_portion,year) values($accountNum,$ratio,$dividend_portion,$year)") or die(mysqli_error($conn)); //ON DUPLICATE KEY UPDATE ratio=values(ratio),dividend_portion=values(dividend_portion)
		}
	}
	private function dateDiff($start, $end)
	{
		$start_ts = strtotime($start);
		$end_ts = strtotime($end);
		$diff = abs($end_ts - $start_ts) + 1;
		return round($diff / 86400);
	}
	private function cualculation($conn, $account, $from, $to, $year, $fullyTransfer = false)
	{
		$balance_query = mysqli_query($conn, "SELECT total_paidup_capital_inbirr from balance where account = '$account' and year =$year") or die(mysqli_error($conn));
		$balance_rows = mysqli_fetch_array($balance_query);
		$balance = $balance_rows ? $balance_rows['total_paidup_capital_inbirr'] : 0;
		$this->initialPaidUpCapital = floatval($balance);
		$result = mysqli_query($conn, "SELECT sum(total_transfered_in_birr)  from transfer where seller_account = '$account'  and year=$year and status_of_transfer = 4") or die(mysqli_error($conn));
		$result1 = mysqli_query($conn, "SELECT sum(total_transfered_in_birr) from transfer where buyer_account = '$account' and year=$year and status_of_transfer = 4") or die(mysqli_error($conn));
		if ($fullyTransfer) {
			$result = mysqli_query($conn, "SELECT sum(total_transfered_in_birr)  from transfer where seller_account = '$account'  and year=$year and status_of_transfer = 4
		                                and id not in(select id from transfer where seller_account='$account' and agreement=3 and full_transfer=true and year=$year) ") or die(mysqli_error($conn));
			// $result1 = mysqli_query($conn,"SELECT *,sum(total_transfered_in_birr) from transfer where buyer_account = '$account' and year=$year and status_of_transfer = 4
			//                                 and id not in(select id from transfer where buyer_account='$account' and agreement='buyer' and full_transfer=true and year=$year)") or die(mysqli_error($conn));
		}
		$soldShareArray = mysqli_fetch_assoc($result);
		$boughtShareArray = mysqli_fetch_array($result1);
		$this->boughtShare = $boughtShareArray ? $boughtShareArray['sum(total_transfered_in_birr)'] : 0;
		if (!$fullyTransfer) {
			$this->boughtShare += $this->forNestedBoughtShare;
		}
		$this->soldShare = $soldShareArray ? $soldShareArray['sum(total_transfered_in_birr)'] : 0;
		$this->totalTransfered = $this->boughtShare - $this->soldShare;
		$this->adjestedBalance = $this->initialPaidUpCapital + $this->totalTransfered;

		$resultForAdjestment = mysqli_query($conn, "SELECT sum(total_transfered_in_birr)  from transfer where seller_account = '$account' and agreement= 2  and year=$year and status_of_transfer = 4") or die(mysqli_error($conn));
		$soldShareArrayForAdjestment = mysqli_fetch_assoc($resultForAdjestment);
		$soldValueForAdjestment = $soldShareArrayForAdjestment ? $soldShareArrayForAdjestment['sum(total_transfered_in_birr)'] : 0;
		//will update here
		$resultForAdjestment = mysqli_query($conn, "SELECT sum(total_transfered_in_birr) from transfer where buyer_account = '$account' and (agreement != 3 or (agreement = 3 and full_transfer=true)) and year=$year and status_of_transfer = 4") or die(mysqli_error($conn));
		$boughtShareArrayForAdjestment = mysqli_fetch_array($resultForAdjestment);
		$boughtValueForAdjestment = $boughtShareArrayForAdjestment ? $boughtShareArrayForAdjestment['sum(total_transfered_in_birr)'] : 0;

		$this->forAdjustment = $soldValueForAdjestment - $boughtValueForAdjestment;
		if (!$fullyTransfer) {
			$this->forAdjustment += $this->fullyBoughtForAdjustment - $this->forNestedBoughtShare;
		}

		$this->adjustedBalanceForDividend = $this->adjestedBalance + $this->forAdjustment;
		$result = mysqli_query($conn, "SELECT SUM(capitalized_in_birr) AS capitalized_in_birr from capitalized where account = '$account' and type = 1 and year=$year and capitalized_status = 4") or die(mysqli_error($conn));
		$capitalizedArray = mysqli_fetch_array($result);
		$this->dividendCapitalized = $capitalizedArray['capitalized_in_birr'] ? $capitalizedArray['capitalized_in_birr'] : 0;
		$result = mysqli_query($conn, "SELECT SUM(capitalized_in_birr) AS capitalized_in_birr from capitalized where account = '$account' and type = 2 and year=$year and capitalized_status = 4") or die(mysqli_error($conn));
		$payableArray = mysqli_fetch_array($result);
		$this->dividendPayableCapitalized = $payableArray['capitalized_in_birr'] ? $payableArray['capitalized_in_birr'] : 0;
		$result = mysqli_query($conn, "SELECT SUM(capitalized_in_birr) AS capitalized_in_birr from capitalized where account = '$account' and type = 3 and year=$year and capitalized_status = 4") or die(mysqli_error($conn));
		$cashArray = mysqli_fetch_array($result);
		$this->cashPaid = $cashArray['capitalized_in_birr'] ? $cashArray['capitalized_in_birr'] : 0;

		$this->totalRaised = $this->dividendCapitalized + $this->dividendPayableCapitalized + $this->cashPaid;

		$this->totalPaidUpCapital = $this->adjestedBalance + $this->totalRaised;
	}

	private function forNestedFullyBought($conn, $account, $from, $to, $year)
	{
		$sellerTransfer = mysqli_query($conn, "SELECT seller_account from transfer where buyer_account = '$account' and agreement=3 and full_transfer=true and year=$year and status_of_transfer = 4") or die(mysqli_error($conn));
		$fromfullBought = array();
		while ($row = mysqli_fetch_array($sellerTransfer)) {
			$fromfullBought[] = $row;
			$this->fromNestedfullBought[] = $row;
		}
		foreach ($fromfullBought as $value) {
			$sellerAcount = $value['seller_account'];
			$this->forNestedFullyBought2($conn, $sellerAcount, $from, $to, $year);
		}
	}
	private function forNestedFullyBought2($conn, $account, $from, $to, $year)
	{
		$sellerTransfer = mysqli_query($conn, "SELECT seller_account from transfer where buyer_account = '$account' and agreement=3 and full_transfer=true and year=$year and status_of_transfer = 4") or die(mysqli_error($conn));
		$fromfullBought = array();
		while ($row = mysqli_fetch_array($sellerTransfer)) {
			$fromfullBought[] = $row;
			$this->fromNestedfullBought[] = $row;
		}
		foreach ($fromfullBought as $value) {
			$sellerAcount = $value['seller_account'];
			$this->forNestedFullyBought($conn, $sellerAcount, $from, $to, $year);
		}
	}

	private function fromFullyBought($conn, $account, $from, $to, $year)
	{

		$this->forNestedFullyBought($conn, $account, $from, $to, $year);
		foreach ($this->fromNestedfullBought as $value) {
			$sellerAcount = $value['seller_account'];
			$this->cualculation($conn, $sellerAcount, $from, $to, $year, true);
			// if( $this->adjustedBalanceForDividend > 0.00){
			$this->fullyBoughtForAdjustment += $this->adjustedBalanceForDividend;
			$this->forNestedBoughtShare += $this->boughtShare;
			//   $this->forNestedSoldShare=$this->forSoldShare;
			// }
			$this->forBreakdown($conn, $sellerAcount, $from, $to, $year);
			$this->breakdown($conn, $account, $from, $to, $year);
		}
	}
	private function forBreakdown($conn, $account, $from, $to, $year)
	{
		$sellerTransfer = mysqli_query($conn, "SELECT id,total_transfered_in_birr,value_date from transfer where seller_account = '$account' and agreement='both' and year=$year and status_of_transfer = 4") or die(mysqli_error($conn));
		$this->fromSold = array();
		while ($row = mysqli_fetch_array($sellerTransfer)) {
			$this->fromSold[] = $row;
		}
		$buyerTransfer = mysqli_query($conn, "SELECT id,total_transfered_in_birr,value_date from transfer where buyer_account = '$account' and agreement='both' and year=$year and status_of_transfer = 4") or die(mysqli_error($conn));
		//$fromBought=mysqli_fetch_assoc($buyerTransfer);
		$this->fromBought = array();
		while ($row = mysqli_fetch_array($buyerTransfer)) {
			$this->fromBought[] = $row;
		}
		$capitalized = mysqli_query($conn, "SELECT id,capitalized_in_birr,value_date from capitalized where account = '$account' and type=1 and year=$year and capitalized_status = 4") or die(mysqli_error($conn));
		//$fromCapitalized=mysqli_fetch_array($capitalized);
		$this->fromCapitalized = array();
		while ($row = mysqli_fetch_array($capitalized)) {
			$this->fromCapitalized[] = $row;
		}
		$payable = mysqli_query($conn, "SELECT id,capitalized_in_birr,value_date from capitalized where account = '$account' and type=2 and year=$year and capitalized_status = 4") or die(mysqli_error($conn));
		$this->fromPayable = mysqli_fetch_array($payable);
		// $fromPayable=array();
		// while($row=mysqli_fetch_array($payable)){
		//   $fromPayable[]=$row;
		// }
		$cash = mysqli_query($conn, "SELECT id,capitalized_in_birr,value_date from capitalized where account = '$account' and type=3 and year=$year and capitalized_status = 4") or die(mysqli_error($conn));
		//$fromCash=mysqli_fetch_array($cash);
		$this->fromCash = array();
		while ($row = mysqli_fetch_array($cash)) {
			$this->fromCash[] = $row;
		}
	}
	private function breakdown($conn, $account, $from, $to, $year)
	{

		$totalYearDate = $this->dateDiff($from, $to) + 1;

		$soldGet = array();
		$endDate = $to;
		$startDate = $from;
		$soldBreakdowun = array();
		$i = 0;
		foreach ($this->fromSold as $value) {
			$amount = $value['total_transfered_in_birr'];
			$startDate = $from;
			$endDate = $value['value_date'];
			$endDate = date('d-m-Y', strtotime($endDate . ' - 1 days'));
			$diff = $this->dateDiff($startDate, $endDate);
			$dif = $diff + 1;
			$fromSoldTransfer = ($amount * $dif) / $totalYearDate;
			$soldGet[] = $fromSoldTransfer;
			$type = 'sold';
			$id = $value['id'];

			$this->breakdownInsert($conn, $account, $amount, $startDate, $endDate, $dif, $fromSoldTransfer, $id, $type, $year);
			$i++;
		}
		$endDate = $to;
		$startDate = $from;
		$boughtGet = array();
		foreach ($this->fromBought as $value) {
			$amount = $value['total_transfered_in_birr'];
			$startDate = $value['value_date'];
			$endDate = $to;
			//$startDate=date('d-m-Y', strtotime($startDate));
			$diff = $this->dateDiff($startDate, $endDate);
			$dif = $diff + 1;
			$cap_cash = ($amount * $dif) / $totalYearDate;
			$boughtGet[] = $cap_cash;
			$type = 'bought';
			$id = $value['id'];
			$this->breakdownInsert($conn, $account, $amount, $startDate, $endDate, $dif, $cap_cash, $id, $type, $year);
			$i++;
		}
		$startDate = $from;
		$capitalizedGet = array();
		$i = 0;
		foreach ($this->fromCapitalized as $value) {
			$amount = $value['capitalized_in_birr'];
			$startDate = $value['value_date'];
			$endDate = $to;
			//$startDate=date('d-m-Y', strtotime($startDate));
			$diff = $this->dateDiff($startDate, $endDate);
			$dif = $diff + 1;

			$cap_cash = ($amount * $dif) / $totalYearDate;
			$capitalizedGet[] = $cap_cash;
			$type = 'capitalized';
			$id = $value['id'];
			$this->breakdownInsert($conn, $account, $amount, $startDate, $endDate, $dif, $cap_cash, $id, $type, $year);
			$i++;
		}

		$endDate = $to;
		$startDate = $from;
		$cashGet = array();
		$sumCount = 0;
		$cashBreakdown = array();
		$i = 0;
		foreach ($this->fromCash as $value) {
			$amount = $value['capitalized_in_birr'];
			$startDate = $value['value_date'];
			$endDate = $to;
			//$startDate=date('d-m-Y', strtotime($startDate));
			$diff = $this->dateDiff($startDate, $endDate);
			$dif = $diff + 1;
			if ($this->fromPayable && $sumCount == 0) {
				if ($value['capitalized_in_birr'] % 500 != 0 && $value['value_date'] >= $this->fromPayable['value_date']) {
					$amount = $value['capitalized_in_birr'] + $this->fromPayable['capitalized_in_birr'];
					$sumCount++;
				}
			}
			$cap_cash = ($amount * $dif) / $totalYearDate;
			$cashGet[] = $cap_cash;
			$type = 'cash';
			$id = $value['id'];
			$this->breakdownInsert($conn, $account, $amount, $startDate, $endDate, $dif, $cap_cash, $id, $type, $year);

			$i++;
		}

		$this->sumOfAveragePaidupCapital = array_sum($cashGet) + array_sum($capitalizedGet) + array_sum($boughtGet) + array_sum($soldGet);
	}
	private function breakdownInsert($conn, $account, $amount, $startDate, $endDate, $dif, $cap_cash, $id, $type, $year)
	{
		mysqli_query($conn, "INSERT INTO break_down (account,amount,value_date,end_value_date,total_date,avarage_paidup_capital,bk_id,bk_type,year)
	values('$account',$amount,'$startDate','$endDate',$dif,round($cap_cash,2),$id,'$type',$year) 
	ON DUPLICATE KEY UPDATE amount=values(amount),value_date=values(value_date),end_value_date=values(end_value_date),total_date=values(total_date),avarage_paidup_capital=values(avarage_paidup_capital)") or die(mysqli_error($conn));
	}
	public function dividend_report()
	{
		$this->load->view('shareholder/dividend_report');
	}

	public function cash_payment()
	{
		$this->load->view('shareholder/cash_payment');
	}

	public function dividend_capitalized()
	{
		$this->load->view('shareholder/dividend_capitalized');
	}

	public function calculate()
	{
		$this->load->view('shareholder/calculate');
	}
	public function viewdetail()
	{
		$this->load->view('shareholder/viewdetail');
	}
	public function pledged()
	{
		$this->load->view('shareholder/pledged');
	}
	public function convertnum()
	{
		$this->load->view('foreign/convertnum');
	}
	public function blockconfirm()
	{
		$this->load->view('shareholder/blockconfirm');
	}
	public function sharerequest()
	{
		$this->load->view('shareholder/sharerequest');
	}
	public function pledgeconfirm()
	{
		$this->load->view('shareholder/pledgeconfirm');
	}
	public function allocate_money()
	{
		$this->load->view('foreign/allocate_money');
	}
	public function login()
	{
		$this->load->view('sessions/login_form');
	}
	public function edir()
	{
		$this->load->view('Shareholder/edir');
	}
	public function list_company()
	{
		$this->load->view('Shareholder/list_company');
	}
	public function ngo()
	{
		$this->load->view('Shareholder/ngo');
	}
	public function individual()
	{
		$this->load->view('Shareholder/individual');
	}

	public function list_church()
	{
		$this->load->view('Shareholder/list_church');
	}
	public function listed()
	{
		$this->load->view('shareholder/listed');
	}
	public function upload_shareholder()
	{
		$this->load->view('shareholder/upload_shareholder');
	}
	public function block()
	{
		$this->load->view('shareholder/block');
	}
	public function dividend()
	{
		$this->load->view('shareholder/dividend');
	}
	public function returned()
	{
		$this->load->view('foreign/returned');
	}

	public function upload_sharerequest()
	{
		$this->load->view('shareholder/upload_sharerequest');
	}

	public function list_requested_share()
	{
		$this->load->view('shareholder/list_requested_share');
	}
	public function transfer()
	{
		$this->load->view('shareholder/transfer');
	}

	public function transfer_blocked_message()
	{
		$this->load->view('shareholder/transfer_blocked_message');
	}




	public function returnedtorequest()
	{
		$this->load->view('foreign/returnedtorequest');
	}
	public function npregister()
	{
		$this->load->view('foreign/npregister');
	}

	public function authorize()
	{
		$this->load->view('foreign/authorize');
	}
	public function canvassing_excel()
	{
		$this->load->view('foreign/canvassing_excel');
	}

	public function authorize_request()
	{

		$this->load->view('foreign/slipprint');
	}

	public function tradefinance()
	{

		$this->load->view('foreign/tradefinance');
	}

	public function authorized()
	{

		$this->load->view('foreign/authorized');
	}

	public function audit()
	{

		$this->load->view('foreign/audit');
	}
	public function audited()
	{

		$this->load->view('foreign/audited');
	}

	public function add_prefix()
	{

		$this->load->view('foreign/add_prefix');
	}

	public function branch()
	{

		$this->load->view('foreign/branch');
	}
	public function upload_allotement()
	{

		$this->load->view('shareholder/upload_allotement');
	}


	public function priority()
	{

		$this->load->view('foreign/priority');
	}

	public function changepass()
	{

		$this->load->view('sessions/changepass');
	}

	public function allocate_lists_for_manager()
	{
		$this->load->view('foreign/allocate_lists_for_manager');
	}
	public function editauthorised_request()
	{
		$this->load->view('foreign/editauthorize');
	}
	public function allocatedlist()
	{
		$this->load->view('foreign/allocatedlist');
	}
	public function edittf()
	{
		$this->load->view('foreign/edittf');
	}
	public function allocatelist()
	{
		$this->load->view('foreign/allocatelist');
	}
	public function slipprint()
	{
		$this->load->view('shareholder/slipprint');
	}
	public function createshareholder()
	{
		$this->load->view('shareholder/createshareholder');
	}

	// Validate and store registration data in database
	public function allocated_request()
	{

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		// Check validation for user input in SignUp form
		//$this->form_validation->set_rules('registration_no','Registration number','trim|required|xss_clean');
		$this->form_validation->set_rules('idn', 'ID', 'trim|required|xss_clean');
		$this->form_validation->set_rules('allocated_date', 'Allocated date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('allocated_amount', 'Allocated', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			echo "error";
		} else {

			$data = array(

				//'registration_no' => $this->input->post('registration_no'),
				'id' => $this->input->post('idnum'),
				'allocated_date' => $this->input->post('allocated_date'),
				'allocated' => $this->input->post('allocated_amount'),
				'status' => $this->input->post('allocate_status')

			);

			//$registration = $this->foreign_model->select_rforeign($data['registration_no'],$data);

			//if($registration == FALSE){

			$result = $this->foreign_model->create_allocate($data);

			if ($result == TRUE) {

				$this->load->view('foreign/allocated', $data);
				$data['message_display'] = ' Allocated Successfully !';
				//redirect(current_url());
			} else {

				$this->load->view('foreign/allocated', $data);
				$data['message_display'] = 'There is a problem of creating allocation!';
			}
			/*} else {
	
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);
	 //redirect(current_url());
}*/
		}
	}



	public function reason_shareholder()
	{

		// Check validation for user input in SignUp form
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('reason', 'reason', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('shareholder/blockconfirm');
		} else {
			$data = array(
				'remark' => $this->input->post('reason')
			);

			$result = $this->priority_model->create_reason($data);

			if ($result == TRUE) {

				$data['message_display'] = 'Shareholder Blocked Successfully !';
				$this->load->view('shareholder/block', $data);
				//redirect(current_url());

			} else {
				$data['message_display'] = 'Username already exist!';
				$this->load->view('sessions/user', $data);
			}
		}
	}


	public function new_branch()
	{

		// Check validation for user input in SignUp form
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('foreign/branch');
		} else {
			$data = array(
				'name' => $this->input->post('branch')
			);

			$result = $this->branch_model->create_branch($data);

			if ($result == TRUE) {

				$data['message_display'] = 'Branch Created Successfully !';
				$this->load->view('foreign/branch', $data);
				//redirect(current_url());

			} else {
				$data['message_display'] = 'Username already exist!';
				$this->load->view('sessions/user', $data);
			}
		}
	}

	public function change_pass()
	{

		// Check validation for user input in SignUp form
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('newpass', 'New password', 'trim|required|matches[confirmpass]|xss_clean');
		$this->form_validation->set_rules('confirmpass', 'Confirm Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {

			$this->load->view('sessions/changepass');
		} else {

			$data = array(
				'newpass' => $this->input->post('newpass'),
				'confirmpass' => $this->input->post('confirmpass'),
				'username' => $this->input->post('username')
			);

			$confirm_pass = $data['confirmpass'];
			$username = $data['username'];
			if ($data['newpass'] != $data['confirmpass']) {

				$data['message_display'] = 'New password must be the same from confirm password !';
			}

			$result = $this->login_database->change_pass($confirm_pass, $username);

			if ($result == TRUE) {

				$data['message_display'] = 'Password Changed Successfully !';
				$this->load->view('sessions/changepass', $data);
			} else {
				$data['message_display'] = 'New password must be different from old password !';
				$this->load->view('sessions/changepass', $data);
			}
		}
	}


	public function new_prefix()
	{

		// Check validation for user input in SignUp form
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		$this->form_validation->set_rules('prefix', 'Prefix', 'trim|required|xss_clean');
		$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('foreign/add_prefix');
		} else {
			$data = array(
				'code' => $this->input->post('prefix'),
				'branch' => $this->input->post('branch')
			);

			$result = $this->prefix_model->create_prefix($data);

			if ($result == TRUE) {

				$data['message_display'] = 'Prefix Created Successfully !';
				$this->load->view('foreign/add_prefix', $data);
				//redirect(current_url());

			} else {
				$data['message_display'] = 'Username already exist!';
				$this->load->view('sessions/user', $data);
			}
		}
	}



	public function update_shareholder()
	{

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('city', 'city', 'trim|xss_clean');
		$this->form_validation->set_rules('sub_city', 'sub_city', 'trim|xss_clean');
		$this->form_validation->set_rules('woreda', 'woreda', 'trim|xss_clean');
		$this->form_validation->set_rules('house_no', 'house no', 'trim|xss_clean');
		$this->form_validation->set_rules('pobox', 'pobox', 'trim|xss_clean');
		$this->form_validation->set_rules('telephone_residence', 'telephone residence', 'trim|xss_clean');
		$this->form_validation->set_rules('telephone_office', 'telephone_office', 'trim|xss_clean');
		$this->form_validation->set_rules('mobile', 'mobile', 'trim|xss_clean');
		//required|
		$account = $this->input->post('account_no');
		if (!$this->form_validation->run()) {
			$message = 'form validation error!';
			redirect('shareholder/edit_shareholder?edit=' . $message . '&acc=' . $account);
		} else {
			$data = array(

				//'registration_no' => $this->input->post('registration_no'),
				'account_no' => $this->input->post('account_no'),
				'name' => $this->input->post('name'),
				'share_type' => $this->input->post('share_type'),
				'member' => $this->input->post('member'),
			);

			$data2 = array(
				'account' => $this->input->post('account_no'),
				'city' => $this->input->post('city'),
				'sub_city' => $this->input->post('sub_city'),
				'woreda' => $this->input->post('woreda'),
				'house_no' => $this->input->post('house_no'),
				'pobox' => $this->input->post('pobox'),
				'telephone_residence' => $this->input->post('telephone_residence'),
				'telephone_office' => $this->input->post('telephone_office'),
				'mobile' => $this->input->post('mobile'),
			);
			// var_dump("hello");
			$result = $this->shareholder_model->edit_shareholder_address($data2);
			$result2 = $this->shareholder_model->edit_shareholder($data);

			if ($result || $result2) {

				$message = 'Request Edited Successfully !';
				// $this->load->view('shareholder/edit_shareholder', $data);
				redirect('shareholder/edit_shareholder?edit=' . $message . '&acc=' . $account);
			} else {
				$message = 'There is a problem of editing shareholder date or you do not have any change!';
				redirect('shareholder/edit_shareholder?edit=' . $message . '&acc=' . $account);
			}
			/*} else {
	
	$data['message_display'] = 'Request Created Successfully !';
	$this->load->view('foreign/register', $data);
	 //redirect(current_url());
}*/
		}
	}


	public function request_exists($key)
	{
		$this->foreign_model->request_exists($key);
	}

	public function new_shareholder_from_existing()
	{

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('account_no', 'account no', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('share_type', 'Share Type', 'trim|xss_clean');
		$this->form_validation->set_rules('city', 'city', 'trim|xss_clean');
		$this->form_validation->set_rules('sub_city', 'sub_city', 'trim|xss_clean');
		$this->form_validation->set_rules('woreda', 'woreda', 'trim|xss_clean');
		$this->form_validation->set_rules('house_no', 'house no', 'trim|xss_clean');
		$this->form_validation->set_rules('pobox', 'pobox', 'trim|xss_clean');
		$this->form_validation->set_rules('telephone_residence', 'telephone residence', 'trim|xss_clean|numeric');
		$this->form_validation->set_rules('telephone_office', 'telephone_office', 'trim|xss_clean|numeric');
		$this->form_validation->set_rules('mobile', 'mobile', 'trim|xss_clean|numeric');
		$this->form_validation->set_rules('member', 'member', 'trim|xss_clean');
		$this->form_validation->set_rules('remark', 'remark', 'trim|xss_clean');


		if (!$this->form_validation->run()) {
			header('location:shareholder/create_shareholder_from_existing');
		} else {
			$currentDate = date('Y-m-d');
			$select_budget_year = mysqli_query($this->conn, "SELECT * FROM budget_year WHERE budget_status =  1");
			$budget_row = mysqli_fetch_array($select_budget_year);
			$from = "";
			$to = "";
			$year = 0;
			if ($budget_row) {
				$from = $budget_row['budget_from'];
				$to = $budget_row['budget_to'];
				$year = $budget_row['id'];
			}

			$data = array(

				//'registration_no' => $this->input->post('registration_no'),
				'account_no' => $this->input->post('account_no'),
				'name' => $this->input->post('name'),
				'share_type' => $this->input->post('share_type'),
				'member' => $this->input->post('member'),
				'currentYear_status' => 3,
				'nextYear_status' => 3,
				'created_at' => "$currentDate",
				'created_year' => $year,
				'maker' => $this->input->post('maker'),
			);
			$data2 = array(
				'account' => $this->input->post('account_no'),
				'city' => $this->input->post('city'),
				'sub_city' => $this->input->post('sub_city'),
				'woreda' => $this->input->post('woreda'),
				'house_no' => $this->input->post('house_no'),
				'pobox' => $this->input->post('pobox'),
				'telephone_residence' => $this->input->post('telephone_residence'),
				'telephone_office' => $this->input->post('telephone_office'),
				'mobile' => $this->input->post('mobile'),
				'remark' => $this->input->post('remark'),
			);


			$check = $this->shareholder_model->check_account_no($data);
			if ($check) {

				header('location:shareholder/create_shareholder_from_existing?message_display=true');
			} else {
				$result = $this->shareholder_model->create_new_shareholder($data);
				$message_display = "";
				if ($result) {
					$result1 = $this->shareholder_model->create_shareholder_address($data2);
					$message_display = '';
					if ($result && $result1) {
						$message_display = 'yes';
					} else {
						$message_display = 'no';
					}
				}
				header('location:shareholder/create_shareholder_from_existing?cash=' . $message_display);
			}
		}
	}

	public function new_shareholder()
	{

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('account_no', 'account no', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('total_paidup_capital_inbirr', 'total paidup capital inbirr', 'trim|required|xss_clean|numeric');
		$this->form_validation->set_rules('share_type', 'Share Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'city', 'trim|xss_clean');
		$this->form_validation->set_rules('sub_city', 'sub_city', 'trim|xss_clean');
		$this->form_validation->set_rules('woreda', 'woreda', 'trim|xss_clean');
		$this->form_validation->set_rules('house_no', 'house no', 'trim|xss_clean');
		$this->form_validation->set_rules('pobox', 'pobox', 'trim|xss_clean');
		$this->form_validation->set_rules('telephone_residence', 'telephone residence', 'trim|xss_clean|numeric');
		$this->form_validation->set_rules('telephone_office', 'telephone_office', 'trim|xss_clean|numeric');
		$this->form_validation->set_rules('mobile', 'mobile', 'trim|xss_clean|numeric');
		$this->form_validation->set_rules('member', 'member', 'trim|xss_clean');
		$this->form_validation->set_rules('remark', 'remark', 'trim|xss_clean');


		if ($this->form_validation->run() == FALSE) {
			header('location:shareholder/createshareholder');
		} else {

			$currentDate = date('Y-m-d');
			$select_budget_year = mysqli_query($this->conn, "SELECT * FROM budget_year WHERE budget_status =  1");
			$budget_row = mysqli_fetch_array($select_budget_year);
			$from = "";
			$to = "";
			$year = 0;
			if ($budget_row) {
				$from = $budget_row['budget_from'];
				$to = $budget_row['budget_to'];
				$year = $budget_row['id'];
			}

			$data = array(

				//'registration_no' => $this->input->post('registration_no'),
				'account_no' => $this->input->post('account_no'),
				'name' => $this->input->post('name'),
				'share_type' => $this->input->post('share_type'),
				'member' => $this->input->post('member'),
				'currentYear_status' => 3,
				'nextYear_status' => 3,
				'created_at' => "$currentDate",
				'created_year' => $year,
				'maker' => $this->input->post('maker'),
			);
			$data2 = array(
				'account' => $this->input->post('account_no'),
				'city' => $this->input->post('city'),
				'sub_city' => $this->input->post('sub_city'),
				'woreda' => $this->input->post('woreda'),
				'house_no' => $this->input->post('house_no'),
				'pobox' => $this->input->post('pobox'),
				'telephone_residence' => $this->input->post('telephone_residence'),
				'telephone_office' => $this->input->post('telephone_office'),
				'mobile' => $this->input->post('mobile'),
				'remark' => $this->input->post('remark'),
			);
			$data3 = array(
				'account' => $this->input->post('account_no'),
				'value_date' => $this->input->post('value_date'),
				'total_paidup_capital_inbirr' => $this->input->post('total_paidup_capital_inbirr'),
				'balance_status' => 3,
				'year' => "$currentDate",
			);


			$check = $this->shareholder_model->check_account_no($data);
			$select_budget_year = mysqli_query($this->conn, "SELECT * FROM budget_year WHERE budget_status =  1");
			$budget_row = mysqli_fetch_array($select_budget_year);
			$startd = "";
			$endd = "";
			if ($budget_row) {
				$startd = $budget_row['budget_from'];
				$endd = $budget_row['budget_to'];
			}

			$value_d = $data['value_date'];
			$currentDate = $data['value_date'];
			$currentDate = date('Y-m-d', strtotime($currentDate));



			if ($check) {

				header('location:shareholder/createshareholder?message_display=true');
			} elseif ($data['total_paidup_capital_inbirr'] == 0) {

				echo '<script>alert("Value  is incorrect!");</script>';
			} elseif ($data['total_paidup_capital_inbirr'] > 0 && $data['value_date'] == "") {

				echo '<script>alert("Value date is empty please enter value date!");</script>';
				//header('location:createshareholder?error_value=created');

			} elseif (($currentDate < $startd) || ($currentDate > $endd)) {

				echo '<script>alert("Value date is out of budget year!");</script>';
			} elseif ($data['total_paidup_capital_inbirr'] > 0) {

				$result = $this->shareholder_model->create_new_shareholder($data);
				$message_display = "";
				if ($result) {
					$result1 = $this->shareholder_model->create_shareholder_address($data2);
					$result2 = $this->shareholder_model->create_balance($data3);
					$message_display = '';
					if ($result && $result1 && $result2) {
						$message_display = 'yes';
					} else {
						$message_display = 'no';
					}
				}

				header('location:shareholder/createshareholder?cash=' . $message_display);
			}
		}
	}


	// Validate and store registration data in database
	public function new_share_request()
	{


		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$this->form_validation->set_rules('account_no', 'Account No', 'trim|required|xss_clean');
		$this->form_validation->set_rules('application_date', 'Application Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('total_share', 'Total Share Requested', 'trim|required|xss_clean');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');


		if ($this->form_validation->run() == FALSE) {
			header('location:shareholder/sharerequest');
		} else {
			$currentDate = date('Y-m-d');
			$data = array(
				'account' => $this->input->post('account_no'),
				'application_date' => $this->input->post('application_date'),
				'total_share_request' => $this->input->post('total_share'),
				'share_request_status ' => 3,
				'share_request_status ' => "$currentDate"
			);

			$result = $this->shareholder_model->create_request($data);

			if ($result == TRUE) {

				$data['message_display'] = 'Share Request Created Successfully !';
				header('location:shareholder/sharerequest');
				//redirect(current_url());

			} else {
				$data['message_display'] = 'Share Request Faild to Register ';
				$this->load->view('sessions/user', $data);
			}
		}
	}
	// Check for user login process
	public function user_login_process()
	{

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE) {

			$this->load->view('sessions/login_form');
		} else {

			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);


			$result = $this->login_database->login($data);
			if ($result) {

				$username = $this->input->post('username');
				$result = $this->login_database->read_user_information($username);



				$session_data =
					array(
						'username' => $result[0]->user_name,
						'id' => $result[0]->id,
						'role' => $result[0]->role,
						'password' => $result[0]->user_password,
					);

				// Add user data in session
				$this->session->set_userdata('logged_in', $session_data);

				if ($this->$session_data['password'] == '123456') {

					$this->load->view('foreign/changepass');
				} else {

					$this->load->view('layouts/admin_page');
				}
			} else {
				$data = array(
					'error_message' => 'Invalid Username or Password'
				);
				$this->load->view('sessions/login_form', $data);
			}
		}
	}
	// Logout from admin page
	public function logout()
	{

		// Removing session data
		$sess_array = array(
			'username' => ''
		);
		$this->session->unset_userdata('logged_in', $sess_array);
		$data['message_display'] = 'Successfully Logout';
		$this->load->view('sessions/login_form', $data);
	}
}
